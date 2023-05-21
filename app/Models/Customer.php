<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'address',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function frames()
    {
        return $this->hasMany(Frame::class);
    }
    public function cages()
    {
        return $this->hasMany(Cage::class);
    }
    public function markets()
    {
        return $this->belongsToMany(Market::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function terms()
    {
        return $this->belongsToMany(Term::class);
    }
}
