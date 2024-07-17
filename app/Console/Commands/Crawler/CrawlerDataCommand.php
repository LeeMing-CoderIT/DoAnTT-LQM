<?php

namespace App\Console\Commands\Crawler;

use Illuminate\Console\Command;
use App\Http\Controllers\CrawlDataController;
use App\Http\Controllers\Crawler\CrawlerTruyenFullController;
use App\Models\Category;

class CrawlerDataCommand extends Command
{
    protected $signature = 'crawler:categories';
    protected $description = 'Cralwer danh mục';
    public function __construct(){
        parent::__construct();
    }
    public function handle()
    {
        $this->init();
    }

    protected function init(){
        $this->info('-- -- Crawler: starting......');
        $this->crawlerCategories();
        $this->info('-- -- END -- --.');
    }

    protected function crawlerCategories(){
        $categories = (new CrawlDataController)->crawlerCategories();
        foreach ($categories as $key => $value) {
            $this->crawlerCategory($value[0], $value[1]);
        }
    }

    protected function crawlerCategory($link, $title){
        $this->warn('-- -- -- -- -- -- -- -- --');
        $this->warn('-- -- -- -- -- -- -- -- --');
        $this->info('-- -- Crawler: '.$link.'......');
        $category = CrawlerTruyenFullController::crawlerCategory($link, $title);
        if($category){
            if(!Category::where('slug', $category['slug'])->first()){
                if (Category::create($category)) {
                    $this->info('-- -- Name: '.$category['name']);
                    $this->info('-- -- Slug: '.$category['slug']);
                    if($category['description'] != ''){
                        $this->info('-- -- Description: '.$category['description']);
                    }else{
                        $this->error('-- -- Description error.');
                    }
                } else {
                    $this->error('-- -- Category create error.');
                }
                
            }else{
                $this->error('-- -- Category is exsist.');
            }
        }else{
            $this->error('Error: crawler '.$title);
        }
        $this->info('-- -- DONE......');
    }
}
