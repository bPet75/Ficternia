<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectInterface extends Model
{
    use HasFactory;

    protected function content(){
        return $this->hasOne(Content::class, 'id', 'content_id');
    }
}
