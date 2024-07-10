<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\Chapter;
use App\Http\Controllers\CrawlDataController;

class ManagerChaptersController extends Controller
{
    public $data = [];
    public function all(Request $request, Story $story)
    {
        if($request->ajax()){
            $data = $story->chapters();
            foreach ($data as $key => $value) {
                $data[$key]->index = $key+1;
            }
            return (datatables()->of($data)
            ->addColumn('action', 'admins.stories.chapters.action-buttons')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true));
        }
    }

    public function show(Request $request, Story $story, Chapter $chapter)
    {
        if($request->has('show')){
            if($chapter && $request->show == 'chapter'){
                $data = $chapter;
            }elseif($request->show == 'new-chapter'){
                $data = $story->newChapter();
            }
        }
        return response()->json($data ?? []);
    }

    public function add(Request $request, Story $story)
    {
        $response = []; $response['success'] = false;
        $data = $request->all(); //'name', 'index_chap', 'content'
        $data['story_id'] = $story->id;
        try {
            if(!$story->findChapter($data['index_chap'])){
                $chapter = Chapter::create($data);
                $response['msg'] = [
                    'type'=>'success', 'msg'=>'Thêm chương thành công.', 'data'=>$chapter
                ];
            }else{
                $response['msg'] = [
                    'type'=>'warning', 'msg'=>'Chương đã tồn tại.'
                ];
            }
            $response['success'] = true;
        } catch (\Throwable $th) {
            $response['msg'] = $th; 
        }
        return response()->json($response);
    }

    public function edit(Request $request, Story $story, Chapter $chapter)
    {
        $response = []; $response['success'] = false;
        $data = $request->only('name', 'index_chap', 'content');
        $data['index_chap'] = (int)$data['index_chap'];
        try {
            $chapter->update($data);
            $response['success'] = true;
            $response['msg'] = [
                'data' => $chapter,
                'type'=>'success', 
                'msg'=>'Cập nhật chương thành công.'
            ];
        } catch (\Throwable $th) {
            $response['msg'] = $th; 
        }
        return response()->json($response);
    }

    public function delete(Story $story, $index_chap)
    {
        $response = []; $response['success'] = false; $response['msg'] = 'Xóa chương thất bại.';
        try {
            if($story->findChapter($index_chap)->delete()){
                $response['success'] = true;
                $response['data'] = $story->findChapter($index_chap);
                $response['msg'] = "Xóa chương thành công.";
            }
        } catch (\Throwable $th) {
            $response['msg'] = $th; 
        }
        return response()->json($response);
    }
}
