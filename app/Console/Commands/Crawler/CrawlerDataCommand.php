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
        
    }
}
