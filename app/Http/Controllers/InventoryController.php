<?php

namespace App\Http\Controllers;

use App\Models\API\Role;
use App\Models\User;
use App\Models\Zone;
use App\Models\InventoryMap; 
use App\Models\RemainingStock;
use App\Models\DeoUser;
use App\Models\Districts;
use Illuminate\Http\Request;
use App\Models\Zonestock;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index(){
        $zones = Zone::all();
        $user_id = Auth::user()->id;
        $adminInventory = RemainingStock::where('user_id', $user_id)->get();
        return view('inventory.zone-stock-form', compact('zones', 'adminInventory','user_id'));
    }

    public function distributedForm()
    {
        $user_id = Auth::user()->id;
        $zones   = Zone::all();

        // Get raw stock
        $adminStocks = Zonestock::where('location', 'head_office')->get();
        $zoneStocks = Zonestock::where('location', 'zone')->get();
        // Aggregated stocks
        $finalAdminStocks = $this->aggregateStocks($adminStocks);
        $finalZoneStocks  = $this->aggregateStocks($zoneStocks);

        //Remaining stock after zone distribution
        $finalStocks = $this->subtractStocks($finalAdminStocks, $finalZoneStocks);

        // Debug if needed
        //echo "<pre>"; print_r($finalStocks->toArray()); exit;

        return view('inventory.zone-stock-form', compact('zones', 'user_id', 'finalStocks'));
    }

    private function aggregateStocks($stocks)
    {
        return $stocks
            ->groupBy(function ($row) {

                switch ($row->item_type) {

                    case 'species_semen':
                        return implode('|', [
                            $row->item_type,
                            $row->species_semen,
                            $row->breed_type,
                            $row->breed,
                            $row->semen_type,
                            $row->bull_id,
                        ]);

                    case 'container':
                        return implode('|', [
                            $row->item_type,
                            $row->container_capacity,
                        ]);

                    default:
                        return $row->item_type;
                }
            })
            ->map(function ($items) {

                $first = $items->first();

                return [
                    'item_type'          => $first->item_type,
                    'item_name'          => $first->item,
                    'species_semen'      => $first->species_semen,
                    'breed_type'         => $first->breed_type,
                    'breed'              => $first->breed,
                    'semen_type'         => $first->semen_type,
                    'bull_id'            => $first->bull_id,
                    'container_capacity' => $first->container_capacity,
                    'total_qty'          => $items->sum('quantity'),
                ];
            })
            ->values();
    }

    private function subtractStocks($adminStocks, $zoneStocks)
    {
        // Index zone stocks by unique key
        $zoneIndex = $zoneStocks->mapWithKeys(function ($item) {
            return [
                $this->stockKey($item) => $item['total_qty']
            ];
        });

        // Subtract quantities
        return $adminStocks->map(function ($adminItem) use ($zoneIndex) {

            $key = $this->stockKey($adminItem);

            $zoneQty = $zoneIndex[$key] ?? 0;

            $adminItem['remaining_qty'] = max(
                0,
                $adminItem['total_qty'] - $zoneQty
            );

            return $adminItem;
        });
    }

    private function stockKey($row)
    {
        switch ($row['item_type']) {

            case 'species_semen':
                return implode('|', [
                    $row['item_type'],
                    $row['species_semen'],
                    $row['breed_type'],
                    $row['breed'],
                    $row['semen_type'],
                    $row['bull_id'],
                ]);

            case 'container':
                return implode('|', [
                    $row['item_type'],
                    $row['container_capacity'],
                ]);

            default:
                return $row['item_type'];
        }
    }

    public function saveDistributedFormData(Request $request)
    {
        //echo '<pre>';print_r($request->all()); exit;
        $user_id = Auth::user()->id;

        $liquid_nitrogen_qty    = $request->liquid_nitrogen;
        $semens                 = $request->semen; //[]
        $breedType              = $request->breedType; //[]
        $breed                  = $request->breed; //[]
        $semen_type             = $request->semen_type; //[]
        $bull_id                = $request->bull_id; //[]
        $semen_straws           = $request->semen_straws; //[] quantity

        $banner_qty             = $request->banner;
        $dangler_qty            = $request->dangler;
        $standee_qty            = $request->standee;
        $pamphlet_qty           = $request->pamphlet;
        $ai_kit_qty             = $request->ai_kit;
        $container_capacity     = $request->container_capacity; //[]
        $container_qty          = $request->container_qty; //[]
        $scheme                 = $request->scheme;
        $zone_id                = $request->select_zone;
        $supply_date            = $request->supply_date;

        if ($liquid_nitrogen_qty) {
            $inventoryData = [
                'user_id'     => $user_id,
                'zone_id'     => $zone_id,
                'location'    => 'zone',
                'supply_date' => $supply_date,
                'item_type'    => 'liquid_nitrogen',
                'item'         => 'Liquid Nitrogen',
                'quantity'     => $liquid_nitrogen_qty,
            ];
            $inventory  = new Zonestock($inventoryData);
            $inventory->save();
        }

        if($semens){
            foreach($semens as $key => $semen){
                $inventoryData = [
                    'user_id'     => $user_id,
                    'zone_id'     => $zone_id,
                    'location'    => 'zone',
                    'supply_date' => $supply_date,

                    'item_type'              => 'species_semen',
                    'item'                   => 'Species Semen',
                    'species_semen'          => $semen,
                    'breed_type'             => $breedType[$key],
                    'breed'                  => $breed[$key],
                    'semen_type'             => $semen_type[$key],
                    'bull_id'                => $bull_id[$key],
                    'quantity'               => $semen_straws[$key],
                    'scheme'                 => $scheme,
                ];
        
                $inventory  = new Zonestock($inventoryData);
                $inventory->save();
            }
        }

        if ($banner_qty) {
            $inventoryData = [
                'user_id'     => $user_id,
                'zone_id'     => $zone_id,
                'location'    => 'zone',
                'supply_date' => $supply_date,

                'item_type'   => 'banner',
                'item'        => 'Banner',
                'quantity'    => $banner_qty,
                'scheme'      => $scheme,
            ];

            $inventory  = new Zonestock($inventoryData);
            $inventory->save();
        }

        if ($dangler_qty) {
            $inventoryData = [
                'user_id'     => $user_id,
                'zone_id'     => $zone_id,
                'location'    => 'zone',
                'supply_date' => $supply_date,

                'item_type'   => 'dangler_chart',
                'item'        => 'Dangler Chart',
                'quantity'    => $dangler_qty,
                'scheme'      => $scheme,
            ];
            $inventory  = new Zonestock($inventoryData);
            $inventory->save();
        }

        if ($standee_qty) {
            $inventoryData = [
                'user_id'     => $user_id,
                'zone_id'     => $zone_id,
                'location'    => 'zone',
                'supply_date' => $supply_date,

                'item_type'   => 'standee',
                'item'        => 'Standee',
                'quantity'    => $standee_qty,
                'scheme'      => $scheme,
            ];
            $inventory  = new Zonestock($inventoryData);
            $inventory->save();
        }

        if ($pamphlet_qty) {
            $inventoryData = [
                'user_id'     => $user_id,
                'zone_id'     => $zone_id,
                'location'    => 'zone',
                'supply_date' => $supply_date,

                'item_type'   => 'pamphlet',
                'item'        => 'Pamphlet',
                'quantity'    => $pamphlet_qty,
                'scheme'      => $scheme,
            ];
            $inventory  = new Zonestock($inventoryData);
            $inventory->save();
        }

        if ($ai_kit_qty) {
            $inventoryData = [
                'user_id'     => $user_id,
                'zone_id'     => $zone_id,
                'location'    => 'zone',
                'supply_date' => $supply_date,

                'item_type'   => 'ai_kit',
                'item'        => 'AI Kit',
                'quantity'    => $ai_kit_qty,
                'scheme'      => $scheme,
            ];
            $inventory  = new Zonestock($inventoryData);
            $inventory->save();
        }

        if($container_capacity){
            foreach($container_capacity as $key => $capacity){
                $inventoryData = [
                    'user_id'     => $user_id,
                    'zone_id'     => $zone_id,
                    'location'    => 'zone',
                    'supply_date' => $supply_date,

                    'item_type'           => 'container',
                    'item'                => 'Container',
                    'container_capacity'  => $capacity,
                    'quantity'            => $container_qty[$key],
                    'scheme'              => $scheme,
                ];
        
                $inventory  = new Zonestock($inventoryData);
                $inventory->save();
            }
        }

        return redirect()->back()->with('success','Stock data distributed successfully!');

    }


    public function checkStockLimit(){
        $user_id = $_REQUEST['user_id'];
        $type = $_REQUEST['type'];
        $value = $_REQUEST['value'];
        $remainingStock = RemainingStock::where('user_id', $user_id)->first();

        if ($value !== null && $remainingStock && $type == 'demand_section') {
            $msg = ($remainingStock['demand_section'] >= $value) ? '' : 'Your number is high Out of range';
            echo json_encode(['demand' => $msg]);
            return;
        }

        if ($value !== null && $remainingStock && $type == 'banner') {
            $msg = ($remainingStock['banner'] >= $value) ? '' : 'Your number is high Out of range';
            echo json_encode(['banner' => $msg]);
            return;
        }

        if ($value !== null && $remainingStock && $type == 'dangler') {
            $msg = ($remainingStock['dangler'] >= $value) ? '' : 'Your number is high Out of range';
            echo json_encode(['dangler' => $msg]);
            return;
        }
        
        if ($value !== null && $remainingStock && $type == 'standee') {
            $msg = ($remainingStock['standee'] >= $value) ? '' : 'Your number is high Out of range';
            echo json_encode(['standee' => $msg]);
            return;
        }

        if ($value !== null && $remainingStock && $type == 'pamphlet') {
            $msg = ($remainingStock['pamphlet'] >= $value) ? '' : 'Your number is high Out of range';
            echo json_encode(['pamphlet' => $msg]);
            return;
        }

        if ($value !== null && $remainingStock && $type == 'ai_kit') {
            $msg = ($remainingStock['ai_kit'] >= $value) ? '' : 'Your number is high Out of range';
            echo json_encode(['ai_kit' => $msg]);
            return;
        }

        if ($value !== null && $remainingStock && $type == 'container') {
            $msg = ($remainingStock['container'] >= $value) ? '' : 'Your number is high Out of range';
            echo json_encode(['container' => $msg]);
            return;
        }
        

    }


    public function zoneStoreData(Request $request){
        
            $zone_id = $request->select_zone;
            if($zone_id != ''){
                $result = User::where(['zone_id' => $zone_id])->where('district_id', 0)->where('division_id', 0)->first(); 
                $deoTableId = DeoUser::where(['user_id' => $result['id']])->first();
                $user_id = $result['id'];
            }
            $breedType = [];
            $semens = $request->semen;
            $breeds = $request->breed;
            if($semens > 0){
                foreach($semens as $key => $semen){
                    if( $semen == 'cow'){
                        if($breeds[$key] == 'swadeshi'){
                            $breedType = $request->breedType1;
                        }else if($breeds[$key] == 'hybrids-crossbred'){
                            $breedType = $request->breedType2;
                        }else if($breeds[$key] == 'videshi'){
                            $breedType = $request->breedType3;
                        }
                    }else if($semen == 'buffalo'){
                        $breedType = $request->breedType4;
                    }else if($semen == 'goat'){
                        $breedType = $request->breedType5;
                    }
                }
            }

            $inventory  = new Zonestock([
                'demand_section'        => $request->demand_section,
                'supply_date'           => $request->selectDate_supply,
                'semen'                 => implode(',', $request->semen),
                'breed'                 => implode(',', $request->breed),
                'breed_type'            => implode(',', $breedType),
                'semen_type'            => implode(',', $request->semen_type),
                'semen_straws'          => implode(',', $request->semen_straws),
                'bull_ids'              => implode(',', $request->bull_id),
                'banner'                => $request->banner,
                'dangler'               => $request->dangler,
                'standee'               => $request->standee,
                'pamphlet'              => $request->pamphlet,
                'ai_kit'                => $request->ai_kit,
                'container_capacity'    => $request->container_capacity,
                'container'             => $request->container,
                'scheme'                => $request->scheme,
            ]);
            $inventory->save();

            $assign_user_id = Auth::user()->id;
            $remainingStock = RemainingStock::where('user_id', $assign_user_id)->first();
            if ($remainingStock) {
                $remainingStock->demand_section = intval($remainingStock->demand_section) - intval($request->demand_section);
                $remainingStock->banner = intval($remainingStock->banner) - intval($request->banner);
                $remainingStock->dangler = intval($remainingStock->dangler) - intval($request->dangler);
                $remainingStock->standee = intval($remainingStock->standee) - intval($request->standee);
                $remainingStock->pamphlet = intval($remainingStock->pamphlet) - intval($request->pamphlet);
                $remainingStock->ai_kit = intval($remainingStock->ai_kit) - intval($request->ai_kit);
                $remainingStock->container = intval($remainingStock->container) - intval($request->container);
                $remainingStock->save();
            }

            $data = [
                'user_id'               => $user_id,
                'demand_section'        => $request->demand_section,
                'supply_date'           => $request->selectDate_supply,
                'semen'                 => implode(',', $request->semen),
                'breed'                 => implode(',', $request->breed),
                'breed_type'            => implode(',', $breedType),
                'semen_type'            => implode(',', $request->semen_type),
                'semen_straws'          => implode(',', $request->semen_straws),
                'bull_ids'              => implode(',', $request->bull_id),
                'banner'                => $request->banner,
                'dangler'               => $request->dangler,
                'standee'               => $request->standee,
                'pamphlet'              => $request->pamphlet,
                'ai_kit'                => $request->ai_kit,
                'container_capacity'    => $request->container_capacity,
                'container'             => $request->container,
                'scheme'                => $request->scheme,
            ];
            RemainingStock::create($data);
            
            InventoryMap::create([
                'assign_user_id' => $assign_user_id,
                'user_id' => $user_id,
                'zone_id' => $zone_id,
                'inventory_id' => $inventory->id,
                'deo_id' => $deoTableId['id']
            ]);

            return redirect()->back()->with('success','Stock data submitted successfully!');

    }

}