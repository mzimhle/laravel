<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comm extends Model
{
    use HasFactory;
	
	protected $table = 'comm';
    /**
     * Lets associate this to an admin
	 * P.S. it is assumed that the foreign key column name is 'admin_id' you can override it as we did with member.
     */
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
    /**
     * Lets associate this to a member
	 * P.S. it is assumed that the foreign key column name is 'member_id', but we are going to override it, this is if the column name is different.
	 * P.S. if the key you are linking to is not 'id', you can add a 3rd parameter to define it. $this->hasOne(Member::class, 'member_id', 'id')
     */
    public function member()
    {
        return $this->hasOne(Member::class, 'member_id');
    }		
	
}
