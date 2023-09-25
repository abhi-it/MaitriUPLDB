<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictLatLongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = [
            'Agra' => ['lat' => 27.18714498883541, 'long' => 77.99614440769022, 'numOfMaitries' => 10],
            'Firozabad' => ['lat' => 27.15889546750701, 'long' => 78.4002628490207,'numOfMaitries' =>10],
            'Mainpuri' => ['lat' => 27.229205316702508, 'long' => 79.02579692211808,'numOfMaitries' =>10],
            'Mathura' => ['lat' => 27.488056237598904, 'long' => 77.69891277820284,'numOfMaitries' =>10],
            'Azamgarh' => ['lat' => 26.064847206246668, 'long' => 83.1717085624208,'numOfMaitries' =>9],
            'Aligarh' => ['lat' => 27.908501819675298, 'long' => 78.07253769688447,'numOfMaitries' =>9],
            'Hathras' => ['lat' => 27.596210631666825, 'long' => 78.0500710500609,'numOfMaitries' =>10],
            'Fatehpur' => ['lat' => 25.9297074277755, 'long' => 80.80701713624275,'numOfMaitries' =>10],
            'Pilibhit' => ['lat' => 28.631323634668636, 'long' => 79.80556132609456,'numOfMaitries' =>10],
            'Siddharthnagar' => ['lat' => 27.304564853665447, 'long' => 82.81469463853088,'numOfMaitries' =>10],
            'Chitrakoot' => ['lat' => 25.17879686142981, 'long' => 80.86001761472554,'numOfMaitries' =>10],
            'Banda' => ['lat' => 25.481856248936012, 'long' => 80.33919685537055,'numOfMaitries' =>10],
            'Hameerpur' => ['lat' => 25.956576294297832, 'long' => 80.15172214515925,'numOfMaitries' =>10],
            'Ayodhya' => ['lat' => 26.78655569607628, 'long' => 82.20500404222929,'numOfMaitries' =>10],
            'Amethi' => ['lat' => 26.157117447022532, 'long' => 81.81081135692823,'numOfMaitries' => 10],
            'Deoria' => ['lat' => 26.501899498964026, 'long' => 83.77701645113629,'numOfMaitries' =>10],
            'Kushinagar' => ['lat' => 26.740430634726543, 'long' => 83.88826569277761,'numOfMaitries' =>10],
            'Maharajganj' => ['lat' => 27.150652865031816, 'long' => 83.55710751444755,'numOfMaitries' =>10],
            'Kheri' => ['lat' => 28.2158800217371, 'long' => 80.67024045458494,'numOfMaitries' =>11],
            'Baghpat' => ['lat' => 28.944356294965154, 'long' => 77.22312063053057,'numOfMaitries' =>10],
            'Hapur' => ['lat' => 28.727164617056868, 'long' => 77.77775167468165,'numOfMaitries' =>10],
            'Mirzapur' => ['lat' => 25.1383264082267, 'long' => 82.568643643111,'numOfMaitries' =>11],
            'Rampur' => ['lat' => 28.79340924897353, 'long' => 79.02332808706359,'numOfMaitries' =>10],
            'Saharanpur' => ['lat' => 29.971062616075905, 'long' => 77.55350790804128,'numOfMaitries' =>10],
            'Shamli' => ['lat' => 29.448637782031813, 'long' => 77.30383850352948,'numOfMaitries' =>10],
        ];



        foreach ($districts as $district => $coordinates) {
            DB::table('maitri_districts_lat_long')->insert([
                'district' => $district,
                'latitude' => $coordinates['lat'],
                'longitude' => $coordinates['long'],
                'numOfMaitries' => $coordinates['numOfMaitries'],
            ]);
        }
        
    }
}
