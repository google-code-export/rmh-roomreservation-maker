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
* Actvity Approval Script for RMH-RoomReservationMaker. 
* 
* This file contains the script to allow/deny different kinds of activities (by an RMH Staff Approver:
* Room reservation request or family profile add/modify activity
*
* @author Prayas Bhattarai
* @version May 1, 2012
*/

//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Activity"; //This should be the title for the page, included in the <title></title>

include('../header.php'); //including this will further include (globalFunctions.php and config.php)
include(ROOT_DIR.'/database/dbReservation.php');
include(ROOT_DIR.'/database/dbProfileActivity.php');

$request = array();
$errors = array();
if(isset($_GET['type']) && !empty($_GET['type']) && isset($_GET['request']) && is_numeric($_GET['request']))
{
    //type of activity and request id is set, do the following
    $requestType = sanitize($_GET['type']);
    $requestId = sanitize($_GET['request']);
    
    switch($requestType)
    {
        //depending on the request type, perform the following actions
        case 'reservation':
            //request about reservation, get the information about the reservation, display the information first
            $reservation = retrieve_RoomReservationActivity_byRequestId($requestId);
            if($reservation)
            {
                $request = array(
                            'Request ID' => $reservation->get_roomReservationRequestID(),
                            'Current Status' => $reservation->get_status(),
                            'Family Profile ID' => $reservation->get_familyProfileId(),
                            'Social Worker' => $reservation->get_swFirstName().' '.$reservation->get_swLastName(),
                            'Date Submitted' => $reservation->get_swDateStatusSubmitted(),
                            'Activity Type'=>$reservation->get_activityType(),
                            'Begin Date' => $reservation->get_beginDate(),
                            'End Date' => $reservation->get_endDate(),
                            'Diagnosis' => $reservation->get_patientDiagnosis(),
                            'Room Notes' => $reservation->get_roomnote()
                            );
            }
            else
            {
                $errors['invalid_reservation'] = "Cannot find the reservation activity";
            }
            break;
        
        case 'profile':
            //request is about profile change/add/cancel, display the information first
            $profileActivity = retrieve_ProfileActivity_byRequestId($requestId);
            if($profileActivity)
            {
                $request = array(
                            'Request ID' => $profileActivity->get_profileActivityRequestId(),
                            'Current Status' => $profileActivity->get_profileActivityStatus(),
                            'Social Worker' => $profileActivity->get_swFirstName().' '.$profileActivity->get_swLastName(),
                            'Date Submitted' => $profileActivity->get_swDateStatusSubm(),
                            'Activity Type'=>$profileActivity->get_activityType(),
                            'Family Profile ID'=> $profileActivity->get_familyProfileId(),
                            'Parent\'s First Name'=> $profileActivity->get_parentFirstName(),
                            'Parent\'s Last Name'=> $profileActivity->get_parentLastName(),
                            'Email'=> $profileActivity->get_parentEmail(),
                            'Phone 1'=> $profileActivity->get_parentPhone1(),
                            'Phone 2'=> $profileActivity->get_parentPhone2(),
                            'Address'=> $profileActivity->get_parentAddress(),
                            'City'=> $profileActivity->get_parentCity(),
                            'State'=> $profileActivity->get_parentState(),
                            'ZIP'=> $profileActivity->get_parentZip(),
                            'Country'=> $profileActivity->get_parentCountry(),
                            'Patient\'s Firt Name'=> $profileActivity->get_patientFirstName(),
                            'Patient\'s Last Name'=> $profileActivity->get_patientLastName(),
                            'Relation to the patient'=> $profileActivity->get_patientRelation(),
                            'Patient Date of Birth'=> $profileActivity->get_patientDOB(),
                            'PDF Form'=> $profileActivity->get_formPdf(),
                            'Notes'=> $profileActivity->get_familyNotes()
                            );
            }
            else
            {
                $errors['invalid_profile_activity'] = "Cannot find the profile activity";
            }
            break;
        default:
            $errors['invalid_parameter'] = "Invalid parameters supplied";
            break;
    }
}
    else
    {
        //there was no POST DATA
        $errors['invalid_request'] = "The request you made is not allowed";
    }
        

?>

<div id="container">
    <div id="content">
        <?php
        if(!empty($errors))
        {
            echo implode('<br/>',$errors);
        }
        else
        {
            
        
        //output the request and submit form
            echo '<table cellpadding="3">';
            foreach($request as $title=>$value)
            {
                echo '<tr>
                        <td style="text-align:right; padding-right: 10px;">
                            <strong>'.$title.'</strong>
                       </td>
                        
                        <td>'
                            .$value.
                       '</td>
                      </tr>';
            }
            echo '</table>';
        ?>
        <form method="post" action="<?php echo BASE_DIR;?>/reservation/activityHandler.php">
            <?php echo generateTokenField(); ?>
            <input type="hidden" name="activityType" value="<?php echo $requestType;?>"/>
            <input type="hidden" name="requestID" value="<?php echo $requestId;?>"/>
            <input type="radio" id="approve" name="status" checked="true" value="approve" />
            <label for="approve">Approve</label>
            <input type="radio" id="deny" name="status" value="deny" />
            <label for="deny">Deny</label>
            <br />
            <input type="submit" name="Submit" value="Submit"/>
       </form>
        <?php
        }
        ?>
        
    </div>
</div>
<?php 
include (ROOT_DIR.'/footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
?>