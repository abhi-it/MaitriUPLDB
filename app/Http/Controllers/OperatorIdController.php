<?php

namespace App\Http\Controllers;

use App\Models\API\Role;
use App\Models\User;
use App\Models\Districts;
use Illuminate\Http\Request;

class OperatorIdController extends Controller
{

    public function index(){
        $roles = Role::whereIn('name', ['deo', 'district-deo'])->pluck('id');
        $deoUsers = User::whereIn('role_id', $roles)
        ->with([
            'getDeoUser.zone',
            'getDeoUser.division',
            'getDeoUser.district',
            'getDeoUser.block',
            'getDeoUser.aicenter'
        ])->get();

        
        return view('operatorId.index', compact('deoUsers'));
    }

    public function createDEO()
    {
        return view('inventory.create_deo');
    }
}
