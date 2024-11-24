<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTicket extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'email',
        'phone',
    ];


    /**
     * Связь с заказом.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Связь с билетом.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
