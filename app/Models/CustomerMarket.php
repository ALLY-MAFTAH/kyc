<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerMarket extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable=[
        'customer_id',
        'market_id',
    ];


    protected $dates = [
        'deleted_at'
    ];
}
