<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CorrectData; 

class CorrectDataController extends Controller
{
    public function index()
    {
        $data = CorrectData::paginate(10);  
        $mandalNames = CorrectData::groupBy('mandal_name')->pluck('mandal_name');
        $janpadNames = CorrectData::groupBy('janpad_name')->pluck('janpad_name');
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
  
        CorrectData::create($request->all());
        return back()->with('success', 'Data added successfully');
    }

    public function edit($id)
    {
        $data = CorrectData::find($id);
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
        $data = CorrectData::find($id);
        $data->update($request->all());
        return back()->with('success', 'Data updated successfully');
    }

    public function destroy($id)
    {
        CorrectData::destroy($id);
        return back()->with('success', 'Data deleted successfully');
    }

    public function getJanpadNames(Request $request)
    {
        $janpadNames = CorrectData::where('mandal_name', $request->mandal_name)
                                  ->groupBy('janpad_name')
                                  ->pluck('janpad_name');

        return response()->json($janpadNames);
    }

    public function getTehsilNames(Request $request)
    {
        $tehsilNames = CorrectData::where('mandal_name', $request->mandal_name)
                                  ->where('janpad_name', $request->janpad_name)
                                  ->groupBy('tehsil')
                                  ->pluck('tehsil');

        return response()->json($tehsilNames);
    }


    public function getBlockNames(Request $request)
    {
        $blockNames = CorrectData::where('mandal_name', $request->mandal_name)
                                ->where('janpad_name', $request->janpad_name)
                                ->where('tehsil', $request->block)
                                ->groupBy('block')
                                ->pluck('block');

        return response()->json($blockNames);
    }

    public function storeNewTehsil(Request $request)
    {
        CorrectData::create([
            'tehsil' => $request->tehsil,
            'mandal_name' => $request->mandal_name,
            'janpad_name' => $request->janpad_name,
            'block' => $request->block,
        ]);

        return response()->json(['message' => 'Tehsil added successfully']);
    }
  
    public function storeNewBlock(Request $request)
    {
        CorrectData::create([
            'block' => $request->block,
            'mandal_name' => $request->mandal_name,
            'janpad_name' => $request->janpad_name,
        ]);

        return response()->json(['message' => 'Block added successfully']);
    }
}
