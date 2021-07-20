<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;

class Address extends Model
{
    use HasFactory;
	
	protected $table = 'address';	
    protected $fillable = ['member_id', 'type', 'address_1', 'address_2', 'area_id', 'area_code'];
	/*
	 * So with eloquent, it will be assumned that the 'member' table's primary key is 'id' on member table.
	 * But on the address table, it will be assumed that the member's id will be 'member_id'.
	 * This method is called "snake case"
	 * 'id' will be the column of member table
	 * 'member_id' will be the column the on the address table
	 * To access it you need to get it using $address->member->name
	 */
    public function member() {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }	
}
