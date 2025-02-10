<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\API\Role;

class BroadcastController extends Controller
{
    public function dashboard(){
        return view('broadcaster.dashboard');
    }
}