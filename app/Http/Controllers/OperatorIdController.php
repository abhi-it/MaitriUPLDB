<?php

namespace App\Http\Controllers;

use App\Models\API\Role;
use App\Models\User;
use App\Models\Districts;
use Illuminate\Http\Request;

class OperatorIdController extends Controller
{

    public function index(){
        $roles = Role::whereIn('name', ['zone','district', 'deo'])->pluck('id');
        $zoneUsers = User::whereIn('role_id', $roles)->with(['getDeoUser.zone'])->get();
        return view('operatorId.index', compact('zoneUsers'));
    }
}
