<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionOnItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'email',
        'user_id',
    ];
}
