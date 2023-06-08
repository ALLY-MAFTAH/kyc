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
        'code',
        'location',
        'price',
        'market_id',
        'customer_id',
        'entry_date',
        'size',
        'business',
        'user_id',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function market()
    {
        return $this->belongsTo(Market::class, 'market_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function frameIns()
    {
        return $this->hasMany(FrameIn::class);
    }
    public function frameOuts()
    {
        return $this->hasMany(FrameOut::class);
    }

}
