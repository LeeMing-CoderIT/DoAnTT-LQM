<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SettingUser extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'status', 'background', 'language', 'speech', 'history'];

    protected function history(): Attribute{
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value, JSON_UNESCAPED_UNICODE),
        );
    } 
    public function login(){
        $this->update(['status' => 1]);
    }

    public function logout(){
        $this->update(['status' => 0]);
    }
    
    public function updateBackground($background){
        $this->update(['background' => $background]);
    }
}
