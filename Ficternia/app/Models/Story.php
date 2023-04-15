<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends ObjectInterface
{
    //public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'title',
        'genre_id',
        'audience_id',
        'state_id',
        'description',
        'img_path',
        'views',
        'content_id'
    ];
    public function content(){
        return parent::content();
    }

    public function owner(){
        return $this->hasOneThrough(
        Project::class,
        Content::class,
        'id',
        'id',
        'content_id',
        'project_id'
        );
    }

    public function genre(){
        return $this->hasOne(Genre::class, 'id', 'genre_id');
    }
    public function audience(){
        return $this->hasOne(Audience::class, 'id', 'audience_id');
    }
    public function state(){
        return $this->hasOne(State::class, 'id', 'state_id');
    }
}
