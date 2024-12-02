<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalTime extends Model
{
    use HasFactory;

    protected $fillable = ['rental_card_id', 'start_time', 'is_booked'];

    public function rentalCard()
    {
        return $this->belongsTo(RentalCard::class);
    }
}
