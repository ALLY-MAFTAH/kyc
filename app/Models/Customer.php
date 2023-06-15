<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'nida',
        'mobile',
        'photo',
        'address',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function frames()
    {
        return $this->hasMany(Frame::class);
    }
    public function stalls()
    {
        return $this->hasMany(Stall::class);
    }
    public function markets()
    {
        return $this->belongsToMany(Market::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function frameIns()
    {
        return $this->hasMany(FrameIn::class);
    }
    public function stallIns()
    {
        return $this->hasMany(StallIn::class);
    }
    public function frameOuts()
    {
        return $this->hasMany(FrameOut::class);
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
