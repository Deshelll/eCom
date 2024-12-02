<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RentalCard;

class RentalCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cards = [
            [
                'title' => 'Аренда лодки',
                'description' => 'Удобная лодка для прогулок по воде.',
                'image' => 'https://avatars.mds.yandex.net/i?id=021e535f9047f4f452cd8226c24f4605525e1a30-12434127-images-thumbs&n=13',
                'price' => 1500.00,
                'is_available' => true,
            ],
            [
                'title' => 'Аренда катамарана',
                'description' => 'Катамаран для веселых компаний.',
                'image' => 'https://www.contactyachts.com/site/assets/files/10891/contact-yachts-leonora_0001.jpg',
                'price' => 2500.00,
                'is_available' => true,
            ],
            [
                'title' => 'Аренда яхты',
                'description' => 'Роскошная яхта для праздников и вечеринок.',
                'image' => 'https://arenda-kater.com/uploads/151/big/2ecbbf9c7a9d7b5f8913e6bc9ab8b4ff.jpg',
                'price' => 5000.00,
                'is_available' => false,
            ],
            [
                'title' => 'Аренда байдарки',
                'description' => 'Байдарка для спортивных и активных прогулок.',
                'image' => 'https://rentakayak.ru/wp-content/uploads/2023/07/%D0%98%D0%BB%D1%8C%D0%BC%D0%B5%D0%BD%D1%8C-%D0%9C-%D0%B1%D0%B0%D0%B9%D0%B4%D0%B0%D1%80%D0%BA%D0%B0-%D1%83%D0%BD%D0%B8%D0%B2%D0%B5%D1%80%D1%81%D0%B0%D0%BB%D1%8C%D0%BD%D0%B0%D1%8F-4.jpg',
                'price' => 800.00,
                'is_available' => true,
            ],
            [
                'title' => 'Аренда SUP-борда',
                'description' => 'SUP-борд для спокойного катания на воде.',
                'image' => 'https://doskaveslo.ru/d/vybrat_sup_bord_v_moskve_naduvnoj_sapbord_dlya_nachinayushchego_1200p_3.webp',
                'price' => 1200.00,
                'is_available' => true,
            ],
        ];

        foreach ($cards as $card) {
            RentalCard::create($card);
        }
    }
}
