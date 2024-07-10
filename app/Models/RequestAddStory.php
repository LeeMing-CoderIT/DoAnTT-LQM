<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class RequestAddStory extends Model
{
    use HasFactory;

    protected $table = 'request_add_stories';
    protected $fillable = ['user_id', 'source', 'link', 'next', 'status', 'created_at', 'updated_at'];

    public function user(){
        return $this->hasMany(User::class, 'id', 'user_id')->first();
    }
}
