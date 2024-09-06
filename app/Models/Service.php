<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'provider_id',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
