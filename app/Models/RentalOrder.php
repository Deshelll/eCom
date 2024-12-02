<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalOrder extends Model
{
    protected $fillable = ['rental_card_id', 'user_id', 'start_time', 'end_time'];

    public function rentalCard()
    {
        return $this->belongsTo(RentalCard::class);
    }

    public function rentalTimes()
    {
        return $this->hasMany(RentalTime::class, 'rental_card_id', 'rental_card_id');
    }

}
