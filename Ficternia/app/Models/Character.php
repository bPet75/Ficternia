<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends ObjectInterface
{
    //public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'name',
        'img_path',
        'content_id'
    ];
    public function properties(){
        return $this->hasMany(CharacterProperties::class, 'character_id', 'id');
    }
    public function answers(){
        return $this->hasMany(Question::class, 'character_id', 'id');
    }
    public function content(){
        return parent::content();
    }
   
}
