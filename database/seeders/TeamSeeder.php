<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            ['name' => 'Спартак', 'description' => 'Спартак Москва', 'owner_id' => 1],
            ['name' => 'ЦСКА', 'description' => 'Центральный спортивный клуб армии', 'owner_id' => 1],
            ['name' => 'Локомотив', 'description' => 'Футбольный клуб Локомотив', 'owner_id' => 1],
            ['name' => 'Зенит', 'description' => 'Футбольный клуб Зенит', 'owner_id' => 1],
            ['name' => 'Динамо', 'description' => 'Футбольный клуб Динамо', 'owner_id' => 1],
            ['name' => 'Рубин', 'description' => 'Футбольный клуб Рубин', 'owner_id' => 1],
            ['name' => 'Амкар', 'description' => 'Футбольный клуб Амкар', 'owner_id' => 1],
            ['name' => 'Анжи', 'description' => 'Футбольный клуб Анжи', 'owner_id' => 1],
            ['name' => 'Краснодар', 'description' => 'Футбольный клуб Краснодар', 'owner_id' => 1],
            ['name' => 'Урал', 'description' => 'Футбольный клуб Урал', 'owner_id' => 1],
            ['name' => 'Оренбург', 'description' => 'Футбольный клуб Оренбург', 'owner_id' => 1],
            ['name' => 'Тамбов', 'description' => 'Футбольный клуб Тамбов', 'owner_id' => 1],
            ['name' => 'Факел', 'description' => 'Футбольный клуб Факел', 'owner_id' => 1],
            ['name' => 'Уфа', 'description' => 'Футбольный клуб Уфа', 'owner_id' => 1],
            ['name' => 'Арсенал', 'description' => 'Футбольный клуб Арсенал', 'owner_id' => 1],
            ['name' => 'Сочи', 'description' => 'Футбольный клуб Сочи', 'owner_id' => 1],
            ['name' => 'Луч-Энергия', 'description' => 'Футбольный клуб Луч-Энергия', 'owner_id' => 1],
            ['name' => 'Терек', 'description' => 'Футбольный клуб Терек', 'owner_id' => 18],
            ['name' => 'Амур', 'description' => 'Футбольный клуб Амур', 'owner_id' => 19],
            ['name' => 'Сибирь', 'description' => 'Футбольный клуб Сибирь', 'owner_id' => 20],
            ['name' => 'Урарту', 'description' => 'Футбольный клуб Урарту', 'owner_id' => 21],
            ['name' => 'Алания', 'description' => 'Футбольный клуб Алания', 'owner_id' => 22],
            ['name' => 'Дружба', 'description' => 'Футбольный клуб Дружба', 'owner_id' => 23],
            ['name' => 'Сокол', 'description' => 'Футбольный клуб Сокол', 'owner_id' => 24],
            ['name' => 'Колос', 'description' => 'Футбольный клуб Колос', 'owner_id' => 25],
            ['name' => 'Металлург', 'description' => 'Футбольный клуб Металлург', 'owner_id' => 26],
            ['name' => 'Динамо-Минск', 'description' => 'Футбольный клуб Динамо-Минск', 'owner_id' => 27],
            ['name' => 'Торпедо', 'description' => 'Футбольный клуб Торпедо', 'owner_id' => 28],
            ['name' => 'Шахтёр', 'description' => 'Футбольный клуб Шахтёр', 'owner_id' => 29],
            ['name' => 'Гомель', 'description' => 'Футбольный клуб Гомель', 'owner_id' => 30],
            ['name' => 'Городея', 'description' => 'Футбольный клуб Городея', 'owner_id' => 31],
            ['name' => 'Минай', 'description' => 'Футбольный клуб Минай', 'owner_id' => 32],
        ];

        foreach ($teams as $teamData) {
            $team = new Team();
            $team->name = $teamData['name'];
            $team->description = $teamData['description'];
            $team->owner_id = $teamData['owner_id'];
            $team->save();
        }
    }
}
