<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerTerm extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable=[
        'customer_id',
        'term_id',
        'is_paid',
    ];
}
