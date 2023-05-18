<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Frame extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'number',
        'location',
        'price',
        'customer_id',
        'market_id',
        'size',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function market()
    {
        return $this->belongsTo(Market::class, 'market_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}