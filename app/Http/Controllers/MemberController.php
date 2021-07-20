<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Rules\RSAnumber;
use Illuminate\Http\Request;
use DataTables;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('member.index');
    }
    /**
     * Method to get the data for members.
     */	
    public function paginate(Request $request)
    {
        if ($request->ajax()) {
            $data = Member::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('address', function($row){
                    return '<a class="btn btn-info" href="'.route('address', ['id' => $row->id]).'">Address</a>';
                })
                ->addColumn('edit', function($row){
                    return '<a class="btn btn-primary" href="'.route('member.edit', ['id' => $row->id]).'">Edit</a>';
                })
                ->addColumn('destroy', function($row){
                    return '<button onclick="deleteMemberModal(\''.$row->id.'\'); return false;" class="btn btn-danger">Delete</button>';
                })				
                ->rawColumns(['address', 'edit', 'destroy'])
                ->make(true);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('member.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
			'cellphone' => ['required', 'unique:member', new RSAnumber],
			'email' => 'nullable|email|unique:member'
        ]);

        Member::create($request->all());

        return redirect()->route('member.index')
                        ->with('success','Member created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
		$member = Member::find($id);
        return view('member.show',compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
		$member = Member::find($id);		
        return view('member.edit',compact('member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
	 
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
			'cellphone' => ['required', 'unique:member,cellphone,'. $id, new RSAnumber],
			'email' => 'nullable|email|unique:member,email,'. $id
        ]);
		$member = Member::find($id);	
        $member->update($request->all());
    
        return redirect()->route('member.index')
                        ->with('success','Member updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
		$member = Member::find($id);
		
        if($member->delete() !== null) {
			return response()->json(['success'=>'Member deleted successfully']);
		} else {
			return response()->json(['warning'=>'Member not deleted']);
		}
    }
}
