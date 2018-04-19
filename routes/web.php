<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
Route::get('/', 'PagesController@index');

Route::group(['middlewars' => 'guest'], function(){
	Route::get('registration', 'Auth\RegisterController@showRegistrationForm')->name('registration');
	Route::post('register', 'Auth\RegisterController@register')->name('register');
	Route::get('finish-registration', 'Auth\RegisterController@finish_registration')->name('finish_registration');
	Route::get('registration-confirm/{confirmation_hash}', 'Auth\RegisterController@confirmation'); 
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login')->name('run_login');
	Route::get('test_mail', 'Auth\RegisterController@test_mail');
});

Route::get('about', 'PagesController@about'); 
Route::get('contacts', 'PagesController@contacts'); 
Route::get('under-construction', 'PagesController@underConstruction');
Route::get('terms-of-use', 'PagesController@termsOfUse');
 
Route::get('educational-institutions', 'InstitutionController@index'); 
Route::get('institution/{id}', 'InstitutionController@view');

Route::get('teachers', 'TeachersController@index');  

Route::group(['middlewars' => 'auth'], function(){
	Route::get('user/profile', 'ProfileController@userProfile')->name('user_profile');
	Route::post('user/updatePass', 'ProfileController@updatePassword')->name('update_pass'); 
	Route::post('user/update-profile', 'ProfileController@editProfile')->name('update_profile'); 

	Route::get('user/deleteUserEducation/{id}', 'ProfileController@deleteUserEducation'); 
	Route::get('user/deleteUserActivities/{id}', 'ProfileController@deleteUserActivities'); 
	Route::get('user/deleteUserExperience/{id}', 'ProfileController@deleteUserExperience'); 

	Route::get('user/forgot-password', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('forgot_password');
	Route::post('user/forgot-password', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('send_reset_link'); 
});

Route::get('user/logout', function(){
	Auth::guard('web')->logout(); 
	return  redirect('/');
})->name('logout');

Route::get('admin/login', 'Admin\LoginController@showLoginForm', ['guard' => 'admin'])->name('admin_login');
Route::post('admin/login', 'Admin\LoginController@login', ['guard' => 'admin'])->name('admin_run_login'); 

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function() { 
	Route::get('/', function(){
		return redirect()->route('admin_menu');
	});
	
	Route::group(['prefix' => 'menu'], function() { 
		Route::get('/', 'MenuController@show')->name('admin_menu');  
		Route::get('{id}/edit', 'MenuController@showeditForm'); 
		Route::get('add', 'MenuController@showAddForm');
		Route::post('create', 'MenuController@create'); 
		Route::post('{id}/update', 'MenuController@update'); 
	}); 

	Route::group(['prefix' => 'profile'], function() { 
		Route::get('/', 'ProfileController@showForm')->name('profile');
		Route::post('edit', 'ProfileController@edit');
		Route::post('addNewUser', 'ProfileController@addNewUser');
	}); 

	Route::group(['prefix' => 'ajax'], function() {  
		Route::post('depth-sort', 'AjaxController@depthSort')->name('depth_sort');
		Route::post('viewElement', 'AjaxController@viewElement')->name('viewElement'); 
		Route::post('deleteElement', 'AjaxController@deleteElement')->name('deleteElement'); 
	}); 

	Route::get('logout', 'LoginController@logout')->name('logout'); 
});
 

 