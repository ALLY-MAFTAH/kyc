<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrameOut extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'frame_id',
        'user_id',
        'leaving_date',
    ];

    protected $dates = [
        'deleted_at'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function frame()
    {
        return $this->belongsTo(Frame::class, 'frame_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
