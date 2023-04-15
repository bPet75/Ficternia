<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends ObjectInterface
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'name',
        'color',
        'type',
        'content_id'
    ];
    public function content(){
        return parent::content();
    }
}
