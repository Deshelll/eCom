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
        'status',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
