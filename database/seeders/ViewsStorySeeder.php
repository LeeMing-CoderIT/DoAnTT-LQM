<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ViewsStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('views_stories')->insert([
            [
                'story_id' => 1,
                'views_day' => json_encode(['date'=>date('Y-m-d'), 'views'=> 0], JSON_UNESCAPED_UNICODE),
                'views_month' => json_encode(['date'=>date('Y-m'), 'views'=> 0], JSON_UNESCAPED_UNICODE),
                'views_year' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'story_id' => 2,
                'views_day' => json_encode(['date'=>date('Y-m-d'), 'views'=> 0], JSON_UNESCAPED_UNICODE),
                'views_month' => json_encode(['date'=>date('Y-m'), 'views'=> 0], JSON_UNESCAPED_UNICODE),
                'views_year' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
