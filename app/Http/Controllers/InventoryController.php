<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $deoUsers = User::where('role_id', 5)->with('getDeoUser.zone', 'getDeoUser.division', 'getDeoUser.district', 'getDeoUser.block', 'getDeoUser.aicenter')->get();
        // dd($deoUsers);
        return view('inventory.index', compact('deoUsers'));
    }

    public function createDEO()
    {
        return view('inventory.create_deo');
    }
}
