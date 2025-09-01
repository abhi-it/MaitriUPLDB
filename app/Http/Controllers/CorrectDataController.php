<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Correctdata; 

class CorrectDataController extends Controller
{
    public function index(Request $request)
    {
        $query = Correctdata::query();


        if ($request->filled('mandal_name')) {
            $query->where('mandal_name', $request->mandal_name);
        }

        if ($request->filled('janpad_name')) {
            $query->where('janpad_name', $request->janpad_name);
        }

        if ($request->filled('tehsil')) {
            $query->where('tehsil', $request->tehsil);
        }

        $data = $query->orderByDesc('id')->paginate(10);


        $mandals =Correctdata::select('mandal_name')->groupBy('mandal_name')->get();
        $janpads = Correctdata::select('janpad_name')->groupBy('janpad_name')->get();
        $tehsils = Correctdata::select('tehsil')->groupBy('tehsil')->get();
       
        $mandalNames = Correctdata::groupBy('mandal_name')->pluck('mandal_name');
        $janpadNames = Correctdata::groupBy('janpad_name')->pluck('janpad_name');
        return view('correctdata.index', compact('data', 'mandalNames', 'janpadNames', 'mandals', 'janpads', 'tehsils'))
            ->with([
                'selectedMandal' => $request->mandal_name,
                'selectedJanpad' => $request->janpad_name,
                'selectedTehsil' => $request->tehsil,
            ]);;
    }

    public function store(Request $request)
    {
        $request->validate([
            'mandal_name' => 'required|string',
            'janpad_name' => 'required|string',
            'block'       => 'nullable|string',
            'new_block'   => 'nullable|string',
            'tehsil'      => 'nullable|string',
            'new_tehsil'  => 'nullable|string',
        ]);

        $block  = $request->filled('new_block') ? $request->new_block : $request->block;
        $tehsil = $request->filled('new_tehsil') ? $request->new_tehsil : $request->tehsil;

        if (!$block || !$tehsil) {
            return back()->withErrors(['block' => 'Block and Tehsil are required.'])->withInput();
        }
        Correctdata::create([
            'mandal_name' => $request->mandal_name,
            'janpad_name' => $request->janpad_name,
            'block'       => $block,
            'tehsil'      => $tehsil,
        ]);
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
