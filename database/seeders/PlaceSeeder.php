<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = [
            ['user_id' => 1, 'name' => 'Спартак арена'],
            ['user_id' => 1, 'name' => 'Петровский'],
            ['user_id' => 1, 'name' => 'ЦСП'],
        ];

        foreach ($places as $placeData) {
            $place = new Place();
            $place->user_id = $placeData['user_id'];
            $place->name = $placeData['name'];
            $place->save();
        }
    }
}
