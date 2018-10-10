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
Route::post('contacts', 'PagesController@sendContacts');
Route::get('under-construction', 'PagesController@underConstruction');
Route::get('terms-of-use', 'PagesController@termsOfUse');
 
Route::get('universities', 'UniversityController@index'); 
Route::get('university/{id}', 'UniversityController@view');
Route::get('universities/autocomplete', 'UniversityController@autocomplete');
Route::post('university/setBoockmark', 'UniversityController@setBoockmark'); 
Route::post('university/review/{id}', 'UniversityController@review', ['middleware' => 'web_auth'])->name('university_review');

Route::get('teachers', 'TeachersController@index');
Route::get('teacher/{id}', 'TeachersController@show');
Route::get('teacher/{id}/makeRequest', 'TeachersController@makeRequest');
Route::get('teachers/autocomplete', 'TeachersController@autocomplete');
Route::post('teachers/setBoockmark', 'TeachersController@setBoockmark');
Route::post('teachers/review/{id}', 'TeachersController@review', ['middleware' => 'web_auth'])->name('teacher_review'); 

Route::get('courses', 'CoursesController@index'); 
Route::get('courses/cat/{cat}', 'CoursesController@index');

Route::get('course/{id}', 'CoursesController@show');
Route::get('course/{id}/userRequest/{id_user}', 'CoursesController@show');

Route::get('course/{id}/makeRequest', 'CoursesController@makeRequest');
Route::get('courses/autocomplete', 'CoursesController@autocomplete');
Route::post('course/favorite', 'CoursesController@favorite', ['middleware' => 'web_auth']); 
Route::post('course/review/{id}', 'CoursesController@review', ['middleware' => 'web_auth'])->name('course_review'); 

Route::get('news', 'NewsController@index');
Route::get('news/cat/{id}', 'NewsController@index'); 
Route::get('news/view/{url}', 'NewsController@view');  

Route::get('search', 'PagesController@search');  

Route::group(['prefix' => 'user/actions'], function() {
 	Route::post('update-image', 'Users\ProfileController@updateImage')->name('update_image')->middleware('web_auth');
	Route::post('loadRegionCities', 'AjaxController@loadRegionCities');  
	Route::post('deleteCertificate', 'Users\ProfileController@deleteCertificate')->middleware('web_auth');
	Route::post('deleteCourseCertificate', 'Users\ProfileController@deleteCourseCertificate')->middleware('web_auth');
	Route::post('loadCourseSubcats', 'Users\ProfileController@loadCourseSubcats')->middleware('web_auth'); 
	Route::post('changeStatus', 'Users\ProfileController@changeStatus')->middleware('web_auth'); 
	Route::post('deleteUploadMaterial', 'Users\ProfileController@deleteUploadMaterial')->middleware('web_auth');  
}); 

Route::group(['middleware' => ['web_auth']], function(){  

	Route::group(['prefix' => 'user'], function() { 
		Route::group(['prefix' => 'university-profile', 'namespace' => 'Users\University'], function() { 
			$controller = 'UniversityController';
			$userDefine = 'university'; 

		 	Route::get('edit/profile', "$controller@showEditForm")->name("{$userDefine}_user_edit");
		 	Route::get('edit/general', "$controller@showEditForm")->name("{$userDefine}_user_general_edit");
		 	Route::get('edit/certificates', "$controller@showEditForm")->name("{$userDefine}_user_certificates_edit");

		 	Route::post('update-profile', "$controller@editProfile")->name("{$userDefine}_update_profile");

		 	Route::post('update-profile', "$controller@editProfile")->name("{$userDefine}_update_profile");
		 	Route::post('update-general', "$controller@editGeneral")->name("{$userDefine}_update_general");
		 	Route::post('update-certificates', "$controller@editCertifications")->name("{$userDefine}_update_certificates");

            Route::get('delete-department/{id}', "$controller@deleteDepartment")->name("{$userDefine}_delete_department");

		 	Route::get('favorites', "\App\Http\Controllers\\Users\FavoritesController@index")->name("{$userDefine}_user_favorites");
		 	Route::get('favorites/delete/{id}', "\App\Http\Controllers\\Users\FavoritesController@destroy")->name("{$userDefine}_user_favorites_delete");

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

			Route::group(['prefix' => 'teachers'], function() use($userDefine) {
				$controller = 'TeachersConnectionController';
		 		Route::get('/', "$controller@index")->name("{$userDefine}_user_teachers");
		 		Route::get('confirm/{id}', "$controller@confirm")->name("{$userDefine}_user_teachers_confirm"); 
		 		Route::get('decline/{id}', "$controller@decline")->name("{$userDefine}_user_teachers_decline");  
		 		Route::get('destroy/{id}', "$controller@destroy")->name("{$userDefine}_user_teachers_delete");  
		 		Route::get('autocomplete', "$controller@autocomplete")->name("{$userDefine}_user_teachers_autocomplete");   
		 		Route::get('request/{id}', "$controller@request")->name("{$userDefine}_user_teachers_request");  
		 		Route::get('destroyRequest/{id}', "$controller@destroyRequest")->name("{$userDefine}_user_teachers_delete_request");
		 		Route::post('inviteTeacher', "$controller@inviteTeacher")->name("{$userDefine}_user_teacher_invite"); 
			});  

		 	Route::group(['prefix' => 'course'], function() use($userDefine) {
		 		$controller = '\App\Http\Controllers\\Users\CourseController';
		 		Route::get('/', "$controller@showCourse")->name("{$userDefine}_user_profile");

			 	Route::get('add', "$controller@showCourseForm")->name("{$userDefine}_add_course");   
				Route::get('{id_course}/edit/general', "$controller@editCourseForm")->name("{$userDefine}_edit_course");
				Route::get('{id_course}/edit/settings', "$controller@editCourseForm")->name("{$userDefine}_edit_course_settings");
				Route::get('{id_course}/edit/program', "$controller@editCourseForm")->name("{$userDefine}_edit_course_program");
				Route::get('{id_course}/participants', "$controller@editCourseForm")->name("{$userDefine}_course_participants");

                Route::get('participants/confirm/{course}/{user}', "$controller@confirmParticipant")->name("{$userDefine}_confirm_participant");
                Route::get('participants/decline/{course}/{user}', "$controller@declineParticipant")->name("{$userDefine}_decline_participants");

				Route::get('{id_course}/edit/certificates', "$controller@editCourseForm")->name("{$userDefine}_edit_course_сertificates");

				Route::post('{id}/edit/general', "$controller@editCourseGeneral")->name("{$userDefine}_update_course_general"); 
				Route::post('{id}/edit/settings', "$controller@editCourseSettings")->name("{$userDefine}_update_course_settings");  
				Route::post('{id}/edit/program', "$controller@editCourseProgram")->name("{$userDefine}_update_course_program");  
				Route::post('{id}/edit/certificates', "$controller@saveCertificates")->name("{$userDefine}_update_course_сertificates");  

				Route::get('{id}/delete', "$controller@deleteCourse")->name("{$userDefine}_delete_course"); 
				Route::post('save', "$controller@saveCourse")->name("{$userDefine}_save_course"); 
				Route::post('{id}/edit', "$controller@editCourse")->name("{$userDefine}_update_course");  

				Route::post('filter/load-categories', "$controller@loadFilterCategories")->name("{$userDefine}_filter_categories");  
				Route::get('filter/course-autocomplete', "$controller@filterAutocomplete")->name("{$userDefine}_filter_autocomplete");  
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
			
			Route::get('favorites', "\App\Http\Controllers\\Users\FavoritesController@index")->name("{$userDefine}_user_favorites");
		 	Route::get('favorites/delete/{id}', "\App\Http\Controllers\\Users\FavoritesController@destroy")->name("{$userDefine}_user_favorites_delete"); 

			Route::group(['prefix' => 'universities'], function() {  
				$userDefine = 'teacher'; 
			 	Route::get('/', "UniversitiesConnectionController@index")->name("{$userDefine}_user_universities");
				Route::get('connect', "UniversitiesConnectionController@connect")->name("{$userDefine}_user_universities_connect");
				Route::get('autocomplete', "UniversitiesConnectionController@autocomplete")->name("{$userDefine}_user_universities_autocomplete"); 
				Route::post('request/{id}', "UniversitiesConnectionController@request")->name("{$userDefine}_user_universities_request"); 
				Route::get('destroy/{id}', "UniversitiesConnectionController@destroy")->name("{$userDefine}_user_universities_delete_connect");
				Route::get('destroyRequest/{id}', "UniversitiesConnectionController@destroyRequest")->name("{$userDefine}_user_universities_delete_request"); 
				Route::get('decline/{id}', "UniversitiesConnectionController@decline")->name("{$userDefine}_user_universities_decline"); 
				Route::get('confirm/{id}', "UniversitiesConnectionController@confirm")->name("{$userDefine}_user_universities_confirm");  
			});			 

			Route::get('diplomas', "{$controller}@showDiploms")->name("{$userDefine}_user_diplomas");
			Route::get('deleteUserEducation/{id}', "{$controller}@deleteUserEducation")->name("{$userDefine}_delete_education");

			Route::get('requests', "TeacherRequestsController@index")->name("{$userDefine}_user_requests");

		 	Route::group(['prefix' => 'course'], function() use($userDefine) {
		 		$controller = '\App\Http\Controllers\\Users\CourseController';
		 		Route::get('/', "$controller@showCourse")->name("{$userDefine}_user_profile"); 

			 	Route::get('add', "$controller@showCourseForm")->name("{$userDefine}_add_course");   
				Route::get('{id_course}/edit/general', "$controller@editCourseForm")->name("{$userDefine}_edit_course");
				Route::get('{id_course}/edit/settings', "$controller@editCourseForm")->name("{$userDefine}_edit_course_settings");
				Route::get('{id_course}/edit/program', "$controller@editCourseForm")->name("{$userDefine}_edit_course_program");
				Route::get('{id_course}/participants', "$controller@editCourseForm")->name("{$userDefine}_course_participants");

				
				Route::get('participants/confirm/{course}/{user}', "$controller@confirmParticipant")->name("{$userDefine}_confirm_participant");
                Route::get('participants/decline/{course}/{user}', "$controller@declineParticipant")->name("{$userDefine}_decline_participants");

				Route::get('{id_course}/edit/certificates', "$controller@editCourseForm")->name("{$userDefine}_edit_course_сertificates");

				Route::post('{id}/edit/general', "$controller@editCourseGeneral")->name("{$userDefine}_update_course_general"); 
				Route::post('{id}/edit/settings', "$controller@editCourseSettings")->name("{$userDefine}_update_course_settings");  
				Route::post('{id}/edit/program', "$controller@editCourseProgram")->name("{$userDefine}_update_course_program");  
				Route::post('{id}/edit/certificates', "$controller@saveCertificates")->name("{$userDefine}_update_course_сertificates");  

				Route::get('{id}/delete', "$controller@deleteCourse")->name("{$userDefine}_delete_course"); 
				Route::post('save', "$controller@saveCourse")->name("{$userDefine}_save_course");  

				Route::get('filter/course-autocomplete', "$controller@filterAutocomplete")->name("{$userDefine}_filter_autocomplete"); 
			}); 
		});  

		Route::group(['prefix' => 'pupil-profile', 'namespace' => 'Users\Pupil'], function() { 
			$controller = 'PupilController';
			$userDefine = 'pupil'; 
		 	Route::get('edit', "$controller@showEditForm")->name("{$userDefine}_user_edit");
		 	Route::post('update-profile', "$controller@editProfile")->name("{$userDefine}_update_profile");
		 	Route::post('updatePass', "$controller@updatePassword")->name("{$userDefine}_update_pass"); 

		 	Route::group(['prefix' => 'course'], function() use($controller,$userDefine) {
		 		Route::get('/', "$controller@showCourse")->name("{$userDefine}_user_profile");

		 		Route::group(['prefix' => 'training'], function() use($controller,$userDefine) {
		 			$controller = 'TrainingCourseController';
		 			Route::get('{id}', "$controller@training")->name("{$userDefine}_course_training");  
		 			Route::get('download/{file}', "$controller@download")->name("{$userDefine}_course_file_download");   
		 		}); 
			}); 

		 	Route::get('favorites', "\App\Http\Controllers\Users\FavoritesController@index")->name("{$userDefine}_user_favorites");
		 	Route::get('favorites/delete/{id}', "\App\Http\Controllers\Users\FavoritesController@destroy")->name("{$userDefine}_user_favorites_delete");

            Route::get('reviews', "$controller@showReviews")->name("{$userDefine}_user_reviews");
            Route::get('reviews/delete/{id}', "$controller@reviewDelete")->name("{$userDefine}_review_delete");

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

	Route::group(['prefix' => 'news/category'], function() { 
		Route::get('/', 'NewsCategoriesController@show')->name('admin_nw_cat');    
		Route::get('{id}/edit', 'NewsCategoriesController@showeditForm');   
		Route::get('add', 'NewsCategoriesController@showAddForm');
		Route::post('create', 'NewsCategoriesController@create'); 
		Route::post('{id}/update', 'NewsCategoriesController@update');  
	}); 

	Route::group(['prefix' => 'news/articles'], function() { 
		Route::get('/', 'NewsController@show')->name('admin_news');    
		Route::get('{id}/edit', 'NewsController@showeditForm');   
		Route::get('add', 'NewsController@showAddForm');
		Route::post('create', 'NewsController@create'); 
		Route::post('{id}/update', 'NewsController@update');  
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
		Route::post('deleteImg', 'AjaxController@deleteImg')->name('deleteImg');   
	}); 

	Route::get('logout', 'LoginController@logout')->name('admin_logout'); 
});
 

 Route::any('{all}', 'PagesController@page')->where('all', '.*');

 