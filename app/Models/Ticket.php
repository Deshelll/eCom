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
        'image',
    ];

    /**
     * Значения по умолчанию для атрибутов модели.
     */
    protected $attributes = [
        'total_tickets' => 150,
        'available_tickets' => 150,
    ];

    /**
     * Глобальное применение дефолтных значений при создании модели.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            $ticket->total_tickets = $ticket->total_tickets ?? 150;
            $ticket->available_tickets = $ticket->available_tickets ?? 150;
        });
    }

    /**
     * Связь: билет имеет много других билетов.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Связь: билеты принадлежат многим заказам.
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_tickets')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}