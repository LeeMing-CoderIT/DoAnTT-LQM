<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Storage;
use Datatables;

class ManagerCategoriesController extends Controller
{
    public $data = [];

    public function __construct(){
        $this->data = json_decode(Storage::get('public/files/infoWebsite.json'), true);
        $this->data['sidebar'] = json_decode(Storage::get('public/files/sidebarAdmin.json'), true);
        $this->data['folder'] = "categories";
    }

    public function index(Request $request)
    {
        $this->data['title'] = "Quản lý danh sách thể loại";
        $this->data['path_active'] = $request->path();
        return view('admins.categories.index', $this->data);
    }

    public function all(Request $request)
    {
        $data = Category::select('*')->get();
        foreach ($data as $key => $value) {
            $data[$key]->index = $key+1;
            $data[$key]->stories = $value->stories()->count();
        }
        if($request->ajax()){
            return (datatables()->of($data)
            ->addColumn('action', 'admins.categories.action-buttons')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true));
        }
        return response()->json($data);
    }

    public function show(Request $request, Category $category)
    {
        return response()->json($category);
    }

    public function add(Request $request)
    {
        $response = []; $response['success'] = false;
        $data = $request->only('name', 'slug', 'description');
        try {
            $catagory = Category::create($data);
            $response['success'] = true;
            $response['msg'] = [
                'type'=>'success', 'msg'=>'Thêm thể loại thành công.', 'data'=>$catagory
            ];
        } catch (\Throwable $th) {
            $response['msg'] = $th; 
        }
        return response()->json($response);
    }

    public function edit(Request $request, Category $category)
    {
        $response = []; $response['success'] = false;
        $data = $request->only('name', 'slug', 'description');
        try {
            $category->update($data);
            $response['success'] = true;
            $response['msg'] = [
                'type'=>'success', 'msg'=>'Cập nhật thể loại thành công.'
            ];
        } catch (\Throwable $th) {
            $response['msg'] = $th; 
        }
        return response()->json($response);
    }

    public function delete(Request $request, Category $category)
    {
        $data = []; $data['success'] = false; $data['msg'] = 'Xóa thể loại thất bại.';
        try {
            if($category->delete()){
                $data['success'] = true; 
                $data['msg'] = 'Xóa thể loại thành công.';
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return response()->json($data);
    }

    public function slugExist(Request $request){
        $success = false;
        if($request->has('slug')){
            $success = Category::where('slug', $request->slug)->get()->count() == 0;
        }
        return response()->json($success);
    }
}
