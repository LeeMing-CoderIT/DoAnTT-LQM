<?php

namespace App\Console\Commands\Crawler;

use Illuminate\Console\Command;

class CrawlerDataCommand extends Command
{
    protected $signature = 'crawler:init';
    protected $description = 'Cralwer';
    public function __construct(){
        parent::__construct();
    }
    public function handle()
    {
        $this->init();
    }

    protected function init(){
        //https://truyenfull.vn/dung-hong-cuop-hoang-hau-cua-tram/chuong-110/
        $linkStory = 'https://truyenfull.vn/linh-vu-thien-ha/';
        $this->info('-- -- Crawler: starting......');
        $this->crawlerStory($linkStory);
        $this->info('-- -- END -- --.');
    }

    protected function crawlerStory($linkStory){
        $this->info('-- -- LOADING.... Story: '.$linkStory);
        $html = file_get_html($linkStory);
        $story = [];
        foreach ($html->find('#truyen > div.col-xs-12.col-sm-12.col-md-9.col-truyen-main > div.col-xs-12.col-info-desc > div.col-xs-12.col-sm-4.col-md-4.info-holder > div.info > div > a') as $key => $value) {
            $this->warn($value->doc);
            // if ($value->itemprop == 'author') {
            //     $story['author'] = $value->plaintext ?? '';
            //     $this->warn('-- -- Author: '.$story['author']);
            // }elseif($value->itemprop == 'genre') {
            //     $story['categories'][] = $value->href ?? '';
            //     $this->warn('-- -- Category['.($key+1).']: '.$story['categories'][$key]);
            // }
        }
        foreach($html->find('#truyen > div.col-xs-12.col-sm-12.col-md-9.col-truyen-main > div.col-xs-12.col-info-desc > h3') as $value){
            $story['name'] = $value->plaintext ?? '';
            $this->warn('-- -- Name: '.$story['name']);
        }
        foreach($html->find('#truyen-ascii') as $value){
            $story['slug'] = $value->value ?? '';
            $this->warn('-- -- Slug: '.$story['slug']);
        }
        foreach($html->find('#truyen > div.col-xs-12.col-sm-12.col-md-9.col-truyen-main > div.col-xs-12.col-info-desc > div.col-xs-12.col-sm-4.col-md-4.info-holder > div.books > div > img') as $value){
            $story['image'] = $value->src ?? '';
            $this->warn('-- -- Image: '.$story['image']);
        }
        foreach($html->find('#truyen > div.col-xs-12.col-sm-12.col-md-9.col-truyen-main > div.col-xs-12.col-info-desc > div.col-xs-12.col-sm-8.col-md-8.desc > div.desc-text.desc-text-full') as $value){
            $story['description'] = $value ?? '';
            // $this->warn('-- -- Description: '.$story['description']);
        }
        $this->info('-- -- DONE -- --');

        dd($story);
    }
}
