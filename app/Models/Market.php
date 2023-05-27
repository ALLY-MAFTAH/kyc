<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
