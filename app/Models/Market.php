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
        'name',
        'location',
        'manager_name',
        'manager_phone',
        'size',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
