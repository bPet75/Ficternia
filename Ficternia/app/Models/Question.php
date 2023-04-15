<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'question_id',
        'answer',
        'character_id'
    ];
}
