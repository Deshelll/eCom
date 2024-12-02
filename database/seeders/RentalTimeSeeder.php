<?php

namespace Database\Seeders;

use App\Models\RentalCard;
use App\Models\RentalTime;
use Illuminate\Database\Seeder;

class RentalTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rentalCards = RentalCard::all();

        foreach ($rentalCards as $card) {
            $start = new \DateTime('10:00');
            $end = new \DateTime('20:00');

            while ($start < $end) {
                RentalTime::create([
                    'rental_card_id' => $card->id,
                    'start_time' => $start->format('H:i:s'),
                    'is_booked' => false,
                ]);
                $start->modify('+45 minutes');
            }
        }
    }
}
