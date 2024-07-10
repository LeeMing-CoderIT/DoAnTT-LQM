<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views_stories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('story_id');
            $table->json('views_day')->default(json_encode(['date'=>date('Y-m-d'), 'views'=> 0], JSON_UNESCAPED_UNICODE));
            $table->json('views_month')->default(json_encode(['date'=>date('Y-m'), 'views'=> 0], JSON_UNESCAPED_UNICODE));
            $table->bigInteger('views_year')->default(0);
            $table->json('manager_users')->default('[]');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('views_stories');
    }
};
