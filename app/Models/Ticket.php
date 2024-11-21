<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'total_tickets',
        'available_tickets',
        'image'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
