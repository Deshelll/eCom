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
        'user_id',
    ];

    public function tickets()
    {
        return $this->hasMany(OrderTicket::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($order) {
            $card = $order->card;
            $card->tickets->decrement('available_tickets', $order->tickets_count);
        });
    }
}
