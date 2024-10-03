<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $zones_en = [
            'Agra',
            'Gorakhpur',
            'Kanpur Nagar',
            'Varanasi',
            'Lucknow',
            'Jhansi',
            'Moradabad',
            'Prayagraj',

        ];
        $zones_hi = [
            'आगरा',
            'गोरखपुर',
            'कानपुर नगर',
            'वाराणसी',
            'लखनऊ',
            'झांसी',
            'मुरादाबाद',
            'प्रयागराज',
           
        ];

        foreach ($zones_en as $index => $zone_en) {
            \App\Models\Zone::create(['name_hi' => $zones_hi[$index], 'name_en' => $zone_en]);
        }
    }
}
