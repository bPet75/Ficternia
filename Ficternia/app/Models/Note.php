<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends ObjectInterface
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'body',
        'is_project_note',
        'content_id'
    ];
    public function content(){
        return parent::content();
    }
}
