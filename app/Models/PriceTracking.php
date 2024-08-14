<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'subscriber_id',
        'price',
        'status',
    ];
    protected $casts    = [
        'subscriber_id' => 'array',
    ];
}
