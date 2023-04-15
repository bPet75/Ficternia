<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookList extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'visibility',
    ];
    public function books(){
        return $this->hasOneThrough(
        Story::class,
        BooklistBook::class,
        'id',
        'id',
        'id',
        'book_id'
        );
    }
}
