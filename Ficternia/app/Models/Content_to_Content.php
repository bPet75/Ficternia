<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content_to_Content extends Model
{
    public $table = 'content_to_contents';
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'first_id',
        'second_id',
    ];
}
