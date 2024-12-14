<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Card;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $cards = Card::all();

        foreach ($cards as $card) {
            Ticket::create([
                'card_id' => $card->id,
                'total_tickets' => rand(100, 200),
                'available_tickets' => rand(50, 100),
            ]);
        }
    }
}
