<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Story;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'description', 'created_at', 'updated_at'];

    public function stories(){
        return Story::whereJsonContains('categories', (string)$this->id)->get();
    }
}
