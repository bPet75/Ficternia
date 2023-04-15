<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'body',
        'rating',
        'user_id',
        'chapter_id',
        'parent_id'
    ];
    public function childs(){
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }
    public function writer(){
        return $this->hasMany(User::class, 'id', 'user_id');
    }
    public function related_chapter(){
        return $this->hasOne(Chapter::class, 'id', 'chapter_id');
    }
    public function related_user(){
        return $this->hasOne(Chapter::class, 'id', 'user_id');
    }
}
