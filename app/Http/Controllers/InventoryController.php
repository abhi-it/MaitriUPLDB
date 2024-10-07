<?php

namespace App\Http\Controllers;

use App\Models\API\Role;
use App\Models\User;
use App\Models\Districts;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $roles = Role::whereIn('name', ['deo', 'district-deo'])->pluck('id');
        $deoUsers = User::whereIn('role_id', $roles)
        ->with([
            'getDeoUser.zone',
            'getDeoUser.division',
            'getDeoUser.district',
            'getDeoUser.block',
            'getDeoUser.aicenter'
        ])->get();

        
        $districtName = [];
        foreach ($deoUsers as $user) {
            $districtIds = explode(',', $user['getDeoUser']['district_id']); // Get district IDs
            $districtNames = Districts::whereIn('id', $districtIds)->get();

            // Store the district names for the current user
            $districtName[$user->id] = $districtNames; // Use user ID as the key
        }
        return view('inventory.index', compact('deoUsers','districtName'));
    }

    public function createDEO()
    {
        return view('inventory.create_deo');
    }
}
