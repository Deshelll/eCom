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
}
