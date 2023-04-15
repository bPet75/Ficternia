<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    //public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'title',
        'serial',
        'body',
        'draft_id',
        'views',
        'visibility'

    ];
    public function draft(){
        return $this->hasOne(Draft::class, 'id', 'draft_id');
    }
    public function comments(){
        return $this->hasMany(Comment::class, 'chapter_id', 'id');
    }
    // public function onlyComments(){
    //     $comments = $this->hasMany(Comment::class, 'chapter_id', 'id');
    //     $out = [];
    //     foreach ($comments as $value) {
    //         if($value->rating == null){
    //             array_push($out, $value);
    //         }
    //     }
    //     return $out;
    // }
    // public function onlyRatings(){
    //     $comments = $this->hasMany(Comment::class, 'chapter_id', 'id');
    //     $out = [];
    //     foreach ($comments as $value) {
    //         if($value->rating != null){
    //             array_push($out, $value);
    //         }
    //     }
    //     return $out;
    // }
    // public function rating(){
    //     $comments = $this->hasMany(Comment::class, 'chapter_id', 'id');
    //     $starsSum = 0;
    //     $starsNum = 0;
    //     foreach ($comments as $value) {
    //         if($value->rating != null){
    //             $starsSum += $value->rating;
    //             $starsNum += 1;
    //         }
    //     }
    //     return $starsSum / $starsNum;
    // }
    // public function countComments(){
    //     $comments = $this->hasMany(Comment::class, 'chapter_id', 'id');
    //     $out = [];
    //     foreach ($comments as $value) {
    //         if($value->rating == null){
    //             array_push($out, $value);
    //         }
    //     }
    //     return count($out);
    // }
}
