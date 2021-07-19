<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Admin extends Model implements AuthenticatableContract
{
    use HasFactory;
	use Authenticatable;
	
	protected $table = 'admin';	

    protected $fillable = ['name', 'email', 'cellphone', 'password', 'password_clear'];
}
