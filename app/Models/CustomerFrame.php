<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerFrame extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable=[
        'customer_id',
        'frame_id',
        'is_available',
    ];
}
