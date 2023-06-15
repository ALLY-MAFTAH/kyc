<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Stall extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'location',
        'price',
        'customer_id',
        'market_id',
        'entry_date',
        'size',
        'type',
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
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function stallIns()
    {
        return $this->hasMany(StallIn::class);
    }
    public function stallOuts()
    {
        return $this->hasMany(StallOut::class);
    }
    protected static function boot()
{
    parent::boot();

    static::saving(function ($model) {
        foreach ($model->getAttributes() as $key => $value) {
            if (is_string($value)) {
                $model->setAttribute($key, Str::upper($value));
            }
        }
    });
}

}
