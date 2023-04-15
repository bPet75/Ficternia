<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends ObjectInterface
{
    //public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'name',
        'state',
        'ruler',
        'founder_name',
        'date_of_founding',
        'history',
        'description',
        'img_path',
        'content_id'
    ];
    public function content(){
        return parent::content();
    }
}
