<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get("create-temp-user", function(){
	$user = new User;
	$user->name = 'Arko';
	$user->email = 'arko@test.com';
	$user->save();

	$user = new User;
	$user->name = 'Musnad';
	$user->email = 'musnad@test.com';
	$user->save();
});
Route::get("create-temp-role", function(){
	$owner = new Role;
	$owner->name = 'Owner';
	$owner->save();

	$admin = new Role;
	$admin->name = 'Admin';
	$admin->save();

	echo "Roles Created";


});

Route::get("attach-temp-role", function(){
	$user = User::where('name','=','Arko')->first();

	
    $role = Role::where('name', '=', 'Admin')->first();
 var_dump($role);
	/* OR the eloquent's original: */
	$user->roles()->attach( $role->id );
	echo "role attached";
});

Route::get("create-temp-permission", function(){
	$managePosts = new Permission;
	$managePosts->name = 'manage_posts';
	$managePosts->display_name = 'Manage Posts';
	$managePosts->save();

	$manageUsers = new Permission;
	$manageUsers->name = 'manage_users';
	$manageUsers->display_name = 'Manage Users';
	$manageUsers->save();

	echo "Temp Permissions Created successfully";
});

Route::get("attach-temp-permission-to-roles", function(){

	$owner = Role::where('name', '=', 'Owner')->first();
	$admin = Role::where('name', '=', 'Admin')->first();

	$manageUsers = Permission::where('name', '=', 'manage_users')->first();
	$managePosts = Permission::where('name', '=', 'manage_posts')->first();

	$owner->perms()->sync(array($managePosts->id,$manageUsers->id));
	$admin->perms()->sync(array($managePosts->id));

	echo "Temp permision has been attached to the roles";
});

Route::get("role-wise-permission-check", function(){

	$user = User::with('roles')->get();

	foreach (User::with('roles')->get() as $u)
{
	
    echo $u->name;
	    foreach ($u->roles as $role) {
	    	
	    	echo " is ".$role->name;
	    	echo "<br>";
	    }
   
}

});

Route::get("test", function(){

	$user = User::find(1);

	if ($user->hasRole("Owner" )) {
		echo "Owner";
		if ($user->can("manage_users")) {
		echo " can manage users";
	}
	if ($user->can("manage_posts")) {
		echo " can manage post";}

	}elseif ($user->hasRole("Admin")) {
		echo "Admin";
		if ($user->can("manage_users")) {
		echo " can manage users";
	}
	if ($user->can("manage_posts")) {
		echo " can manage post";}
	}
	   
	echo "<br>";

	$test = (string)$user->roles;

	 echo $test;



	
	
	
	

});

