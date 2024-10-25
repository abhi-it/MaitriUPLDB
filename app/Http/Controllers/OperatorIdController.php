<?php

namespace App\Http\Controllers;

use App\Models\API\Role;
use App\Models\InventoryMap;
use App\Models\DeoUser;
use App\Models\Zonestock; 
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

    public function userDelete($id) {
        $event = User::findOrFail($id);
        $event->delete();
        InventoryMap::where('assign_user_id', $id)->delete();
        InventoryMap::where('user_id', $id)->delete();
        DeoUser::where('user_id', $id)->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
