<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'is_manager',
        'market_id',
        'status',
    ];
    protected $dates = [
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function market()
    {
        return $this->belongsTo(Market::class, 'market_id');
    }
    public function frameIns()
    {
        return $this->hasMany(FrameIn::class);
    }
    public function stallIns()
    {
        return $this->hasMany(StallIn::class);
    }
    public function frames()
    {
        return $this->hasMany(Frame::class);
    }
    public function stalls()
    {
        return $this->hasMany(Stall::class);
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
        $attributesToUppercase = $model->getAttributes();

        $attributesToExclude = ['email', 'password']; // Add the attributes you want to exclude from uppercase conversion

        foreach ($attributesToUppercase as $key => $value) {
            if (!in_array($key, $attributesToExclude) && is_string($value)) {
                $model->setAttribute($key, Str::upper($value));
            }
        }
    });
}

}
