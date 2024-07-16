<?php

namespace App\Http\Controllers;

use UniSharp\LaravelFilemanager\Controllers\UploadController;
use Illuminate\Http\Request;

class CustomUploadController extends UploadController
{
    public function upload(Request $request)
    {
        // Gọi phương thức của cha để giữ lại chức năng gốc
        $response = parent::upload($request);

        // Chỉnh sửa URL trả về
        $modifiedResponse = $response->getData();
        if (isset($modifiedResponse->url)) {
            $modifiedResponse->url = $modifiedResponse->url;
        }

        return response()->json($modifiedResponse);
    }
}
