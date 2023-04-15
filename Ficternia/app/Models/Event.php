<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends ObjectInterface
{
    //public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'name',
        'starting_time',
        'ending_time',
        'parent_id',
        'description',
        'type',
        'content_id'
    ];
    public function content(){
        return parent::content();
    }
    public function childs(){
        return $this->hasMany(Event::class, 'parent_id', 'id');
    }
}
