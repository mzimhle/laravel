<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
	
	protected $table = 'address';	
    protected $fillable = ['member_id', 'type', 'address_1', 'address_2', 'area_id', 'area_code'];
}
