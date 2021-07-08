# Laravel Application
This is an application that does the following:
- CRUD actions for members
- CRUD actions for address

Techologies used:
- Composer (https://getcomposer.org/download/)
- PHP 7.3.*

Folder structure is as below, our application will reside in the /www folder.: 
```sh
/laravel.loc
	/logs
	/www
```
To install laravel, we do it via composer then we open the server:
```sh
> composer create-project laravel/laravel www
....
....
> php artisan serve
```

# BASICS

Before we start, we need to create migration for 'members' table, this is basically to create a table for members if it is not in the database already.
```sh
> php artisan make:migration create_member_table --create=member
```
After the above, we need to go to the created file in /database/migrations, this is where you will find your migration file, edit it with the columns you need, if you want to add the 'created_at' and updated_at' you will add the  $table->timestamps(); in the said file last.

Your controllers and models (entities) are saved in the folders:

```sh
/app
	/Http
		/Controllers
	/Models
```
After the above, lets start with the model first
```sh
> php artisan make:model Member
```
Remember after adding the model to update it and add the fillable:
```sh
    protected $fillable = [
        'name', 'surname', 'cellphone', 'email'
    ];	
```
After the model, lets create the controller and link it to the model
```sh
> php artisan make:controller MemberController --resource --model=Member
```
After the above, lets create the links to the controller, go to /routes/web.php and add:
```sh
use App\Http\Controllers\MemberController;
...
...
Route::resource('member', MemberController::class);
```
After the above, you will need to populate the controller file which will come with 7 methods.
Now lets create the view files, create the folder /resources/views/member, with the following files:
- layout.blade.php
- index.blade.php
- create.blade.php
- edit.blade.php
- show.blade.php

Populate the files accordingly, check the files in this repository, 