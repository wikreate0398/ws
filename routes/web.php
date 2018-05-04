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

Route::group(['middleware' => ['web_auth']], function(){ 
	Route::get('user/profile/course', 'ProfileController@showCourse')->name('user_profile');

	Route::get('user/profile/course/{id_course}/edit', 'ProfileController@editCourseForm');

	Route::get('user/profile/reviews', 'ProfileController@showReviews')->name('user_reviews');
	Route::get('user/profile/subscriptions', 'ProfileController@showSubscriptions')->name('user_subscriptions'); 
	Route::get('user/profile/bookmarks', 'ProfileController@showBookmarks')->name('user_bookmarks'); 
	Route::get('user/profile/diplomas', 'ProfileController@showDiploms')->name('user_diplomas'); 

	Route::get('user/profile/course/add', 'ProfileController@showCourseForm')->name('add_course'); 
	Route::post('user/profile/course/save', 'ProfileController@saveCourse')->name('save_course'); 
	Route::post('user/profile/course/{id}/edit', 'ProfileController@editCourse')->name('edit_course'); 
	Route::get('user/profile/course/{id}/delete', 'ProfileController@deleteCourse')->name('delete_course');  
	 
	Route::post('user/profile/loadCourseSubcats', 'ProfileController@loadCourseSubcats');  
	Route::post('user/profile/deleteCourseSection', 'ProfileController@deleteCourseSection');   
	Route::post('user/profile/deleteCourseSectionLecture', 'ProfileController@deleteCourseSectionLecture');   

	Route::get('user/profile/edit', 'ProfileController@showEditForm')->name('user_edit');	 

	Route::post('user/updatePass', 'ProfileController@updatePassword')->name('update_pass'); 
	Route::post('user/update-profile', 'ProfileController@editProfile')->name('update_profile'); 
	Route::post('user/update-image', 'ProfileController@updateImage')->name('update_image'); 

	Route::get('user/deleteUserEducation/{id}', 'ProfileController@deleteUserEducation'); 
	Route::get('user/deleteUserActivities/{id}', 'ProfileController@deleteUserActivities'); 
	Route::get('user/deleteUserExperience/{id}', 'ProfileController@deleteUserExperience'); 

	Route::get('user/forgot-password', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('forgot_password');
	Route::post('user/forgot-password', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('send_reset_link'); 
});

Route::get('user/logout', function(){ 
	Auth::guard('web')->logout(); 
	return  redirect()->route('login');
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

	Route::group(['prefix' => 'course/category'], function() { 
		Route::get('/', 'CourseController@show')->name('admin_course_category');    
		Route::get('{id}/edit', 'CourseController@showeditForm'); 
		Route::get('add', 'CourseController@showAddForm');
		Route::post('create', 'CourseController@create'); 
		Route::post('{id}/update', 'CourseController@update'); 
	});

	Route::group(['prefix' => 'cities'], function() { 
		Route::get('/', 'CitiesController@show')->name('admin_cities');    
		Route::get('{id}/edit', 'CitiesController@showeditForm'); 
		Route::get('add', 'CitiesController@showAddForm');
		Route::post('create', 'CitiesController@create'); 
		Route::post('{id}/update', 'CitiesController@update'); 
	});  

	Route::group(['prefix' => 'profile'], function() { 
		Route::get('/', 'ProfileController@showForm')->name('profile');
		Route::post('edit', 'ProfileController@edit');
		Route::post('addNewUser', 'ProfileController@addNewUser');
	}); 

	Route::group(['prefix' => 'users/pupil', 'namespace' => 'Users',], function() { 
		Route::get('/', 'PupilUserController@show')->name('admin_user_pupil');    
		Route::get('{id}/edit', 'PupilUserController@showeditForm'); 
		Route::get('add', 'PupilUserController@showAddForm');
		Route::post('{id}/updatePassword', 'PupilUserController@updatePassword'); 
		Route::post('create', 'PupilUserController@createUser'); 
		Route::post('{id}/update', 'PupilUserController@updateUser');
	}); 

	Route::group(['prefix' => 'users/teachers', 'namespace' => 'Users',], function() { 
		Route::get('/', 'TeacherUserController@show')->name('admin_user_teacher');    
		Route::get('{id}/edit', 'TeacherUserController@showeditForm'); 
		Route::get('add', 'TeacherUserController@showAddForm');
		Route::post('{id}/updatePassword', 'TeacherUserController@updatePassword'); 
		Route::post('create', 'TeacherUserController@createUser'); 
		Route::post('{id}/update', 'TeacherUserController@updateUser');
	});	 

	Route::group(['prefix' => 'users/university', 'namespace' => 'Users',], function() { 
		Route::get('/', 'UniversityUserController@show')->name('admin_user_university');    
		Route::get('{id}/edit', 'UniversityUserController@showeditForm'); 
		Route::get('add', 'UniversityUserController@showAddForm');
		Route::post('{id}/updatePassword', 'UniversityUserController@updatePassword'); 
		Route::post('create', 'UniversityUserController@createUser'); 
		Route::post('{id}/update', 'UniversityUserController@updateUser');
	});	 

	Route::group(['prefix' => 'ajax'], function() {  
		Route::post('depth-sort', 'AjaxController@depthSort')->name('depth_sort');
		Route::post('viewElement', 'AjaxController@viewElement')->name('viewElement'); 
		Route::post('deleteElement', 'AjaxController@deleteElement')->name('deleteElement'); 
	}); 

	Route::get('logout', 'LoginController@logout')->name('admin_logout'); 
});
 

 