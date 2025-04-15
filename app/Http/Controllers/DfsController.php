<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Divisions;
use App\Models\Districts;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Hash;

class DfsController extends Controller
{
    public function viewDfs() {
        $districts  = Districts::get();
        $divisions  = Divisions::get();
        $dfsUser = User::where('user_type', 'DFS')
                    ->with(['division', 'district'])
                    ->orderBy('id', 'desc')
                    ->paginate(10);
    
        return view('dfsaccount.index', compact('dfsUser'));
    }
    

    public function createDfs(){
        $districts  = Districts::get();
        $divisions  = Divisions::get();
        return view('dfsaccount.create', compact('districts', 'divisions'));
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        $divisions = Divisions::all();
        $districts = Districts::all();

        return view('dfsaccount.create', compact('user', 'divisions', 'districts'));
    }

    public function saveDfsData(Request $request){
       
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'middle_name'   => 'nullable|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'MobileNumber'  => 'required|digits:10|unique:users,MobileNumber',
            'gender'        => 'required|in:male,female,others',
            'division_id'   => 'required|integer',
            'district_id'   => 'required|string',
            'tehsil'        => 'required|string|max:255',
            'block'         => 'required|string|max:255',
            'post_office'   => 'required|string|max:255',
            'pincode'       => 'required|digits:6',
            'gram_panchayat'=> 'required|string|max:255',
        ]);
        $name = $request->first_name.' '.$request->middle_name.' '.$request->last_name;
        $districts = Districts::where('name_hindi', $request->district_id)->first();
        $role = DB::table('role')->where('name', 'dfs')->first();
        User::create([
            'FirstName'         => $request->first_name,
            'middle_name'       => $request->middle_name,
            'LastName'          => $request->last_name,
            'name'              => $name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'MobileNumber'      => $request->MobileNumber,
            'gender'            => $request->gender,
            'role'              => $role->display_name, //DFS
            'role_id'           => $role->id,
            'user_type'         => $role->display_name, //DFS
            'division_id'       => $request->division_id,
            'district_id'       => $districts->id,
            'tehsil'            => $request->tehsil,
            'block'             => $request->block,
            'post_office'       => $request->post_office,
            'pincode'           => $request->pincode,
            'gram_panchayat'    => $request->gram_panchayat,
        ]);
        return redirect()->back()->with('success', 'DFS user created successfully!');
    }

    public function update(Request $request, $id) {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'MobileNumber' => 'required|numeric',
            'gender' => 'required',
            'division_id' => 'required',
            'district_id' => 'required',
        ]);

        $districts = Districts::where('name_hindi', $request->district_id)->first();
        $user = User::findOrFail($id); 
        $name = $request->first_name.' '.$request->middle_name.' '.$request->last_name;
        $user->FirstName         = $request->first_name;
        $user->LastName          = $request->last_name;
        $user->name              = $name;
        $user->email             = $request->email;
        $user->password          = Hash::make($request->password);
        $user->MobileNumber      = $request->MobileNumber;
        $user->gender            = $request->gender;
        $user->division_id       = $request->division_id;
        $user->district_id       = $districts->id;
        $user->tehsil            = $request->tehsil;
        $user->block             = $request->block;
        $user->post_office       = $request->post_office;
        $user->pincode           = $request->pincode;
        $user->gram_panchayat    = $request->gram_panchayat;
      
        $user->update();

        return redirect()->route('view-dfs')->with('success', 'DFS User updated successfully!');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('view-dfs')->with('success', 'DFS User deleted successfully!');
    }
}