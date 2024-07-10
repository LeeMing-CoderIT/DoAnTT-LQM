<?php
    include 'simple_html_dom.php';
    function checkfileImageStory($link) {
        $str = '';
        $arr_link = explode('/storage', $link);
        if(count($arr_link)>1){
            $str = 'public'.$arr_link[1];
        }
        return Storage::exists($str);
    }