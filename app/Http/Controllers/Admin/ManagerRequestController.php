<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use App\Models\RequestAddStory;

class ManagerRequestController extends Controller
{
    public $data = [];

    public function __construct(){
        $this->data = json_decode(Storage::get('public/files/infoWebsite.json'), true);
        $this->data['sidebar'] = json_decode(Storage::get('public/files/sidebarAdmin.json'), true);
        $this->data['folder'] = "requests";
    }

    public function index(Request $request)
    {
        $this->data['title'] = "Quản lý danh sách yêu cầu thêm truyện";
        $this->data['path_active'] = $request->path();
        return view('admins.requests.addStory', $this->data);
    }
    public function allAddStory(Request $request)
    {
        $data = RequestAddStory::select('*')->orderByDesc('id')->orderBy('status')->get();
        foreach ($data as $key => $value) {
            $data[$key]->index = $key+1;
            $data[$key]->user = $value->user();
        }
        // dd($data);
        if($request->ajax()){
            return (datatables()->of($data)
            ->addColumn('user', 'admins.requests.user')
            ->addColumn('action', 'admins.requests.action-buttons')
            ->rawColumns(['user','action'])
            ->addIndexColumn()
            ->make(true));
        }
        return response()->json($data);
    }

    public function showAddStory(Request $request, $addStory){
        $addStory = RequestAddStory::find($addStory);
        return response()->json($addStory);
    }

    public function editAddStory(Request $request, $addStory)
    {
        $addStory = RequestAddStory::find($addStory);
        $response = []; $response['success'] = false;
        $data = $request->only('next', 'status');
        try {
            $addStory->update($data);
            $response['data'] = [$addStory,$data];
            $response['success'] = true;
            $response['msg'] = [
                'type'=>'success', 'msg'=>($data['status']==1)?'Thêm truyện thành công.':'Hủy yêu cầu truyện thành công.'
            ];
        } catch (\Throwable $th) {
            $response['msg'] = [
                'type'=>'error', 'msg'=>($data['status']==1)?'Thêm truyện thất bại.':'Hủy yêu cầu truyện thất bại.'
            ]; 
        }
        return response()->json($response);
    }

    public function deleteAddStory(Request $request, $addStory)
    {
        $addStory = RequestAddStory::find($addStory);
        $response = []; $response['success'] = false;
        try {
            $addStory->delete();
            $response['success'] = true;
            $response['msg'] = [
                'type'=>'success', 'msg'=>'Xóa yêu cầu truyện thành công.'
            ];
        } catch (\Throwable $th) {
            $response['msg'] = [
                'type'=>'error', 'msg'=>'Xóa yêu cầu truyện thất bại.'
            ]; 
        }
        return response()->json($response);
    }
}
