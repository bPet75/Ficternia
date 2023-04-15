<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'subscriber_id',
        'subscribed_to_id',
    ];

    public function subscribed_to(){
        return $this->hasMany(User::class, 'id', 'subscribed_to_id');
    }
}
