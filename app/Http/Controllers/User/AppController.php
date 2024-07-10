<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\SettingUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Story;
use App\Models\ViewsStory;
use App\Models\RequestAddStory;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Auth;
use \Illuminate\Support\Facades\Hash;

class AppController extends Controller
{
    public $data = [];

    protected function musty_hot(){
        $all_story_views = ViewsStory::all(); $all_view = 0;
        foreach ($all_story_views as $value) {
            $all_view += $value->views_year;
        }
        return (int)ceil($all_view/$all_story_views->count());
    }

    public function __construct(){
        $this->data = json_decode(Storage::get('public/files/infoWebsite.json'), true);
        $this->musty_hot = $this->musty_Hot();
        $this->data['categories'] = Category::all();
        $this->data['languages'] = json_decode(Storage::get('public/files/languages.json'), true);
    }

    protected function languageSetup(){
        if(Auth::check()){
            foreach ($this->data['languages'] as $key => $value) {
                if($value['language'] == Auth::user()->settings()->language){
                    $this->data['lang'] = $value;
                }
            }
        }
    }

    public function home(){
        return view("users.home", $this->data);
    }

    public function filter(Request $request){
        return view("users.filter", $this->data);
    }

    public function category(Request $request){
        $this->data['category_info'] = Category::where("slug", $request->category)->first();
        // dd($this->data['category_info']->stories());
        return view("users.category", $this->data);
    }

    public function story(Request $request){
        $this->data['story_info'] = Story::where("slug", $request->story)->first();
        $this->data['story_info']->infoViews()->addView();
        if($this->data['story_info']){
            return view("users.story", $this->data);
        }else{
            return view("errors.404");
        }
    }

    public function searchStories(Request $request){
        $data = []; $data['success'] = true; $offset = 0; $limit = $request->max ?? 16;
        if($request->has('page')){
            $offset = ($request->page - 1) * $limit;
        }
        //số lượng cần lấy
        $stories = Story::select(['stories.*']);//stories.
        //truy vấn theo danh sách cần thiết
        if($request->has('list') && $request->list != '*'){
            if($request->list == 'hot'){
                $stories->join('views_stories', 'stories.id', '=', 'views_stories.story_id');
                $stories->where('views_stories.views_year', '>=', $this->musty_hot());
                $stories->orderBy('views_stories.views_year', 'desc');
            }
            elseif($request->list == 'hot-day'){
                $stories->join('views_stories', 'stories.id', '=', 'views_stories.story_id');
                $stories->orderByRaw("(JSON_EXTRACT(views_stories.views_day, '$.views')) DESC");
            }
            elseif($request->list == 'hot-month'){
                $stories->join('views_stories', 'stories.id', '=', 'views_stories.story_id');
                $stories->orderByRaw("(JSON_EXTRACT(views_stories.views_month, '$.views')) DESC");
            }
            elseif($request->list == 'new'){
                $stories->whereRaw('DATE_ADD(stories.created_at,INTERVAL 1 MONTH) > NOW()');
                $stories->orderBy('stories.created_at', 'desc');
            }
            else{
                $stories->orderBy('stories.updated_at', 'desc');
            }
        }
        $stories->orderBy('stories.id', 'desc');
        //truy vấn theo tình trạng của truyện
        if($request->has('status') && $request->status != '*'){
            $stories->where('stories.status', $request->status);
        }
        //truy vấn theo chuỗi tìm kiếm nếu có
        if($request->has('keywords') && $request->keywords){
            $stories->where('stories.name', 'like', '%'.$request->keywords.'%');
            $stories->orWhere('stories.author', 'like', '%'.$request->keywords.'%');
        }
        //truy vấn theo thể loại của truyện
        if($request->has('categories_id') && $request->categories_id != '*'){
            if(is_array($request->categories_id)){
                foreach($request->categories_id as $category_id){
                    $stories->whereJsonContains('stories.categories', $category_id);
                }
            }else{
                $stories->whereJsonContains('stories.categories', $request->categories_id);
            }
        }
        //truy vấn theo số lượng chương truyện của truyện
        if($request->has('chaps') && $request->chaps[0] && $request->chaps[1]){
            $from = (int)($request->chaps[0]>$request->chaps[1])?$request->chaps[1]:$request->chaps[0];
            $to = (int)($request->chaps[0]<$request->chaps[1])?$request->chaps[1]:$request->chaps[0];
            $stories->select(['stories.*',\DB::raw('COUNT(`chapters`.`id`) as `full_chapters`')]);
            $stories->join('chapters', 'stories.id', '=', 'chapters.story_id')->groupBy('stories.id');
            $stories->havingBetween('full_chapters', [$from, $to]);
        }try {
            $full_stories = $stories->get();
            $data['stories'] = $stories->limit($limit)->offset($offset)->get();
            $data['pages'] = ($data['stories']->count())?ceil($full_stories->count() / $data['stories']->count()):1;
            //Chap mới nhất của truyện
            foreach($data['stories'] as $key => $story){
                $data['stories'][$key]->isHot = $story->isHot();
                $data['stories'][$key]->isNew = $story->isNew();
                $data['stories'][$key]->new_chapter = $story->newChapter();
            }
            if($data['stories']->count() <= 0) $data['success'] = false;
        } catch (\Throwable $th) {
            $data['success'] = false;
        }
        // dd($data, $request->all(), $stories->get());
        return response()->json($data);
    }
    public function loadCategories(Request $request){
        return response()->json(Category::all());
    }

    public function loadChap(Request $request){
        if($request->has('story') && $request->story){
            $story = Story::where('slug', $request->story);
            $limit = $request->show ?? 50;
            $offset = 0;
            if($limit != '*') $offset = ($request->page-1 ?? 0)*$limit;
            $data = $story->first()->chapters($limit,$offset);
        }
        // dd($data);
        return response()->json($data ?? []);
    }

    public function listen(Request $request){
        $this->data['story_info'] = Story::where("slug", $request->story)->first();
        $this->data['chapter_id'] = $request->chap;
        return view("users.listen", $this->data);
    }

    public function showChapter(Request $request){
        if($request->has('story') && $request->has('chapter')){
            $data['token'] = $request->token;
            $story = Story::where('slug', $request->story)->first();
            $story->infoViews()->addView();
            $data['chapter'] = $story->findChapter($request->chapter);
            $data['nextChap'] = $story->findChapter($request->chapter+1);
            $data['prevChap'] = $story->findChapter($request->chapter-1);
            $story->infoViews()->addHistory($data['chapter']);
        }
        return response()->json($data??[]);
    }

    public function saveHistory_paragraph(Request $request){
        $response = [
            'type'=>'error',
            'msg' =>'error'
        ];
        try {
            if($request->has('story') && $request->has('chapter')){
                $story = Story::where('slug', $request->story)->first();
                $data['chapter'] = $story->findChapter($request->chapter);
                $story->infoViews()->addHistory($data['chapter'], (int)$request->paragraph);
                $response = [
                    'data' => $data,
                    'type'=>'success',
                    'msg' =>'success'
                ];
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return response()->json($response);
    }

    public function infoUser(){
        if(Auth::check()){
            $this->languageSetup();
            return view("users.infoUser", $this->data);
        }else{
            return view("errors.404");
        }
    }

    public function postInfoUser(Request $request){
        // dd($request->avatar);
        $data = $request->only('fullname', 'phone');
        if(Auth::check()){
            if($request->avatar){
                $data['avatar'] = time().'_'.$request->avatar->getClientOriginalName();
                $request->avatar->move(public_path('storage/images/users'), $data['avatar']);
                Storage::delete('public/images/users/'.Auth::user()->avatar);
            }
            Auth::user()->update($data);
            return back()->with('msg', 'Cập nhật thành công.')->with('type', 'success');
        }
        return back()->with('msg', 'Tài khoản không tồn tại.')->with('type', 'danger');
    }

    public function postInfoUserSetting(Request $request){
        $data = $request->only('background', 'language', 'speech');
        if(Auth::check()){
            $data['background'] = (int)$data['background'];
            $data['speech'] = (float)$data['speech'];
            // dd($data);
            Auth::user()->settings()->update($data);
            return back()->with('msg', 'Cập nhật thành công.')->with('type', 'success')->with('form', 'form-settings');
        }
        return back()->with('msg', 'Tài khoản không tồn tại.')->with('type', 'danger')->with('form', 'form-settings');
    }

    public function changeSpeech(Request $request){
        $data = $request->only('speech');
        $response = [
            'type'=>'error',
            'msg' =>'error'
        ];
        try {
            if(Auth::check()){
                $data['speech'] = (float)$data['speech'];
                Auth::user()->settings()->update($data);
                $response = [
                    'data' => $data,
                    'type'=>'success',
                    'msg' =>'success'
                ];
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return response()->json($response);
    }

    public function infoUserAllRequest(Request $request){
        $data = RequestAddStory::select('*')->where('user_id', Auth::user()->id)->get();
        foreach ($data as $key => $value) {
            $data[$key]->index = $key+1;
        }
        if($request->ajax()){
            return (datatables()->of($data)
            ->addColumn('action', 'users.blocks.action-request')
            ->addColumn('status-alert', 'users.blocks.status-request')
            ->rawColumns(['action','status-alert'])
            ->addIndexColumn()
            ->make(true));
        }
        // dd($data);
        return response()->json($data);
    }

    public function infoUserAllManager(Request $request){
        $data = Auth::user()->hasManagerStories();
        foreach ($data as $key => $value) {
            $data[$key]->index = $key+1;
            $data[$key]->chapters = $value->chapters()->count();
        }
        if($request->ajax()){
            return (datatables()->of($data)
            ->addColumn('list_categories', 'users.blocks.categories-list')
            ->addColumn('status', 'users.blocks.status')
            ->addColumn('action', 'users.blocks.action-manager')
            ->rawColumns(['list_categories', 'status', 'action'])
            ->addIndexColumn()
            ->make(true));
        }
        // dd($data);
        return response()->json($data);
    }

    public function showHistory(Request $request){
        $data = [];
        if(Auth::check()){
            $data = Auth::user()->showHistory();
            foreach ($data as $key => $value) {
                $data[$key]['index'] = $key+1;
            }
            // dd($data);
            if($request->ajax()){
                return (datatables()->of($data)
                ->addColumn('action', 'users.blocks.action-history')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true));
            }
            return $data;
        }
        return response()->json($data);
    }

    public function postChangePass(Request $request){
        if(Auth::check()){
            $request->validate([
                'password' => ['required', function($attr, $value, $fail){
                    // dd($attr, $value, $fail);
                    if(!Hash::check($value, Auth::user()->password)){
                        $fail('Mật khẩu hiện tại không chính xác');
                    }
                }],
                'new_password' => 'required',
                're_password' => 'required|same:new_password',
            ], [
                'password.required' => 'Mật khẩu hiện tại không được bỏ trống',
                'new_password.required' => 'Mật khẩu mới không được bỏ trống',
                're_password.required' => 'Nhập lại mật khẩu mới không được bỏ trống',
                're_password.same' => 'Nhập lại mật khẩu mới không trùng khớp'
            ]);
            
            Auth::user()->update(['password' => bcrypt($request->password)]);
            return back()->with('msg', 'Đổi mật khẩu thành công.')->with('type', 'success')->with('form', 'form-change-pass');
        }
        return back()->with('msg', 'Tài khoản không tồn tại.')->with('type', 'danger')->with('form', 'form-change-pass');
    }

    public function postRequestStory(Request $request){
        $source = [
            'truyenfull' => 'https://truyenfull.vn'
        ];
        if(Auth::check()){
            $request->validate([
                'source' => ['required', function($attr, $value, $fail) use ($source){
                    if(!isset($source[$value])){
                        $fail('Nguồn truyện chưa được hỗ trợ.');
                    }
                }],
                'link' => ['required', function($attr, $value, $fail) use ($source, $request){
                    //https://truyenfull.vn/mau-xuyen-nghich-tap-boss-than-bi-dung-treu-choc-lung-tung/
                    if(strpos($value, $source[$request->source]) !== 0){
                        $fail('Đường dẫn truyện không chính xác');
                    }
                }],
            ], [
                'source.required' => 'Nguồn truyện không được bỏ trống',
                'link.required' => 'Đường dẫn truyện không được bỏ trống',
            ]);
            $data = $request->only('source', 'link');
            $data['user_id'] = Auth::user()->id;
            RequestAddStory::create($data);
            return back()->with('msg', 'Gửi yêu cầu thành công.')->with('type', 'success')->with('form', 'form-all-request');
        }
        return back()->with('msg', 'Tài khoản không tồn tại.')->with('type', 'danger')->with('form', 'form-request-story');
    }
}
