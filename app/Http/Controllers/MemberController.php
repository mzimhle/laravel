<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Rules\RSAnumber;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member = Member::latest()->paginate(5);
    
        return view('member.index',compact('member'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
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
			'cellphone' => ['required', 'unique:member', new RSAnumber],
			'email' => 'nullable|email|unique:member'
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
