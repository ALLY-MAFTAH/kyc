<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'date',
        'amount',
        'receipt_number',
        'stall_id',
        'frame_id',
        'market_id',
        'term_id',
        'customer_id',

    ];

    protected $dates = [
        'deleted_at'
    ];

    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function frame()
    {
        return $this->belongsTo(Frame::class, 'frame_id');
    }
    public function stall()
    {
        return $this->belongsTo(Stall::class, 'stall_id');
    }
    public function market()
    {
        return $this->belongsTo(Market::class, 'market_id');
    }
}
