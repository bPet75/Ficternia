<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draft extends ObjectInterface
{
    //public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'title',
        'synopsis',
        'serial',
        'body',
        'content_id'
    ];
    public function content(){
        return parent::content();
    }
    public function chapter(){
        return $this->hasOne(Chapter::class, 'draft_id', 'id');
    }
}
