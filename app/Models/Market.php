<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Market extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'ward',
        'sub_ward',
        'size',
        'frame_price',
        'stall_price',
        'default_password',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function frames()
    {
        return $this->hasMany(Frame::class);
    }
    public function stalls()
    {
        return $this->hasMany(Stall::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
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
