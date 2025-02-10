<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebinarController extends Controller
{
    public function subscribers(Request $request)
    {
        return view('broadcaster.subscriber');
    }

    public function host(Request $request)
    {
        return view('broadcaster.host');
    }
}