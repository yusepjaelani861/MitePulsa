<?php

namespace App\Models\Digiflazz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];
}
