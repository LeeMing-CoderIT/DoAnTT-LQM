<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Auth;

class ViewsStory extends Model
{
    use HasFactory;

    protected $fillable = ['story_id', 'views_day', 'views_month', 'views_year', 'manager_users', 'created_at', 'updated_at'];

    protected function views_day(): Attribute{
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value, JSON_UNESCAPED_UNICODE)
        );
    }

    protected function views_month(): Attribute{
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value, JSON_UNESCAPED_UNICODE)
        );
    }

    protected function manager_users(): Attribute{
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value, JSON_UNESCAPED_UNICODE)
        );
    }

    public function addView(){
        $views_day = json_decode($this->views_day, true);
        if(date('Y-m-d', strtotime($views_day['date'])) != date('Y-m-d')){
            $views_day['views'] = 0;
            $views_day['date'] = date('Y-m-d');
        }
        $views_day['views']+=1;
        $views_month = json_decode($this->views_month, true);
        if(date('Y-m', strtotime($views_month['date'])) != date('Y-m')){
            $views_month['views'] = 0;
            $views_month['date'] = date('Y-m');
        }
        $views_month['views']+=1;
        $data['views_day'] = json_encode($views_day, JSON_UNESCAPED_UNICODE);
        $data['views_month'] = json_encode($views_month, JSON_UNESCAPED_UNICODE);
        $data['views_year'] = $this->views_year + 1;
        $this->update($data);
        // return $this;
    }

    public function addHistory($chapter, $paragraph = 1){
        if(Auth::check() && $chapter){
            $chapter->story = Story::find($chapter->story_id);
            $history = (Auth::user()->settings()->history);
            if(!is_array($history)){
                $history = json_decode(Auth::user()->settings()->history, true);
            }
            if(is_array($history)){
                $hasHistory = false; $insexHas = -1;
                foreach($history as $key => $item){
                    if($item[0] == $chapter->story->id){
                        $hasHistory = true;
                        $insexHas = $key;
                    }
                }
                if($hasHistory == true){
                    unset($history[$insexHas]);
                }
                array_unshift($history, $this->buildHistory($chapter, $paragraph));
                Auth::user()->settings()->update(['history'=> json_encode($history, JSON_UNESCAPED_UNICODE)]);
            }
        }
        // return $this;
    }

    protected function buildHistory($chapter, $paragraph){
        return [$chapter->story->id, $chapter->index_chap, $paragraph];
    }
}
