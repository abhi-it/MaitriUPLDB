<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Correctdata; 

class CorrectDataController extends Controller
{
    public function index()
    {
        $data = Correctdata::paginate(10);  
        $mandalNames = Correctdata::groupBy('mandal_name')->pluck('mandal_name');
        $janpadNames = Correctdata::groupBy('janpad_name')->pluck('janpad_name');
        return view('correctdata.index', compact('data', 'mandalNames', 'janpadNames'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mandal_name' => 'required',
            'janpad_name' => 'required',
            'block' => 'required',
            'tehsil' => 'required',
        ]);
  
        Correctdata::create($request->all());
        return back()->with('success', 'Data added successfully');
    }

    public function edit($id)
    {
        $data = Correctdata::find($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mandal_name' => 'required',
            'janpad_name' => 'required',
            'block' => 'required',
            'tehsil' => 'required',
        ]);
        $data = Correctdata::find($id);
        $data->update($request->all());
        return back()->with('success', 'Data updated successfully');
    }

    public function destroy($id)
    {
        Correctdata::destroy($id);
        return back()->with('success', 'Data deleted successfully');
    }

    public function getJanpadNames(Request $request)
    {
        $janpadNames = Correctdata::where('mandal_name', $request->mandal_name)
                                  ->groupBy('janpad_name')
                                  ->pluck('janpad_name');

        return response()->json($janpadNames);
    }

    public function getTehsilNames(Request $request)
    {
        $tehsilNames = Correctdata::where('mandal_name', $request->mandal_name)
                                  ->where('janpad_name', $request->janpad_name)
                                  ->groupBy('tehsil')
                                  ->pluck('tehsil');

        return response()->json($tehsilNames);
    }


    public function getBlockNames(Request $request)
    {
        $blockNames = Correctdata::where('mandal_name', $request->mandal_name)
                                ->where('janpad_name', $request->janpad_name)
                                ->where('tehsil', $request->block)
                                ->groupBy('block')
                                ->pluck('block');

        return response()->json($blockNames);
    }

    public function storeNewTehsil(Request $request)
    {
        Correctdata::create([
            'tehsil' => $request->tehsil,
            'mandal_name' => $request->mandal_name,
            'janpad_name' => $request->janpad_name,
            'block' => $request->block,
        ]);

        return response()->json(['message' => 'Tehsil added successfully']);
    }
  
    public function storeNewBlock(Request $request)
    {
        Correctdata::create([
            'block' => $request->block,
            'mandal_name' => $request->mandal_name,
            'janpad_name' => $request->janpad_name,
        ]);

        return response()->json(['message' => 'Block added successfully']);
    }
}
