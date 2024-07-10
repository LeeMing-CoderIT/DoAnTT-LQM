<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Nette\Utils\Html;
use PharIo\Manifest\Url;
use App\Http\Controllers\GuzzleController;
use Stichoza\GoogleTranslate\GoogleTranslate;

class HelpperController extends Controller
{
    public $language = "vi";

    public function tranlate(Request $request){
        $google = new GoogleTranslate($this->language);
        return response($google->translate($request->text));
    }

    public function tranlateToMP3(Request $request){
        $text = $request->text;
        $arr_simple = explode(" ", $text);
        $arr_data = []; $data = '';
        foreach ($arr_simple as $str){
            if(strlen($data.' '.$str) < 205){
                $data =  $data.' '.$str;
            }else{
                $arr_data[] = $data;
                $data = $str;
            }
        }
        $arr_data[] = $data;

        $full_data = '';
        foreach($arr_data as $data_str){
            $data_str = rawurlencode(htmlspecialchars($data_str));
            $url = 'https://translate.google.com/translate_tts?ie=UTF-8&tl='.$this->language.'&client=tw-ob&q='.$data_str;
            $full_data .= base64_encode(Http::get($url));
        }
        return response()->json([
            'text' => $arr_data,
            'data' => $full_data,
            'token'=> $request->token,
        ]);
    }

    public function tranlateToMP3_2(Request $request){
        $text = $request->text;
        $this->renderStr($text, $arr_data);

        $full_data = '';
        if($arr_data && is_array($arr_data)){
            foreach($arr_data as $data_str){
                $data_str = rawurlencode(htmlspecialchars($data_str));
                $url = 'https://translate.google.com/translate_tts?ie=UTF-8&tl='.$this->language.'&client=tw-ob&q='.$data_str;
                $full_data .= base64_encode(Http::get($url));
            }
        }
        $response = [
            'text' => $arr_data,
            'data' => $full_data,
            'token'=> $request->token,
            'index' => $request->index,
        ];
        // dd($response);
        return response()->json($response);
    }

    protected $separator = ['
    ', '.', ',', '!', ' '];

    protected function renderStr($str, &$arr, $separator = 0){
        // dd($this->separator[$separator]);
        if($separator < count($this->separator)){
            $arr_simple = explode($this->separator[$separator], $str);
            if ($this->separator[$separator] != ' ') {
                foreach ($arr_simple as $key => $str){
                    if(strlen(trim($str)) > 0){
                        $txt = $str.(($key<count($arr_simple)-1)?$this->separator[$separator]:'');
                        if(strlen($txt) > 200){
                            $this->renderStr($txt, $arr, ($separator+1));
                        }else{
                            $arr[] = $txt;
                        }
                    }
                }
            } else {
                $data = '';
                foreach ($arr_simple as $str){
                    if(strlen($data.' '.$str) < 200){
                        $data =  $data.' '.$str;
                    }else{
                        $arr[] = $data;
                        $data = $str;
                    }
                }
                $arr[] = $data;
            }
            
        }
    }
}
