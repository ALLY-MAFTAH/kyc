<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class StallIn extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'stall_id',
        'user_id',
        'entry_date',
        'business',
        'is_active',
        'payment_id',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function stall()
    {
        return $this->belongsTo(Stall::class, 'stall_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
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
