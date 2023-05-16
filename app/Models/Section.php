<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
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
}
