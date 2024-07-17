<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\ViewsStory;
use App\Http\Controllers\Crawler\CrawlerTruyenFullController;

class CrawlDataController extends Controller
{
    public function crawler(Request $request){
        $data = false;
        if($request->has('source') && $request->has('type') && $request->has('link')){
            // dd($request->addNow);
            if($request->source == 'truyenfull'){
                $data = CrawlerTruyenFullController::crawler($request->type, $request->link, 
                    ($request->bug??false), ($request->page??null),
                    ($request->story_id??1), ($request->chapterIndex??null), ($request->addNow??true));
            }
        }
        return response()->json($data);
    }
}
