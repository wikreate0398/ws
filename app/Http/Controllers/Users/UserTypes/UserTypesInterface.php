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
	public function validation(array $data, $rules);

	/**
	* Saving user data
	*
	* @param array $data
	* @return bool
	*/
	public function create(array $data);

	/**
	* Edit user profile
	*
	* @param array $data
	* @return bool
	*/
	public function edit(array $data, $id_user);

	/**
	* Show user profile
	*
	* @param array $data
	* @return bool
	*/
	public function showEditForm();
}