<?php
/*
 * Copyright 2012 by Prayas Bhattarai and Bonnie MacKellar.
* This program is part of RMH-RoomReservationMaker, which is free software,
* inspired by the RMH Homeroom Project.
* It comes with absolutely no warranty.  You can redistribute and/or
* modify it under the terms of the GNU Public License as published
* by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

/**
 * Add new user script for RMH-RoomReservationMaker.
 * This page includes code that is used for adding a new user.
 * The input fields are updated based on the user group that is selected by the user. This is done using javascript.
 * @author Prayas Bhattarai
 * @version Jan 13, 2013
 */

//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Add New User"; //This should be the title for the page, included in the <title></title>
$helpPage = "AddaUser.php"; //help page for this view; should go before header

include('../header.php'); //including this will further include (globalFunctions.php and config.php)
include_once(ROOT_DIR.'/domain/UserProfile.php');
include_once(ROOT_DIR.'/database/dbUserProfile.php');
include_once(ROOT_DIR.'/core/class/FormHelper.php');
include_once(ROOT_DIR.'/core/class/DataValidator.php');
$errors = array();
$messages = array();
$data = array();
$userCategories = array('admin' => 'RMH Administrator',
		'rmhstaff' => 'RMH Staff Approver',
		'socialworker' => 'Social Worker');
$userType = 'socialworker'; //default user type

if(isset($_POST['form_token']))
{
	$userType = sanitize($_POST['userGroup']);
	try{
		
		//form validation rules. should have all the fields included
		$addUserValidationRules = array(
				'userGroup'=>array('notempty'),
				'title'=>array('alpha','allow'=>array('.')),
				'fname'=>array('alpha'),
				'lname'=>array('alpha'),
				'phone'=>array('number','allow'=>array('-','(',')','.')),
				'username'=>array('alphanumeric'),
				'email'=>array('email'),
				'hospital'=>array('notempty'),//this might not be available for admin, how to check that?
				'notify'=>array('notempty'),
				'submit'=>array('ignore')
		);
		
		$validator = new DataValidator($_POST,$addUserValidationRules);
		$data = $validator->getData();
		if($validator->isValid()){
			//the validation was successful, perform required operation here below.
			$userType = $data['userGroup'];
			$title = $data['title'];
			
			$username = $data['username'];
			if(retrieve_UserByAuth($username)){
				//if user already exists, add error message to validation field
				$validator->setError('username', 'Username already exists');
				throw new DuplicateUserException('Username already exists');
			}
			
			$fname = $data['fname'];
			$lname = $data['lname'];
			$phone = $data['phone'];
			$email = $data['email'];
			
			//data for social worker, extra info that rmh staff don't have
			if(isset($userType) && $userType == 'socialworker'){
				$hospital = $data['hospital'];
				$notify = $data['notify'];
			}else{
				$hospital = '';
				$notify = '';
			}
			
			//proceed with creating and storing the new user
			
			//create a default password based on: User's firstname and last 4 digits of their phone number
			$password = trim(strtolower($fname)).trim(substr($phone, -4));
			$password = getHashValue($password);
			
			$newUserProfile = new UserProfile($userCategories[$userType], 0, $username, $email, $password, 0, $title, $fname, $lname, $phone, 0, $title, $fname, $lname, $hospital, $phone, $notify);
			
			//insert user profile
			$insertProfile = insert_UserProfile($newUserProfile);
				
			//if user profile insertion is successful, then the corresponding user profile tables need to be updated as well
			if($insertProfile)
			{
				//get the userprofile id for the newly inserted user
				//can this be done more efficiently, instead of retrieving all the info? using last_insert_id maybe?
				$retrievedUser = retrieve_UserByAuth($username);
				if($retrievedUser)
				{
					//if a user is retrieved, store the detailed information in the corresponding profile table
					$newUserProfile->set_userProfileId($retrievedUser['UserProfileID']);
			
					if($retrievedUser['UserCategory'] == $userCategories['socialworker'])
					{
						//if the user is a social worker, insert the detail info in the social worker table
						$insertDetailProfile = insert_SocialWorkerProfile($newUserProfile);
					}
					else
					{
						//else the user is an rmh staff, so insert detailed profile in the rmhstaff table
						$insertDetailProfile = insert_RmhStaffProfile($newUserProfile);
					}
			
					//check for errors
					if($insertDetailProfile)
					{
						//$messages['user_creation_successful'] = "The user ".$username. " was successfully created.";
						setSessionMessage("The user $username was created successfully");
						$data = array();
						$dataErrors = array();
					}
					else
					{
						//$errors['insert_profile_detail_failure'] = "Profile detail could not be added";
						ErrorHandler::error("Profile detail could not be added");
					}
			
				}
				else
				{
					//$errors['invalid_username'] = "Could not retrieve the new user";
					ErrorHandler::error("Could not retrieve the new user");
				}
			}
			else
			{
				//$errors['insert_failed'] = "Could not add the new user";
				ErrorHandler::error("Could not add the new user");
			}
		
		}
	}catch(SecurityException $e){
		//this is probably fatal?
		ErrorHandler::error($e->getMessage());
	}catch(DuplicateUserException $e){
		ErrorHandler::error($e->getMessage());
	}
}
/* NEVER OCCURS
 else if(isset($_POST['form_token']) && !validateTokenField($_POST))
 {
//if the security validation failed. display/store the error:
//'The request could not be completed: security check failed!'
$errors['security_check_failed'] = 'Security check failed';
$userType = 'socialworker';
}*/
else if(isset($_GET['type']))
{
	//get requests need to be validated too. Work on validating these kinds of requests.
	$userType = sanitize($_GET['type']);
	if(!in_array($userType, array_keys($userCategories)))
	{
		ErrorHandler::error('Invalid User Category');
	}
}
?>
<section class="content">
	<?php ErrorHandler::displayErrors();?>
	<div>
		<?php
		if(!empty($errors))
		{
			echo '<div style="color:#FF3300;">';
			echo implode('<br />', $errors);
			echo '</div>';
		}
		if(!empty($messages))
		{
			echo '<div style="color:#00BB00;">';
			echo implode('<br />', $messages);
			echo '</div>';
		}
		else
		{

			?>
		<div class="notice">Note: Password is automatically set as the
			combination of user's first name and last four digits of their phone
			number, all lowercase.</div>
		<?php
		//error could be set elsewhere in the code, so we need retrieve it after the checks, if any
		//in this case, we are checking for the usernam, if it is already in the database
		$dataErrors = isset($validator) ? $validator->getErrors() : array();
		
		$form = new FormHelper($data, $dataErrors); //id is important, they should be unique
		$form->create(array('class'=>array('generic','addForm'),
				'name'=>'addNewUserForm',
				'method'=>'post',
				'action'=>BASE_DIR.'/admin/addUser.php'
		));

		$form->input(array(
			'class'=>'formRow',
			'input'=>array(
					'type'=>'select',
					'selected'=>$userType,
					'id'=>'userGroup',
					'options'=>array('admin'=>'Administrator',
									'rmhstaff'=>'RMH Staff Approver',
									'socialworker'=>'Social Worker'
									)
			),
			'label'=>array(
					'value'=>'User Category'
			)
		)
		);
		$form->input(array(
				'class'=>'formRow',
				'input'=>array(
						'id'=>'title'
				),
				'label'=>array(
						'value'=>'Title'
				)
		)
		);

		$form->input(array(
					'input'=>array(
							'id'=>'fname'
					),
					'label'=>array(
							'value'=>'First Name'
					)
				)
				);
		$form->input(array(
					'input'=>array(
							'id'=>'lname'
					),
					'label'=>array(
							'value'=>'Last Name'
					)
				)
				);
		
		$form->input(array(
					'input'=>array(
							'id'=>'phone',
							'type'=>'tel'
					),
					'label'=>array(
							'value'=>'Phone'
					)
				)
				);

		$form->input(array(
					'input'=>array(
							'id'=>'username'
					),
					'label'=>array(
							'value'=>'Username'
					)
				)
				);

		$form->input(array(
					'class'=>'formRow',
					'input'=>array(
							'id'=>'email',
							'type'=>'email'
					),
					'label'=>array(
							'value'=>'Email'
					)
				)
				);
		if(isset($userType) && $userType == 'socialworker'){
			$form->input(array(
						'input'=>array(
								'id'=>'hospital'
						),
						'label'=>array(
								'value'=>'Hospital Affiliation'
						)
					)
					);
			
			$form->input(array(
						'input'=>array(
								'id'=>'notify',
								'selected'=>'yes',
								'type'=>'radio',
								'options'=>array('yes'=>'Yes',
												'no'=>'No'
												)
						),
						'label'=>array(
								'value'=>'Email Notification'
						)
					)
					);
		}
		$form->button();
		$form->generate();
	 } //end else if for messages
?>
	</div>
</section>
<script>
<?php 
$pageJavaScript = <<<EOF
$(function(){
    $('#userGroup').change(function(){
            var userType = $(this).children('option:selected').val();
            window.location = '{$cst(BASE_DIR)}/admin/addUser.php?type='+userType;
              });
});
EOF;
 include (ROOT_DIR . '/footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
 ?>

