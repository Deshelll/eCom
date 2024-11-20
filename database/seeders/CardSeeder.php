<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Card;

class CardSeeder extends Seeder
{
    public function run()
    {
        Card::create([
            'title' => 'Саратов – Казань',
            'description' => 'Описание первой карточки.',
            'image' => 'https://krots.top/uploads/posts/2021-11/1638232107_103-krot-info-p-gorodskoi-okrug-gorod-kazan-dostoprimechat-111.jpg',
            'price' => '25840',
        ]);
        Card::create([
            'title' => 'Саратов – Астрахань – Саратов',
            'description' => 'Описание второй карточки.',
            'image' => 'https://avatars.mds.yandex.net/i?id=be867e08eebba1edf19d57945cbdbe3fb31e3490625cd84d-10229043-images-thumbs&n=13',
            'price' => '27500',
        ]);
        Card::create([
            'title' => 'Саратов – Ярославль – Саратов',
            'description' => 'Описание второй карточки.',
            'image' => 'https://avatars.mds.yandex.net/i?id=1c27a3e65e6d7f0b64dd2247d729eb92b5101e6f-10119783-images-thumbs&n=13',
            'price' => '51100',
        ]);
        Card::create([
            'title' => 'Саратов (трансфер) Самара – Казань – Пермь – Казань – Саратов',
            'description' => 'Описание второй карточки.',
            'image' => 'https://avatars.mds.yandex.net/i?id=ea9a0eeda72f2cc5ac3586643d4dfff2_l-7863184-images-thumbs&n=13',
            'price' => '33900',
        ]);
    }
}
