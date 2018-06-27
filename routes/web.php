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
});

Route::get('about', 'PagesController@about');
Route::get('autocomplete', 'PagesController@autocomplete'); 
 
Route::get('contacts', 'PagesController@contacts'); 
Route::get('under-construction', 'PagesController@underConstruction');
Route::get('terms-of-use', 'PagesController@termsOfUse');
 
Route::get('universities', 'UniversityController@index'); 
Route::get('university/{id}', 'UniversityController@view');
Route::get('universities/autocomplete', 'UniversityController@autocomplete');

Route::get('teachers', 'TeachersController@index');
Route::get('teacher/{id}', 'TeachersController@show');
Route::get('teacher/{id}/makeRequest', 'TeachersController@makeRequest');
Route::get('teachers/autocomplete', 'TeachersController@autocomplete');
Route::post('teachers/setBoockmark', 'TeachersController@setBoockmark');

Route::get('courses', 'CoursesController@index'); 
Route::get('courses/cat/{cat}', 'CoursesController@index');
Route::get('course/{id}', 'CoursesController@show');
Route::get('course/{id}/makeRequest', 'CoursesController@makeRequest');
Route::get('courses/autocomplete', 'CoursesController@autocomplete');
Route::post('course/favorite', 'CoursesController@favorite', ['middleware' => 'web_auth']); 

Route::get('search', 'PagesController@search');  

Route::group(['middleware' => ['web_auth']], function(){  

	Route::group(['prefix' => 'user'], function() { 
		Route::group(['prefix' => 'university-profile', 'namespace' => 'Users\University'], function() { 
			$controller = 'UniversityController';
			$userDefine = 'university'; 
		 	 
		 	Route::get('edit', "$controller@showEditForm")->name("{$userDefine}_user_edit");
		 	Route::post('update-profile', "$controller@editProfile")->name("{$userDefine}_update_profile");
		 	  
		 	Route::group(['prefix' => 'faculties'], function() use($userDefine) {
		 		$controller = 'FacultiesController';
		 		Route::get('/', "$controller@showFaculties")->name("{$userDefine}_user_faculties");
			 	Route::get('add', "$controller@showFacultyForm")->name("{$userDefine}_add_faculty");  
				Route::get('{id}/edit', "$controller@editFacultyForm")->name("{$userDefine}_edit_faculty");
				Route::get('{id}/delete', "$controller@deleteFaculty")->name("{$userDefine}_delete_faculty"); 
				Route::post('save', "$controller@saveFaculty")->name("{$userDefine}_save_faculty"); 
				Route::post('{id}/edit', "$controller@editFaculty")->name("{$userDefine}_update_faculty");  
			}); 

			Route::group(['prefix' => 'news'], function() use($userDefine) {
				$controller = 'NewsController';
		 		Route::get('/', "$controller@showNews")->name("{$userDefine}_user_news");
			 	Route::get('add', "$controller@showNewsForm")->name("{$userDefine}_add_news");  
				Route::get('{id}/edit', "$controller@editNewsForm")->name("{$userDefine}_edit_news");
				Route::get('{id}/delete', "$controller@deleteNews")->name("{$userDefine}_delete_news"); 
				Route::post('save', "$controller@saveNews")->name("{$userDefine}_save_news"); 
				Route::post('{id}/edit', "$controller@editNews")->name("{$userDefine}_update_news");  
			}); 

		 	Route::group(['prefix' => 'course'], function() use($userDefine) {
		 		$controller = 'CourseController'; 
		 		Route::get('/', "$controller@showCourse")->name("{$userDefine}_user_profile");

			 	Route::get('add', "$controller@showCourseForm")->name("{$userDefine}_add_course");   
				Route::get('{id_course}/edit/general', "$controller@editCourseForm")->name("{$userDefine}_edit_course");
				Route::get('{id_course}/edit/settings', "$controller@editCourseForm")->name("{$userDefine}_edit_course_settings");
				Route::get('{id_course}/edit/program', "$controller@editCourseForm")->name("{$userDefine}_edit_course_program");
				Route::get('{id_course}/participants', "$controller@editCourseForm")->name("{$userDefine}_course_participants");
				Route::get('{id_course}/edit/сertificates', "$controller@editCourseForm")->name("{$userDefine}_edit_course_сertificates");

				Route::post('{id}/edit/general', "$controller@editCourseGeneral")->name("{$userDefine}_update_course_general"); 
				Route::post('{id}/edit/settings', "$controller@editCourseSettings")->name("{$userDefine}_update_course_settings");  
				Route::post('{id}/edit/program', "$controller@editCourseProgram")->name("{$userDefine}_update_course_program");  
				Route::post('{id}/edit/certificates', "$controller@saveCertificates")->name("{$userDefine}_update_course_сertificates");  

				Route::get('{id}/delete', "$controller@deleteCourse")->name("{$userDefine}_delete_course"); 
				Route::post('save', "$controller@saveCourse")->name("{$userDefine}_save_course"); 
				Route::post('{id}/edit', "$controller@editCourse")->name("{$userDefine}_update_course");  
			}); 
		}); 

		Route::group(['prefix' => 'teacher-profile', 'namespace' => 'Users\Teacher'], function() { 
			$controller = 'TeacherController';
			$userDefine = 'teacher';
		 	
		 	Route::get('edit/general', "$controller@showGeneralForm")->name("{$userDefine}_user_edit");
		 	Route::get('edit/tutor', "$controller@showTutorDataForm")->name("{$userDefine}_user_edit_tutor");
		 	Route::get('edit/certificates', "$controller@showCertificatesForm")->name("{$userDefine}_user_edit_certificates");

		 	Route::post('edit/general', "$controller@editGeneral")->name("{$userDefine}_user_update_general");
		 	Route::post('edit/tutor', "$controller@editTutor")->name("{$userDefine}_user_update_tutor");
		 	Route::post('edit/certificates', "$controller@editCertifications")->name("{$userDefine}_user_update_certificates");

		 	Route::post('update-profile', "$controller@editProfile")->name("{$userDefine}_update_profile");
	 		Route::get('reviews', "{$controller}@showReviews")->name("{$userDefine}_user_reviews"); 
			Route::get('subscriptions', "{$controller}@showSubscriptions")->name("{$userDefine}_user_subscriptions"); 
			Route::get('bookmarks', "{$controller}@showBookmarks")->name("{$userDefine}_user_bookmarks"); 
			Route::get('diplomas', "{$controller}@showDiploms")->name("{$userDefine}_user_diplomas");
			Route::get('deleteUserEducation/{id}', "{$controller}@deleteUserEducation")->name("{$userDefine}_delete_education");

			Route::get('requests', "TeacherRequestsController@index")->name("{$userDefine}_user_requests");

		 	Route::group(['prefix' => 'course'], function() use($userDefine) {
		 		$controller = 'CourseController'; 
		 		Route::get('/', "$controller@showCourse")->name("{$userDefine}_user_profile"); 

			 	Route::get('add', "$controller@showCourseForm")->name("{$userDefine}_add_course");   
				Route::get('{id_course}/edit/general', "$controller@editCourseForm")->name("{$userDefine}_edit_course");
				Route::get('{id_course}/edit/settings', "$controller@editCourseForm")->name("{$userDefine}_edit_course_settings");
				Route::get('{id_course}/edit/program', "$controller@editCourseForm")->name("{$userDefine}_edit_course_program");
				Route::get('{id_course}/participants', "$controller@editCourseForm")->name("{$userDefine}_course_participants");
				Route::get('{id_course}/edit/сertificates', "$controller@editCourseForm")->name("{$userDefine}_edit_course_сertificates");

				Route::post('{id}/edit/general', "$controller@editCourseGeneral")->name("{$userDefine}_update_course_general"); 
				Route::post('{id}/edit/settings', "$controller@editCourseSettings")->name("{$userDefine}_update_course_settings");  
				Route::post('{id}/edit/program', "$controller@editCourseProgram")->name("{$userDefine}_update_course_program");  
				Route::post('{id}/edit/certificates', "$controller@saveCertificates")->name("{$userDefine}_update_course_сertificates");  

				Route::get('{id}/delete', "$controller@deleteCourse")->name("{$userDefine}_delete_course"); 
				Route::post('save', "$controller@saveCourse")->name("{$userDefine}_save_course");  
			}); 
		});  

		Route::group(['prefix' => 'pupil-profile', 'namespace' => 'Users\Pupil'], function() { 
			$controller = 'PupilController';
			$userDefine = 'pupil'; 
		 	Route::get('edit', "$controller@showEditForm")->name("{$userDefine}_user_edit");
		 	Route::post('update-profile', "$controller@editProfile")->name("{$userDefine}_update_profile");
		 	Route::post('updatePass', "$controller@@updatePassword")->name("{$userDefine}_update_pass"); 

		 	Route::group(['prefix' => 'course'], function() use($controller,$userDefine) {
		 		Route::get('/', "$controller@showCourse")->name("{$userDefine}_user_profile"); 
			}); 
		}); 

		Route::group(['prefix' => 'actions', 'namespace' => 'Users'], function() {
		 	Route::post('update-image', 'ProfileController@updateImage')->name('update_image');
			Route::post('loadRegionCities', 'ProfileController@loadRegionCities');  
			Route::post('deleteCertificate', 'ProfileController@deleteCertificate');
			Route::post('deleteCourseCertificate', 'ProfileController@deleteCourseCertificate');
			Route::post('loadCourseSubcats', 'ProfileController@loadCourseSubcats');
			Route::post('deleteCourseSectionLecture', 'ProfileController@deleteCourseSectionLecture'); 
			Route::post('deleteCourseSection', 'ProfileController@deleteCourseSection');  
			Route::post('changeStatus', 'ProfileController@changeStatus');  
		}); 
	}); 
  
	// Route::post('user/updatePass', 'ProfileController@updatePassword')->name('update_pass'); 
	// Route::post('user/update-profile', 'ProfileController@editProfile')->name('update_profile');  
	  
	Route::get('user/forgot-password', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('forgot_password');
	Route::post('user/forgot-password', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('send_reset_link'); 
});

Route::group(['prefix' => 'cron'], function() { 
	Route::get('checkIfCourseIsActive', 'CronJobController@checkIfCourseIsActive');   
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

	Route::group(['prefix' => 'user-profile'], function() { 
		Route::get('/', 'UserProfileController@show')->name('admin_user_profile');  
		Route::get('{id}/{table}/edit', 'UserProfileController@showeditForm'); 
	    Route::post('create', 'UserProfileController@create'); 
		Route::post('{id}/{table}/update', 'UserProfileController@update'); 
	});  

	Route::group(['prefix' => 'course/category', 'namespace' => 'Courses'], function() { 
		Route::get('/', 'CourseCategoryController@show')->name('admin_course_category');    
		Route::get('{id}/edit', 'CourseCategoryController@showeditForm'); 
		Route::get('add', 'CourseCategoryController@showAddForm');
		Route::post('create', 'CourseCategoryController@create'); 
		Route::post('{id}/update', 'CourseCategoryController@update'); 
	});

	Route::group(['prefix' => 'course/teacher-course', 'namespace' => 'Courses'], function() { 
		Route::get('/', 'TeacherCourseController@show')->name('admin_teacher_course');    
		Route::get('{id}/edit', 'TeacherCourseController@showeditForm'); 
		Route::get('add', 'TeacherCourseController@showAddForm');
		Route::post('create', 'TeacherCourseController@create'); 
		Route::post('{id}/update', 'TeacherCourseController@update'); 
	});

	Route::group(['prefix' => 'location'], function() { 
		Route::get('/', 'LocationController@show')->name('admin_location');    
		Route::get('{id}/edit', 'LocationController@showeditForm'); 
		Route::get('{id}/cities', 'LocationController@showCities'); 
		Route::get('add', 'LocationController@showAddForm');
		Route::post('create', 'LocationController@create'); 
		Route::post('{id}/update', 'LocationController@update'); 
		Route::post('loadRegionCities', 'LocationController@loadRegionCities'); 
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
		Route::post('deleteCertificate', 'TeacherUserController@deleteCertificate'); 
	});	 

	Route::group(['prefix' => 'users/university', 'namespace' => 'Users',], function() { 
		Route::get('/', 'UniversityUserController@show')->name('admin_user_university');    
		Route::get('{id}/edit', 'UniversityUserController@showeditForm'); 
		Route::get('add', 'UniversityUserController@showAddForm');
		Route::post('{id}/updatePassword', 'UniversityUserController@updatePassword'); 
		Route::post('create', 'UniversityUserController@createUser'); 
		Route::post('{id}/update', 'UniversityUserController@updateUser');
	});	 

	Route::group(['prefix' => 'user', 'namespace' => 'Users',], function() { 
		Route::post('fastRegister', 'SiteUser@fastRegister');  
	});

	Route::group(['prefix' => 'ajax'], function() {  
		Route::post('depth-sort', 'AjaxController@depthSort')->name('depth_sort');
		Route::post('viewElement', 'AjaxController@viewElement')->name('viewElement'); 
		Route::post('deleteElement', 'AjaxController@deleteElement')->name('deleteElement');   
	}); 

	Route::get('logout', 'LoginController@logout')->name('admin_logout'); 
});
 

 