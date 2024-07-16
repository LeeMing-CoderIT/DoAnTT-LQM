<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\ViewsStory;

class Story extends Model
{
    use HasFactory;

    protected $fillable = ['source', 'author', 'name', 'slug', 'image', 'description', 'categories', 'status', 'created_at', 'updated_at'];

    protected function categories(): Attribute{
        return Attribute::make(
            get: fn ($value) => $this->getCategories($value),
            set: fn ($value) => json_encode($value,JSON_UNESCAPED_UNICODE)
        );
    }

    protected function image(): Attribute{
        return Attribute::make(
            get: fn ($value) => $this->imageChecked($value),
        );
    }

    protected function source(): Attribute{
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value,JSON_UNESCAPED_UNICODE)
        );
    }
    
    public function findChapter($index_chapter = 1){
        return Chapter::where('story_id', $this->id)->where('index_chap', $index_chapter)->first();
    }

    public function chapters($limit = '*', $offset = 0){
        $chapters = $this->hasMany(Chapter::class, 'story_id', 'id')->orderBy('index_chap');
        if($limit != '*'){
            $chapters->limit($limit)->offset($offset);
        }
        return $chapters->get();
    }

    public function allPage($limit = '*'){
        return ($limit != '*')?ceil($this->chapters()->count() / $limit):1;
    }

    public function getCategories($list){
        foreach ($list = json_decode($list, true) as $key => $item){
            $list[$key] = Category::find((int)$item);
        }
        return $list;
    }
    public function rawCategories(){
        $arr = [];
        foreach ($this->categories as $key => $category) {
            $arr[] = $category->id;
        }
        return json_encode($arr,JSON_UNESCAPED_UNICODE);
    }
    public function nameCategories(){
        $str = "";
        foreach ($this->categories as $key => $category) {
            if($key > 0) $str .= ', ';
            $str .= $category->name;
        }
        return $str;
    }

    public function newChapter(){
        return $this->hasMany(Chapter::class, 'story_id', 'id')->orderByDesc('index_chap')->first();
    }

    public function infoViews(){
        return $this->hasMany(ViewsStory::class, 'story_id', 'id')->first();
    }

    public function isHot(){
        return $this->infoViews()->views_year >= $this->musty_Hot();
    }

    public function isNew(){
        return strtotime(date('Y-m-d H:i:s')) < strtotime('+1 month',strtotime ($this->created_at));
    }

    protected function musty_Hot(){
        $all_story_views = ViewsStory::all(); $all_view = 0;
        foreach ($all_story_views as $value) {
            $all_view += $value->views_year;
        }
        return (int)ceil($all_view/$all_story_views->count()) ?? 0;
    }

    protected function imageChecked($img){
        if($img && checkfileImageStory($img)){
            return $img;
        }
        $defaultImg = json_decode(\Storage::get('public/files/infoWebsite.json'), true)['defaultStoryImg'];
        return $defaultImg;
    }
}
