<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooklistBook extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'booklist_id',
        'book_id',
    ];
}
