<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $hidden = [
        'user_id', 'spot_id'
    ];
}