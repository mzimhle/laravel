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
Remember after adding the model to update it and add the fillable and the table variables, the table one is to define the table linked to this model otherwise it will use the plural version of the model, in this case 'members', and fillable is to tell it which items are updatable in the form:
```sh
	protected $table = 'member';
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

P.S.: The home page is defined in the routes/web.php file with the code:
```sh
Route::get('/', function () {
    return view('welcome');
});
```
The 'welcome' indicates to the file /resources/views/welcome.blade.php, you can change this here.
Populate the files accordingly, check the files in this repository. The website is running perfectly.
The process of this is as follows, this is sequencial as displayed on here:

##### /routes/web.php : 

Routes for the member are created here by that one line in the file we added based on controller methods, this is the below result of generated links
- index (/member)
- edit (/member/3/edit)
- show (/member/3)
- create (/member/create)
- delete (/member/3/destroy) used ajax for this one.

##### /app/Http/Controllers/MemberController.php :

Once the view has been created, it will direct us to the controller's corresponding method, see above routes (links). 
To call the views here we use 'member.index', this means in he views folder, go to member folder and look for the file 'index.blade.php'.
Based on how laravel works, database CRUD occurs here on submission. Check the code.

##### /resources/views/member/ :

This is where ALL views are stored, we are using blade on this one instead of twig as in symfony.
These have their own variables

## VALIDATION

We are now going to validate the cellphone number and the email. We need to make sure that:
- Cellphone is unique, required, only has 10 digits and starts with 0.
- Email is unique, not required, must be a valid email address.
- Create custom validation

##### Validate cellphone and email

In the controller, where we add or update the member, we should add the following code to validate, the 'nullable' is for email to be null.:

```sh
        $request->validate([
			...
			'cellphone' => 'required|regex:/^0([0-9]*)$/|min:10|unique:member',
			'email' => 'nullable|email|unique:member',
			...
        ]);
```

Now let us create a custom validation method.:

```sh
> php artisan make:rule RSAnumber
```
The above will create the file /app/Rules/RSAnumber.php, under the method 'passes' you will add your validation.
After adding the rule, implement it in the controller method validating with the following:
```sh
        $request->validate([
			...
			'cellphone' => ['required', 'unique:member', new RSAnumber],
			...
        ]);	
```