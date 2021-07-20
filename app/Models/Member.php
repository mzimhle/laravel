<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Address;

class Member extends Model
{
    use HasFactory;
	
	protected $table = 'member';
    protected $fillable = ['name', 'surname', 'cellphone', 'email'];
	
	/*
	 * So with eloquent, it will be assumned that the 'member' table's primary key is 'id' on member table.
	 * But on the address table, it will be assumed that the member's id will be 'member_id'.
	 * This method is called "snake case"
	 */
    public function addresses() {
		return $this->hasMany(Address::class);
    }
}
