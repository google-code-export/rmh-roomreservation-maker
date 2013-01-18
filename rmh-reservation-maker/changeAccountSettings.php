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
 * Account Management script for RMH-RoomReservationMaker.
 * This page includes account settings. For now it is limited to password change, as the default password should be changed for all the users.
 * @author Prayas Bhattarai
 * @version May 1, 2012
 */

//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Account Management"; //This should be the title for the page, included in the <title></title>
$helpPage = "accountmanage.php"; //help page for this view

include('header.php'); //including this will further include (globalFunctions.php and config.php)
include(ROOT_DIR.'/database/dbUserProfile.php');
include_once(ROOT_DIR.'/core/class/FormHelper.php');
include_once(ROOT_DIR.'/core/class/DataValidator.php');

$errors = array();
$messages = array();
$data = array(); 

if(isset($_POST['form_token']))
{
	try{
		//form validation rules
		$accountSettingsRules = array(
				'title'=>array('alpha','allow'=>array('.')),
				'old_pass'=>array('password'),
				'new_pass'=>array('password'), //we should add validation for minimum length too
				'verify_pass'=>array('password','notempty'), //password should not be sanitized!
				'submit'=>array('ignore')
		);

		$validator = new DataValidator($_POST, $accountSettingsRules);
		$data = $validator->getData();

		if($validator->isValid()){
			//validation successful
			$newPass = getHashValue($data['new_pass']);
			$verifyPass = getHashValue($data['verify_pass']);
			$oldPass = getHashValue($data['old_pass']);
			$title = $data['title'];
				
			$username = getCurrentUser();
				
			//TODO we could add this check in the validator?
			if($newPass === $verifyPass){
				if(retrieve_UserByAuth($username, $oldPass)){
					//verify password and new password match AND the user with the old password exists

					//retrieve user profile:
					$userProfile = retrieveCurrentUserProfile();

					if($userProfile){
						//change the password
						$userProfile->set_password($newPass);
						//TODO set the user title too. But isn't that included in profile change?
							
						//update the user profile table
						if(update_UserProfile($userProfile)){
							//set session message
							setSessionMessage("Your password has been successfully changed. You should log out and log in again for security reasons.");
							$data = array();
							$dataErrors = array();
						
							//TODO Logout the user here
						}else{
							ErrorHandler::error('Could not update user profile');
						}
					}else{
						ErrorHandler::error("Cannot retrieve current user information");
					}
				}
				else{
					//report as validation error that old password is incorrect
					$validator->setError('old_pass','Invalid old password');
				}
			}else{
				//report as validation error that verify pass doesn't match
				$validator->setError('verify_pass','New password and verify password do not match');
			}
		}

	}catch(SecurityException $e){
		ErrorHandler::error($e->getMessage());
	}
}
?>
<section class="content">
<?php ErrorHandler::displayErrors();?>
	<div>
		<h2>
			<?php echo getCurrentUser();?>
		</h2>
		<p>Please use this page to change your default password, if you
			haven't already done so.</p>
			
		<?php 
			$dataErrors = isset($validator) ? $validator->getErrors() : array();
			
			$form = new FormHelper($data, $dataErrors);
			$form->create(array('class'=>array('generic', 'editform'),
								'name'=>'changeAccountSettingsForm',
								'method'=>'post',
								'action'=>BASE_DIR.'/changeAccountSettings.php'				
								));
			
			$form->input(array(
								'input'=>array('id'=>'title'),
								'label'=>array('value'=>'Title')					
							));
			$form->input(array(
					'input'=>array('id'=>'old_pass',
									'type'=>'password'),
					'label'=>array('value'=>'Old Password')
			));
			
			$form->input(array(
					'input'=>array('id'=>'new_pass',
									'type'=>'password'),
					'label'=>array('value'=>'New Password')
			));

			$form->input(array(
					'input'=>array('id'=>'verify_pass',
									'type'=>'password'
									),
					'label'=>array('value'=>'Verify Password')
			));

			$form->button();
			
			$form->generate();
		?>
	</div>
</section>
<?php 
include (ROOT_DIR.'/footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.

function retrieveCurrentUserProfile()
{
	//since access level is stored in the session, use that to find the user category
	//1 is for social worker
	//2 is for staff approver
	//3 is for admin
	//if there is a db function available for this, this function is not needed
	$accessLevel = getUserAccessLevel();
	$userProfileId = getUserProfileID();

	switch($accessLevel)
	{
		case 1:
			return retrieve_UserProfile_SW_OBJ($userProfileId);
			break;
		case 2:
			return retrieve_UserProfile_RMHApprover_OBJ($userProfileId);
			break;
		case 3:
			$userProfile = retrieve_UserProfile_RMHAdmin($userProfileId);
			return is_array($userProfile) ? current($userProfile) : false;
			break;
		default:
			return false;
			break;
	}
}
?>
