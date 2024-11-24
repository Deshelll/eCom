<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_id',
        'full_name',
        'phone_number',
        'tickets_count',
        'additional_people',
    ];

    public function tickets()
    {
        return $this->hasMany(OrderTicket::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

}
