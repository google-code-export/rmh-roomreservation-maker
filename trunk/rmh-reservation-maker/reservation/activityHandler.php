<?php
//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Welcome"; //This should be the title for the page, included in the <title></title>

include('../header.php'); //including this will further include (globalFunctions.php and config.php)
include_once(ROOT_DIR.'/database/dbProfileActivity.php');
include_once(ROOT_DIR.'/database/dbReservation.php');

$errors = array();

$statuses = array('approve'=>'Confirm', 'deny'=>'Deny'); //Status info that is stored in the database

    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        //the security validation was successful, perform required operation here below.
        $requestId = sanitize($_POST['requestID']); //The request id that was submitted
        $requestType = sanitize($_POST['activityType']); //the activity type, whether it was a profile change, or reservation
        
        $status = sanitize($_POST['status']); //whether the status was approved or denied

        if($requestType == 'profile')
        {
            $profileActivity = retrieve_ProfileActivity_byRequestId($requestId);
            
            $profileActivity->set_rmhStaffProfileId(getUserProfileID());
            $profileActivity->set_rmhDateStatusSubm(date("Y-m-d H:i:s"));
            $profileActivity->set_profileActivityStatus($statuses[$status]);
            
            $updateProfile = update_status_ProfileActivity($profileActivity);
            
            //if it is approved, it needs to be copied over to the family profile table
            
            if($updateProfile)
            {
                //email can be sent here
                echo "Profile activity status successfully changed";
            }
            else
            {
                $errors['update_profile_failed'] = 'Cannot update profile';
            }
        }
        else if($requestType == 'reservation')
        {
            $resActivity = retrieve_RoomReservationActivity_byRequestId($requestId);
            
            $resActivity->set_rmhStaffProfileId(getUserProfileID());
            $resActivity->set_rmhDateStatusSubmitted(date("Y-m-d H:i:s"));
            $resActivity->set_status($statuses[$status]);
            
            $updateReservation = update_status_RoomReservationActivity($resActivity);
            
            if($updateReservation)
            {
                //email can be sent here
                echo "Reservation activity status successfuly changed";
            }
            else
            {
                $errors['update_res_failed'] = 'Cannot update reservation';
            }
            
        }
    }
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        $errors['invalid_token'] = 'Security check failed';

    }
    else
    {
        //there was no POST DATA
        $errors['invalid_request'] = 'Invalid request type';
    }
        

?>

<div id="container">
    <div id="content">
        <?php
            if(!empty($errors))
            {
                echo implode('<br/>', $errors);
            }
        ?>
    </div>
</div>
<?php 
include (ROOT_DIR.'/footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
?>

