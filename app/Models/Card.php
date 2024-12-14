<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image', 'price'];

    public function tickets()
    {
        return $this->hasOne(Ticket::class, 'card_id');
    }

    /**
     * Метод для автоматического создания связанного билета.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($card) {
            $card->tickets()->create([
                'total_tickets' => 150, // Дефолтное общее количество билетов
                'available_tickets' => 150, // Дефолтное доступное количество билетов
            ]);
        });
    }
}
