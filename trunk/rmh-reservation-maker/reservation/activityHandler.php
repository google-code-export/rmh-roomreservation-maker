<?php
//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Welcome"; //This should be the title for the page, included in the <title></title>

include('../header.php'); //including this will further include (globalFunctions.php and config.php)
include_once(ROOT_DIR.'/database/dbProfileActivity.php');
include_once(ROOT_DIR.'/database/dbReservation.php');
include_once(ROOT_DIR.'/database/dbFamilyProfile.php');

$errors = array();
$messages = array();

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
            
            $updateProfileActivity = update_status_ProfileActivity($profileActivity);
            
            
            if($updateProfileActivity)
            {
                $messages['profile_activity_updated'] = 'Profile activity status set to '.$profileActivity->get_profileActivityStatus();
                
                //if it is approved, it needs to be copied over to the family profile table
                if(array_search($profileActivity->get_profileActivityStatus(), $statuses) == 'approve')
                {
                    /*Prepare data for updating the Family Profile table*/
                    $fam_profID = $profileActivity->get_familyProfileId();
                    $fam_parent_fname = $profileActivity->get_parentFirstName();
                    $fam_parent_lname = $profileActivity->get_parentLastName();
                    $fam_parent_email = $profileActivity->get_parentEmail();
                    $fam_parent_phone_1 = $profileActivity->get_parentPhone1();
                    $fam_parent_phone_2 = $profileActivity->get_parentPhone2();
                    $fam_parent_addr = $profileActivity->get_parentAddress();
                    $fam_parent_city = $profileActivity->get_parentCity();
                    $fam_parent_state = $profileActivity->get_parentState();
                    $fam_parent_zip = $profileActivity->get_parentZip();
                    $fam_parent_country = $profileActivity->get_parentCountry();
                    $fam_patient_fname = $profileActivity->get_patientFirstName();
                    $fam_patient_lname = $profileActivity->get_patientLastName();
                    $fam_patient_relation = $profileActivity->get_patientRelation();
                    $fam_patient_dob = $profileActivity->get_patientDOB();
                    $fam_form_pdf = $profileActivity->get_formPdf();
                    $fam_notes = $profileActivity->get_familyNotes();

                    if($profileActivity->get_activityType() == 'Edit')
                    {
                        //if the activity type is edit then update the profile
                       $alterFamilyProfile = update_FamilyProfileDetail($fam_profID, $fam_parent_fname, $fam_parent_lname, $fam_parent_email, $fam_parent_phone_1, $fam_parent_phone_2, $fam_parent_addr, $fam_parent_city, $fam_parent_state, $fam_parent_zip, $fam_parent_country, $fam_patient_fname, $fam_patient_lname, $fam_patient_relation, $fam_patient_dob, $fam_form_pdf, $fam_notes); 
                    }
                    else
                    {
                        //if it is not edit, then it is create, so call the create function
                    }
                    
                    if($alterFamilyProfile)
                    {
                        $messages['profile_updated'] = "Family Profile has been updated with the approved changes";
                    }
                    else
                    {
                        $errors['failed_update'] = "Cannot update family profile";
                    }
                       
                }
                
                //if no errors were present, send the email:
                if(empty($errors))
                {
                    /*=============== email the users ===========*/
                }
                
            }
            else
            {
                $errors['update_profile_failed'] = 'Cannot update activity status';
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
                $messages['status_changed'] = "Reservation activity status successfuly changed";
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
                echo '<div style="color: #F33">';
                echo implode('<br/>', $errors);
                echo '</div>';
            }
            if(!empty($messages))
            {
                echo '<div style="color: #0B0">';
                echo implode('<br/>', $messages);
                echo '</div>';
            }
        ?>
        <a href="<?php echo BASE_DIR.'/index.php';?>">Return to home</a>
    </div>
</div>
<?php 
include (ROOT_DIR.'/footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
?>

