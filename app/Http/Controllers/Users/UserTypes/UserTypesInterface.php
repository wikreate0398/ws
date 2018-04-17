<?php

namespace App\Http\Controllers\Users\UserTypes;

interface UserTypesInterface
{
	/**
	* Validation post data
	*
	* @param array $data
	* @return bool or array of errors
	*/
	public function validateRegistration(array $data);

	/**
	* Saving user data
	*
	* @param array $data
	* @return bool
	*/
	public function createUser(array $data);

	/**
	* Show user profile
	*
	* @param array $data
	* @return bool
	*/
	public function showProfile();

	/**
	* Edit user profile
	*
	* @param array $data
	* @return bool
	*/
	public function editProfile(array $data);
}