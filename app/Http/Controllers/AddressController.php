<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Address;
use Illuminate\Http\Request;
use DataTables;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function address(int $id)
    {
		$member = Member::find($id);
        return view('member.address',compact('member'));		
    }
    /**
     * Method to get the data for members.
     */	
    public function paginate(Request $request, int $id)
    {
        if ($request->ajax()) {

			$data = Address::where('member_id', $id)->get();

            return Datatables::of($data)
                ->addColumn('address', function($row) {
                    return $row->address_1.($row->address_2 !== null ? ', '.$row->address_2 : '').', '.$row->area_code;
                })
                ->addColumn('destroy', function($row){
                    return '<button onclick="deleteMemberModal(\''.$row->id.'\'); return false;" class="btn btn-danger">Delete</button>';
                })				
                ->rawColumns(['address', 'destroy'])
                ->make(true);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id)
    {
		$member = Member::find($id);
		
		if($member) {
			
			$request->validate([
				'address_1' => 'required',
				'address_2' => 'required',
				'area_code' => 'required',
				'type' => 'required|in:PHYSICAL,POSTAL,WORK'
			]);

			$data = $request->all();
			// Insert data.
			$admin = Address::create([
				'member_id' => $member->id,
				'address_1' => $data['address_1'],
				'address_2' => $data['address_2'],
				'area_code' => $data['area_code'],
				'type' => $data['type']	
			]);
		} else {
			return redirect()->back()->with('error', 'Member was not found');  
		}
        return redirect()->back()->with('success','Address created successfully.');
    }	
}