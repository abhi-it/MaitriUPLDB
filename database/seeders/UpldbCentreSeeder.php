<?php

namespace Database\Seeders;

// use App\Constants\\App\Constants\UpldbCentreName;
use App\Models\UpLdbCenter;
use Illuminate\Database\Seeder;

class UpldbCentreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample data for locations
        $locations = [
            [
                'name' => 'Meerut',
                'type' => \App\Constants\UpldbCentreName::BullMotherFarm,
                'icon' => 'images/map-icons/bull.png',
                'latitude' => 29.012160035178862,
                'longitude' => 77.71440518413574,
            ],
            [
                'name' => 'Meerut',
                'type' => \App\Constants\UpldbCentreName::SexedSemenLab,
                'icon' => 'images/map-icons/sexed-semen-lab.png',
                'latitude' => 29.012160035178862,
                'longitude' => 77.71440518413574,
            ],
            [
                'name' => 'Meerut',
                'type' => \App\Constants\UpldbCentreName::DeepFrozenSemenStation,
                'icon' => 'images/map-icons/frozen-semen-station.png',
                'latitude' => 29.012160035178862,
                'longitude' => 77.71440518413574,
            ],
            [

                'name' => 'Gaziabad',
                'type' => \App\Constants\UpldbCentreName::BullMotherFarm,
                'icon' => 'images/map-icons/bull.png',
                'latitude' => 28.704371134983404,
                'longitude' => 77.48427362125112,
            ],
            [
                'name' => 'Muradabad',
                'type' => \App\Constants\UpldbCentreName::UpldbZonalCentre,
                'icon' => 'images/map-icons/upldb.png',
                'latitude' => 28.507287158150785,
                'longitude' => 77.69470094146682,
            ],
            [

                'name' => 'Agra',
                'type' => \App\Constants\UpldbCentreName::UpldbZonalCentre,
                'icon' => 'images/map-icons/upldb.png',
                'latitude' => 27.20516166579346,
                'longitude' => 78.04180633457074,
            ],
            [

                'name' => 'Jhansi',
                'type' => \App\Constants\UpldbCentreName::UpldbZonalCentre,
                'icon' => 'images/map-icons/upldb.png',
                'latitude' => 25.472093770185335,
                'longitude' => 78.59627247654035,
            ],
            [

                'name' => 'Jhansi',
                'type' => \App\Constants\UpldbCentreName::BullMotherFarm,
                'icon' => 'images/map-icons/bull.png',
                'latitude' => 25.472093770185335,
                'longitude' => 78.59627247654035,
            ],
            [

                'name' => 'Kanpur Nagar',
                'type' => \App\Constants\UpldbCentreName::UpldbZonalCentre,
                'icon' => 'images/map-icons/upldb.png',
                'latitude' => 26.253980362420574,
                'longitude' => 80.43956253856457,
            ],
            [

                'name' => 'Lucknow',
                'type' => \App\Constants\UpldbCentreName::UpldbZonalCentre,
                'icon' => 'images/map-icons/upldb.png',
                'latitude' => 26.884122917991867,
                'longitude' => 80.99536550812635,
            ],
            [

                'name' => 'Lucknow',
                'type' => \App\Constants\UpldbCentreName::DeepFrozenSemenStation,
                'icon' => 'images/map-icons/frozen-semen-station.png',
                'latitude' => 26.81244534215368,
                'longitude' => 80.95760000469136,
            ],
            [

                'name' => 'Barabanki',
                'type' => \App\Constants\UpldbCentreName::IvfEttLab,
                'icon' => 'images/map-icons/cow.png',
                'latitude' => 26.954768392280204,
                'longitude' => 81.19377742351982,
            ],
            [

                'name' => 'Barabanki',
                'type' => \App\Constants\UpldbCentreName::BullMotherFarm,
                'icon' => 'images/map-icons/bull.png',
                'latitude' => 26.91691554645873,
                'longitude' => 81.19215301638269,
            ],
            [

                'name' => 'Raebareli',
                'type' => \App\Constants\UpldbCentreName::DeepFrozenSemenStation,
                'icon' => 'images/map-icons/frozen-semen-station.png',
                'latitude' => 26.250875662838403,
                'longitude' => 81.25405302287281,
            ],
            [

                'name' => 'Prayagraj',
                'type' => \App\Constants\UpldbCentreName::UpldbZonalCentre,
                'icon' => 'images/map-icons/upldb.png',
                'latitude' => 25.479059247807154,
                'longitude' => 81.8516905053315,
            ],
            [

                'name' => 'Varanasi',
                'type' => \App\Constants\UpldbCentreName::UpldbZonalCentre,
                'icon' => 'images/map-icons/upldb.png',
                'latitude' => 25.277225596270544,
                'longitude' => 82.98009106246181,
            ],
            [

                'name' => 'Gorakhpur',
                'type' => \App\Constants\UpldbCentreName::UpldbZonalCentre,
                'icon' => 'images/map-icons/upldb.png',
                'latitude' => 26.779017352992454,
                'longitude' => 83.39944367642389,
            ],
            [

                'name' => 'Lalitpur',
                'type' => \App\Constants\UpldbCentreName::UpldbZonalCentre,
                'icon' => 'images/map-icons/bull.png',
                'latitude' => 24.682678311058776,
                'longitude' => 78.41767719027776,
            ],
            [

                'name' => 'Lalitpur',
                'type' => \App\Constants\UpldbCentreName::BullMotherFarm,
                'icon' => 'images/map-icons/bull.png',
                'latitude' => 26.886556443732417,
                'longitude' => 82.50137320682919,
            ],
            // Add more locations as needed
        ];

        // Insert the sample data into the 'locations' table
        foreach ($locations as $locationData) {
            UpLdbCenter::create($locationData);
        }
    }
}
