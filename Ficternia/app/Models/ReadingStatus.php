<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingStatus extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'story_id',
        'user_id',
        'current_chapter_id',
        'is_done',
        'status_update'
    ];

    public function story(){
        return $this->hasOne(Story::class, 'id', 'story_id');
    }
    public function current_chapter(){
        return $this->hasOne(Chapter::class, 'id', 'current_chapter_id');
    }
}
