<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
<?php
session_start();
session_cache_expire(30);

$title = "Cancel Reservation";

include('../header.php');
include(ROOT_DIR . '/database/dbReservation.php');

$showReservation = false;

if (isset($_POST['form_token']) && validateTokenField($_POST)) {
    $showReservation = true;
} else if (isset($_POST['form_token']) && !validateTokenField($_POST)) {

    echo('The request could not be completed: security check failed!');
} else {
    
}

        
     //   $RequestID = $_SESSION['RequestID'];        //USING DYNAMIC LINK
        
 if(isset($_GET['id']) )
    {   //gets the Requestid passed down by the SearchReservation.php
            $RequestID = sanitize( $_GET['id'] );           //USING DYNAMIC LINK
    }
    else
            $RequestID = 'Request ID';
        
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
        
        $informationroom = retrieve_RoomReservationActivity_byRequestId($RequestID); 
        $newParentLastName = $informationroom->get_parentLastName();
        $newParentFirstName = $informationroom->get_parentFirstName();
        $newBeginDate = $informationroom->get_beginDate();
        $newEndDate = $informationroom->get_endDate();
        $newPatientDiagnosis = $informationroom->get_patientDiagnosis();
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

     </body>
</html>       