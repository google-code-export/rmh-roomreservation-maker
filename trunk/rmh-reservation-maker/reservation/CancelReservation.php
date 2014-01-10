
<?php


session_start();
session_cache_expire(30);

$title = "Cancel Reservation";

include ('../header.php');
include_once (ROOT_DIR . '/domain/Reservation.php');
include_once (ROOT_DIR . '/domain/UserProfile.php');
include_once (ROOT_DIR . '/domain/Family.php');
include_once (ROOT_DIR . '/database/dbReservation.php');
include_once (ROOT_DIR . '/database/dbUserProfile.php');
include_once (ROOT_DIR . '/database/dbFamilyProfile.php');

// the first time the site is visited
if (isset($_SESSION['RequestID'])) {
    $idChosen = $_SESSION['RequestID'];

    error_log("in cancelReservation, request id is $idChosen");

    $informationroom = retrieve_RoomReservationActivity_byRequestId($idChosen);
    
  
       //retrieves the sw, and gets id, firstname and lastname      
        $currentUser = getUserProfileID();
        $sw = retrieve_UserProfile_SW($currentUser);
        $swObject = current($sw);
       
    $informationroom->set_socialWorkerProfileId($swObject->get_swProfileId());
    $informationroom->set_swFirstName($swObject->get_swFirstName());
    $informationroom->set_swLastName($swObject->get_swLastName());
    $informationroom->set_activityType("Cancel");
    $informationroom->set_status("Unconfirmed");
    $informationroom->set_swDateStatusSubmitted(date("Y-m-d H:i:s"));
    $rmhStaffProfileId = $informationroom->get_rmhStaffProfileId();
    
    // if the request has never been approved, the rmh staff id will
    // still be null
    // need to make sure it goes back into the DB as a database null
    if (is_null($rmhStaffProfileId))
    {
        error_log("rmhStaffProfileId is null");
        $informationroom->set_rmhStaffProfileId('NULL');
    }
   
   // we don't remove the reservation record when cancelling.
    // we insert a new activity record with an activity type of "cancel" and status of "unconfirmed"
    // the RMH staff will have to confirm the cancellation
              $retval = insert_RoomReservationActivity ($informationroom);
              echo '<div id="content" style="margin-left: 300px; margin-top: 23px;">';
              if ($retval == -1) 
                      echo"Could not update the Room Reservation";
             else
             echo "Update was successful";
          
      
}


include (ROOT_DIR . '/footer.php');
?>


