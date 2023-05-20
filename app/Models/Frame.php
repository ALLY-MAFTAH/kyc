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
    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }
}
