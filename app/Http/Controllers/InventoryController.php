<?php

namespace App\Http\Controllers;

use App\Models\API\Role;
use App\Models\User;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $role = Role::where('name', 'deo')->first();
        $role_id = $role ? $role->id : null;

        $deoUsers = User::where('role_id', $role_id)->with('getDeoUser.zone', 'getDeoUser.division', 'getDeoUser.district', 'getDeoUser.block', 'getDeoUser.aicenter')->get();
        // dd($deoUsers);
        return view('inventory.index', compact('deoUsers'));
    }

    public function createDEO()
    {
        return view('inventory.create_deo');
    }
}
