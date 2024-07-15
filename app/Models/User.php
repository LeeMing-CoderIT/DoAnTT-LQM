<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\SettingUser;
use App\Models\Story;
use App\Models\RequestAddStory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['email', 'email_verified_at', 'password', 'fullname', 'phone', 'avatar', 'root', 'remember_token', 'created_at', 'updated_at'];


    public function settings(){
        return $this->hasMany(SettingUser::class, 'user_id', 'id')->first();
    }

    public function requestAddStory(){
        return $this->hasMany(RequestAddStory::class, 'user_id', 'id')->get();
    }

    public function name_manager(){
        $name = "Người dùng";
        if($this->root == 1){
            $name = "Quản trị viên";
        }elseif($this->root == 2){
            $name = "Biên tập viên";
        }
        return $name;
    }

    public function hasManagerStories(){
        return Story::select('stories.*')
        ->join('views_stories', 'stories.id', '=', 'views_stories.story_id')
        ->whereJsonContains('views_stories.manager_users', $this->id)->get();
    }

    protected function avatar(): Attribute{
        return Attribute::make(
            get: fn ($value) => $this->imageChecked($value),
        );
    }

    protected function imageChecked($img){
        if($img && Storage::has('public/images/users/'.$img)){
            return 'storage/images/users/'.$img;
        }
        $defaultImg = json_decode(Storage::get('public/files/infoWebsite.json'), true)['defaultUserImg'];
        return $defaultImg;
    }

    public function showHistory(){
        $data = [];
        $history = json_decode($this->settings()->history, true);
        foreach($history as $key => $item){
            $arr = [];
            $arr['story'] = Story::find($item[0]);
            $arr['chapter'] = $arr['story']->findChapter($item[1]);
            $arr['paragraph'] = $item[2];
            $data[] = $arr;
        }
        return $data;
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
