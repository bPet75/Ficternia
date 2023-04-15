<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Religion extends ObjectInterface
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'content_id'
    ];
    public function content(){
        return parent::content();
    }
}
