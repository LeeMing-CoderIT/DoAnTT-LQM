<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\ViewsStory;
use Storage;
use Datatables;
use App\Http\Controllers\CrawlDataController;

class ManagerStoriesController extends Controller
{
    public $data = [];

    public function __construct(){
        $this->data = json_decode(Storage::get('public/files/infoWebsite.json'), true);
        $this->data['sidebar'] = json_decode(Storage::get('public/files/sidebarAdmin.json'), true);
        $this->data['folder'] = "stories";
    }

    public function index(Request $request)
    {
        $this->data['title'] = "Quản lý danh sách truyện";
        return view('admins.stories.index', $this->data);
    }

    public function all(Request $request)
    {
        $data = Story::select('*')->orderByDesc('id')->get();
        foreach ($data as $key => $value) {
            $data[$key]->index = $key+1;
            $data[$key]->chapters = $value->chapters()->count();
        }
        if($request->ajax()){
            return (datatables()->of($data)
            ->addColumn('list_categories', 'admins.blocks.categories-list')
            ->addColumn('status', 'admins.blocks.status')
            ->addColumn('action', 'admins.stories.action-buttons')
            ->rawColumns(['list_categories', 'status', 'action'])
            ->addIndexColumn()
            ->make(true));
        }
        return response()->json($data);
    }

    public function show(Request $request, Story $story)
    {
        if($request->ajax()){
            return response()->json($story);
        }
        $this->data['title'] = "Quản lý truyện: " . $story->name;
        $this->data['story'] = $story; $this->data['new_chapter'] = $story->newChapter();
        // dd($this->data['story']->source);
        return view('admins.stories.show', $this->data);
    }

    public function add(Request $request)
    {
        $response = []; $response['success'] = false;
        $data = $request->only('author', 'name', 'slug', 'image', 'categories', 'status', 'description');
        try {
            if($request->has('source')){
                $data['source'] = $request->source;
                $base64Img = file_get_contents($data['image']);
                $ext = pathinfo($data['image'], PATHINFO_EXTENSION) ?? 'jpg';
                $new_file = $data['slug'].'.'.$ext;
                $full_path = 'public/photos/1/images/'.$new_file;
                Storage::put($full_path, $base64Img);
                $data['image'] = asset('/storage/photos/1/images/'.$new_file);
            }
            $image_render = explode('storage',$data['image']);
            $data['image'] = '/storage'.$image_render[1];
            $story = Story::create($data);
            $data_view = [
                'story_id' => $story->id,
            ];
            if($request->has('user')) $data_view['manager_users'] = json_encode([(int)$request->user], JSON_UNESCAPED_UNICODE);
            ViewsStory::create($data_view);
            $response['data'] = $data;
            $response['data_view'] = $data_view;
            $response['success'] = true;
            $response['msg'] = [
                'type'=>'success', 'msg'=>'Thêm truyện thành công.'
            ];
        } catch (\Throwable $th) {
            $response['msg'] = [
                'type'=>'error', 'msg'=>'Thêm truyện thất bại.'
            ]; 
        }
        return response()->json($response);
    }

    public function edit(Request $request, Story $story)
    {
        $response = []; $response['success'] = false;
        $data = $request->only('author', 'name', 'slug', 'image', 'categories', 'status', 'description');
        try {
            $image_render = explode('storage',$data['image']);
            $data['image'] = '/storage'.$image_render[1];
            $story->update($data);
            if(!$story->infoViews()){
                ViewsStory::create([
                    'story_id' => $story->id,
                ]);
            }
            $response['success'] = true;
            $response['msg'] = [
                'type'=>'success', 'msg'=>'Cập nhật truyện thành công.'
            ];
        } catch (\Throwable $th) {
            $response['msg'] = $th; 
        }
        return response()->json($response);
    }

    public function delete(Story $story)
    {
        $response = []; $response['success'] = false; 
        $response['msg'] = [
            'type' => 'error',
            'msg' => 'Xóa truyện thất bại.'
        ];
        try {
            if($story->delete()){
                $response['msg']['msg'] = 'Xóa thông tin truyện thất bại.';
                $story->infoViews()->delete();
                $response['msg']['msg'] = 'Xóa các chương của truyện thất bại.';
                Chapter::where('story_id', $story->id)->delete();
                $response['success'] = true;
                $response['data'] = $story;
                $response['msg'] = [
                    'type' => 'success',
                    'msg' => 'Xóa truyện thành công.'
                ];
            }
        } catch (\Throwable $th) {
            // $response['msg'] = [
            //     'type' => 'error',
            //     'msg' => 'Xóa truyện thất bại.'
            // ];
        }
        return response()->json($response);
    }

    public function slugExist(Request $request){
        $success = false;
        if($request->has('name') && $request->has('author')){
            $success = Story::where('name', $request->name)->where('author', $request->author)->get()->count() == 0;
        }
        return response()->json($success);
    }
}
