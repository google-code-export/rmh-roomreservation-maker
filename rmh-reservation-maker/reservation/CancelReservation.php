
        <?php
session_start();
session_cache_expire(30);

$title = "Cancel Reservation";

include('../header.php');
include(ROOT_DIR . '/database/dbReservation.php');

        $ArrayRequestRoom = $_SESSION['ArrayRequestRoomChosen'];
        $RequestID = $_SESSION['RequestID'];  
       //retrieves the sw, and gets id, firstname and lastname      
        $currentUser = getUserProfileID();
        $sw = retrieve_UserProfile_SW($currentUser);
        $swObject = current($sw);
        $sw_id = $swObject->get_swProfileId();
        $swFirstName = $swObject->get_swFirstName();
        $swLastName = $swObject->get_swLastName();
        $ActivityType ="Cancel";
        $Status ="Unconfirmed";
        $swDateStatusSubmitted = date("Y-m-d");
        $userId = sanitize(getCurrentUser());
        
        $newParentLastName = $ArrayRequestRoom->get_parentLastName();
        $newParentFirstName = $ArrayRequestRoom->get_parentFirstName();
        $newBeginDate = $ArrayRequestRoom->get_beginDate();
        $newEndDate = $ArrayRequestRoom->get_endDate();
        $newPatientDiagnosis = $ArrayRequestRoom->get_status();
        $newNotes = "";
                         
        
        $currentreservation = new Reservation (0, $RequestID, 0, $newParentLastName, 
                $newParentFirstName, $sw_id, $swLastName, $swFirstName, 0, "",
                "", $swDateStatusSubmitted, "", $ActivityType, $Status, $newBeginDate, $newEndDate,
                $newPatientDiagnosis, $newNotes);

        if($RequestID != 'Request ID')
        {
            update_status_RoomReservationActivity($currentreservation);
            echo "Room Reservation Updated!";
        }
        else
        {
            echo "Could not Cancel the Room Reservation because the Request ID was not chosen, go back to Search Reservation and try again!";
        }
  ?>
<div id="container">

    <div id="content">

        <form name="CancelReservation" method="post" action="CancelReservation">
<?php echo generateTokenField(); ?>



        </form>    
      
        <?php
        include (ROOT_DIR . '/footer.php');
        ?>
