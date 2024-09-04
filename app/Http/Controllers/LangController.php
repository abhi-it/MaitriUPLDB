<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Auth;

class LangController extends Controller
{
    public function index(): View
    {
        return view('lang');
    }

    public function change(Request $request)
    {
        App::setLocale($request->lang);
        
        session()->put('locale', $request->lang);

        return redirect()->back();
    }
}
