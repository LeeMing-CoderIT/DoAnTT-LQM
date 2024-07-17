<?php

namespace App\Http\Controllers\Crawler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\ViewsStory;

class CrawlerTruyenFullController extends Controller
{
    public $link, $type, $bug, $source = 'truyenfull';
    protected static $arrConttextOption = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ];

    public function __construct($type = 'story', $link = 'https://truyenfull.vn/', $bug = false){
        $this->type = $type;
        $this->link = $link;
        $this->bug = $bug;
    }
    public static function crawler($type = 'story', $link, $bug = false, $page = null, $story_id, $chapterIndex = null, $addNow){
        $crawler = new CrawlerTruyenFullController($type, $link, $bug);
        if($type == 'story') return $crawler->crawlerStory();
        elseif($type == 'count-chapters') return $crawler->allChaptersFull($story_id);
        elseif($type == 'link-chapters') return $crawler->linkChapters($page);
        elseif($type == 'chapter') return $crawler->crawlerChapter($page, $story_id, $chapterIndex, $addNow);
        else return null;
    }

    protected function crawlerStory(){
        try {
            $html = file_get_html($this->link, false, stream_context_create(self::$arrConttextOption)); //, false, stream_context_create(self::$arrConttextOption)
            // dd($this);
            $story = [];
            foreach ($html->find('#truyen > div.col-truyen-main > div.col-info-desc > div.info-holder > div.info > div > a') as $key => $value) {
                if ($value->itemprop == 'author') {
                    $story['author'] = $value->plaintext ?? '';
                }elseif($value->itemprop == 'genre') {
                    $str_link_category = $value->href ?? '';
                    $slug = trim(str_replace('https://truyenfull.vn/the-loai', '', $str_link_category), ' /');
                    if($category = Category::where('slug', $slug)->first()){
                        $story['categories'][] = $category->id;
                    }
                }
            }
            $story['name'] = $html->find('#truyen > div.col-truyen-main > div.col-info-desc > h3')[0]->plaintext ?? '';
            $story['slug'] = $html->find('#truyen-ascii')[0]->value ?? '';
            $image = $html->find('#truyen > div.col-truyen-main > div.col-info-desc > div.info-holder > div.books > div > img')[0];
            $story['image'] = $image->src ?? $image->attr['data-cfsrc'] ?? '';
            $story['description'] = (string)$html->find('#truyen > div.col-truyen-main > div.col-info-desc > div.desc > div.desc-text')[0] ?? '';
            preg_match_all('~<div class="desc-text(.+?)itemprop="description">~s', $story['description'], $matches);
            if(!empty($matches[1])){
                foreach($matches[1] as $key => $value){
                    $story['description'] = str_replace($matches[0][$key], "", $story['description']);
                }
            }
            $story['description'] = substr($story['description'], 0, strlen($story['description'])-6);
            $story['status'] = $html->find('#truyen > .col-truyen-main > div.col-info-desc > div.info-holder > div.info > div > span')[1]->plaintext??'';
        } catch (\Throwable $th) {
            if(!$this->bug) return ['error' => $this->link, 'bug' => true];
            else return false;
        }
        return $story;
    }

    protected function linkChapters($page = 1){
        try {
            $links = [];
            if ($page == 1) {
                $this->link = trim($this->link, ' /').'/';
            } else {
                $this->link = trim($this->link, ' /').'/trang-'.$page.'/';
            }
            // dd($this->link, $page);
            $html = file_get_html($this->link, false, stream_context_create(self::$arrConttextOption));
            $chapters = $html->find('#list-chapter > div.row > div > ul > li > a');
            foreach ($chapters as $key => $chapter) {
                $links[] = $chapter->href;
            }
            return $links;
            
        } catch (\Throwable $th) {
            if(!$this->bug) return ['error' => $this->link, 'bug' => true];
            else return false;
        }
    }

    protected function allChaptersFull($story_id){
        try {
            $last_page = 1; $chapters = 0;
            $html = file_get_html($this->link, false, stream_context_create(self::$arrConttextOption));
            $pages = $html->find('#list-chapter > ul > li > a');
            foreach ($pages as $key => $page) {
                if(count($page->children) > 1){
                    unset($pages[$key]);
                }
                elseif(isset($page->attr['data-toggle']) && $page->attr['data-toggle'] == "dropdown"){
                    unset($pages[$key]);
                }
            }
            if(count($pages) > 0){
                $page = array_pop($pages);
                $last_page = trim(str_replace('#list-chapter','',$page->href));
                $last_page = trim(str_replace(trim($this->link, ' /').'/trang-','',$last_page), ' /');
                $last_page = (int)$last_page;
                $chapters += ($last_page-1)*50;
                $this->link = trim($this->link, ' /').'/trang-'.$last_page.'/';
            }else{
                $last_page = 1;
                $this->link = trim($this->link, ' /').'/';
            }
            $html = file_get_html($this->link, false, stream_context_create(self::$arrConttextOption));
            $last_chapters = $html->find('#list-chapter > div.row > div > ul > li');
            $chapters += count($last_chapters);
            return ['pages' => $last_page, 'chapters' => $chapters];
        } catch (\Throwable $th) {
            if(!$this->bug) return ['error' => $this->link, 'bug' => true];
            else return false;
        }
    }
    protected function crawlerChapter($page, $story_id, $chapterIndex, $addNow){
        try {
            $html = file_get_html($this->link, false, stream_context_create(self::$arrConttextOption));
            $chapter = [];
            $chapter['source']['source'] = $this->source;
            $chapter['source']['link'] = $this->link;
            $chapter['source']['page'] = $page;
            $chapter['story_id'] = (int)$story_id;
            $chapter['index_chap'] = (int)$chapterIndex + 1;
            $chapter['name'] = trim($html->find('#chapter-big-container > div > div > h2 > a')[0]->plaintext);
            preg_match_all('~Chương(.+?):~s', $chapter['name'], $matches);
            if(!empty($matches[1])){
                foreach($matches[1] as $key => $value){
                    $chapter['name'] = trim(str_replace($matches[0][$key], "", $chapter['name']));
                }
            }
            $htmlContent = $html->find('#chapter-c')[0] ?? '';
            foreach ($htmlContent->find('.ads-responsive') as $value) {
                $htmlContent->removeChild($value);
            }
            foreach ($htmlContent->find('.ads-mgid') as $value) {
                $htmlContent->removeChild($value);
            }
            $chapter['content'] = '';
            $htmlContent = (string)$htmlContent;
            $htmlContent = str_replace('<div id="chapter-c" class="chapter-c" itemprop="articleBody">', '', $htmlContent);
            $htmlContent = substr($htmlContent, 0, strlen($htmlContent)-6);
            $str_con = '';
            foreach ($arr_str_con = explode('<p><br></p>',$htmlContent) as $value) {
                if($value != ''){
                    $str_con .= '<div>'.$value.'</div>';
                }
            }
            foreach ($arr_str_con = explode('<br>',$str_con) as $value) {
                if($value != ''){
                    $chapter['content'] .= '<div>'.$value.'</div>';
                }
            }
            $chapter['content'] = substr($chapter['content'], 5, strlen($chapter['content'])-11);
            if ($addNow === "false") {
                return response()->json($chapter);
            } else {
                // dd($addNow);
                Chapter::create($chapter);
                return $chapter;
            }
        } catch (\Throwable $th) {
            if(!$this->bug) return ['error' => $this->link, 'bug' => true];
            else return false;
        }
    }

    public static function crawlerCategories(){
        $categories = [];
        try {
            $html = file_get_html('https://truyenfull.vn/', false, stream_context_create(self::$arrConttextOption)); //, false, stream_context_create(self::$arrConttextOption)
            $arrCate = $html->find('#nav > div.container > div> ul > li.dropdown> div > div > div > ul > li > a');
            foreach($arrCate as $cate){
                $categories[] = [$cate->href, $cate->title];
            }
            // dd($categories);
        } catch (\Throwable $th) {
            
        }
        return $categories;
    }

    public static function crawlerCategory($link, $title, $bug = 0){
        $category = null;
        $category['name'] = trim(substr($title, 8));
        $category['slug'] = \Str::slug($category['name']);
        $category['link'] = $link;
        try {
            $html = file_get_html($link, false, stream_context_create(self::$arrConttextOption));
            $category['description'] = (string)$html->find('#list-page > div.col-truyen-side > div > div.cat-desc.text-left > div')[0];
        } catch (\Throwable $th) {
            if($bug == 5){
                $category['description'] = '';
            }else{
                return self::crawlerCategory($link, $title, ($bug+1));
            }
        }
        return $category;
    }
}
