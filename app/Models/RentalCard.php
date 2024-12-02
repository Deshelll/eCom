<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalCard extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image', 'price', 'is_available'];

    public function rentalTimes()
    {
        return $this->hasMany(RentalTime::class);
    }
}
