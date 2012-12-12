<?php
/*
 * @author Bruno Constantino
 * @author Kristen Gentle
 * 
 * @version December 12, 2012
 *
 * Edit Reservations
 * 
 * This page allows SW to modify a room reservation.
 * 
 * two options are given to the SW:
 * 
 * 1. Edit text boxes.
 * 2. Save.
 * 
 */


session_start();
session_cache_expire(30);

$title = "EditReservation";

include ('../header.php');
include_once (ROOT_DIR . '/domain/Reservation.php');
include_once (ROOT_DIR . '/domain/UserProfile.php');
include_once (ROOT_DIR . '/domain/Family.php');
include_once (ROOT_DIR . '/database/dbReservation.php');
include_once (ROOT_DIR . '/database/dbUserProfile.php');
include_once (ROOT_DIR . '/database/dbFamilyProfile.php');
//include_once(ROOT_DIR .'/mail/functions.php');

$showForm = false;
$showReport = false;
$message = array();


//if (isset($_POST['requestid']) && isset($_POST['familyid'])) {   //gets the Requestid passed down by the SearchReservation.php
    $RequestID = $_POST['requestid'];
//}

if (($RequestID) == 'Request ID') {
    $parentlname = "ParentLastName";
    $parentfname = "ParentFirstName";
} else {
    $informationroom = retrieve_RoomReservationActivity_byRequestId($RequestID);
    $parentfname = $informationroom->get_parentFirstName();
    $parentlname = $informationroom->get_parentLastName();
    $patientDiagnosis = $informationroom->get_patientDiagnosis();
}

//if token works
if (isset($_POST['form_token']) && validateTokenField($_POST)) {

    //startDate is not set
    if ((empty($_POST['begindate']))) {
        $message['BeginningDate'] = '<p><font color="red">You must select a beginning date!</font></p>';
        $showForm = true;
    }
    //endDate is not set
    if ((empty($_POST['enddate']))) {
        $message['EndDate'] = '<p><font color="red">You must select an end date!</font></p>';
        $showForm = true;
    }


    //Everything is set
    else {
        //check if dates are valid
        $currentdate = date("Ymd");
        $bdate = new DateTime($_POST['begindate']);
        $edate = new DateTime($_POST['enddate']);
        $formatbdate = $bdate->format('Ymd');
        $formatedate = $edate->format('Ymd');
        //end date before begin date
        if (($formatedate - $formatbdate) <= 0) {
            $message['EndAfterBeginDate'] = '<p><font color="red">End date must be after begin date!</font></p>';
            $showForm = true;
        }
        //request dates are in the past
        if ($currentdate - $formatedate >= 0 || $currentdate - $formatbdate > 0) {
            $message['DatesInThePast'] = '<p><font color="red">Dates cannot be in the past!</font></p>';
            $showForm = true;
        } else {
            $showReport = true;
        }
    }
    //patient last name is not set
    if (isset($_POST['PatientLastName']) && !empty($_POST['PatientLastName'])) {
        $newPatientLastName = sanitize($_POST['PatientLastName']);
    } else {
        $message['PatientLastName'] = '<p><font color="red">You must enter the Patient Last Name.</font></p>';
        $showForm = true;
    }
    //patient first name is not set
    if (isset($_POST['PatientFirstName']) && !empty($_POST['PatientFirstName'])) {
        $newPatientFirstName = sanitize($_POST['PatientFirstName']);
    } else {
        $message['PatientFirstName'] = '<p><font color="red">You must enter the Patient First Name.</font></p>';
        $showForm = true;
    }
    //patient diagnosis is not set
    if (isset($_POST['PatientDiagnosis']) && !empty($_POST['PatientDiagnosis'])) {
        $newPatientDiagnosis = sanitize($_POST['PatientDiagnosis']);
    } else {
        $message['PatientDiagnosis'] = '<p><font color="red">You must enter the Patient Diagnosis.</font></p>';
        $showForm = true;
    }
    if (isset($_POST['Notes'])) {
        $newNotes = sanitize($_POST['Notes']);
    }
    //parent last name is not set
    if (isset($_POST['ParentLastName']) && !empty($_POST['ParentLastName'])) {
        $newParentLastName = sanitize($_POST['ParentLastName']);
    } else {
        $message['ParentLastName'] = '<p><font color="red">You must enter the Parents Last Name.</font></p>';
        $showForm = true;
    }
    //parent first name is not set
    if (isset($_POST['ParentFirstName']) && !empty($_POST['ParentFirstName'])) {
        $newParentFirstName = sanitize($_POST["ParentFirstName"]);
    } else {
        $message['ParentFirstName'] = '<p><font color="red">You must enter the Parents First Name.</font></p>';
        $showForm = true;
    }
    echo '<div id="content" style="margin-left: 300px; margin-top: 23px;">';
    if (!empty($message)) {
        foreach ($message as $messages) {
            echo $messages;
        }
    }
}


//Token is bad
else if (isset($_POST['form_token']) && !validateTokenField($_POST)) {
    $_POST['begindate'] = "";
    $_POST['enddate'] = "";
    $_POST['PatientDiagnosis'] = "";
    $_POST['Notes'] = "";
    $_POST['ParentLastName'] = "";
    $_POST['ParentFirstName'] = "";
    $message = '<p><font color="red">Please select and enter all required data for your reservation</font></p>';
    $showForm = true;
}
//No POST data
else {
    $_POST['begindate'] = "";
    $_POST['enddate'] = "";
    $_POST['PatientDiagnosis'] = "";
    $_POST['Notes'] = "";
    $_POST['ParentLastName'] = "";
    $_POST['ParentFirstName'] = "";
    $message = '<p><font color="red">Please select and enter all required data for your reservation</font></p>';
    $showForm = true;
}
?>
</div>




<?php
// mail("approvers email address goes here", $RoomReservationRequestID,
//"This is a pending request")//email the approver the request key, not sure
//if it should look like this though.

echo '<div id="container">';
echo '<div id="content" style="margin-left: 250px; margin-top: 23px;">';

//if $showForm = true, display form to enter data
if ($showForm == true) {
    //FORM
    ?>
    <form name ="Edit Reservation" method="POST" action="EditReservation.php">
    <?php echo generateTokenField(); ?>
        <label for="BeginDate">Begin Date:</label>
        <input name="begindate" type="date">
        <br><br>
        <label for="endDate">End Date:</label>
        <input name="enddate" type="date">
        <br><br>
        Patient Last Name<br>
        <input class="formt formtop" id="patientlname" type="text" name="PatientLastName" value="Patient Last Name"onfocus="if(this.value == 'Patient Last Name'){ this.value = ''; }"/><br>
        Patient First Name<br>
        <input class="formt" id="patientfname" type="text" name="PatientFirstName" value="Patient First Name" onfocus="if(this.value == 'Patient First Name'){ this.value = ''; }"/><br>
        Patient Diagnosis<br>        
        <input class="formt" id="patientdiagnosis" type="text" name="PatientDiagnosis" value="<?php echo htmlspecialchars($patientDiagnosis); ?>" onfocus="if(this.value == 'PatientDiagnosis'){ this.value = ''; }"/><br>
        Notes<br>         
        <input class="formt" id="notes" type="text" name="Notes" value="Notes" onfocus="if(this.value == 'Notes'){ this.value = ''; }"/><br>
        Parent Last Name<br>         
        <input class="formt" id="parentlname" type="text" name="ParentLastName" value="<?php echo htmlspecialchars($parentlname); ?>" onfocus="if(this.value == 'ParentLastName'){ this.value = ''; }"/><br>
        Parent First Name<br>         
        <input class="formt formbottom" id="parentfirstname" type="text" name="ParentFirstName" value="<?php echo htmlspecialchars($parentfname); ?>" onfocus="if(this.value == 'ParentFirstName'){ this.value = ''; }"/><br>


        <input class="formsubmit"type="submit" value="Save" name="submit" />
    </form>            

    <?php
} else if ($showReport == true) {
    $newBeginDate =
            sanitize($_POST['begindate']);
    $newEndDate =
            sanitize($_POST['enddate']);





    //retrieves the sw, and gets id, firstname and lastname      
    $currentUser = getUserProfileID();
    $sw = retrieve_UserProfile_SW($currentUser);
    $swObject = current($sw);
    $sw_id = $swObject->get_swProfileId();
    $swFirstName = $swObject->get_swFirstName();
    $swLastName = $swObject->get_swLastName();
    $ActivityType = "Modify";
    $Status = "Unconfirmed";
    $swDateStatusSubmitted = date("Y-m-d");
    $userId = sanitize(getCurrentUser());


    $currentreservation = new Reservation(0, $RequestID, 0, $newParentLastName,
                    $newParentFirstName, $sw_id, $swLastName, $swFirstName, 0, "",
                    "", $swDateStatusSubmitted, "", $ActivityType, $Status, $newBeginDate, $newEndDate,
                    $newPatientDiagnosis, $newNotes);
    if ($RequestID != 'Request ID') {
        update_status_RoomReservationActivity($currentreservation);
        echo "Room Reservation Updated!";
    }
    else
        echo"Could not update the Room Reservation because the Request ID was not chosen, go back to Search Reservation and try again!";
}
?>
</div>
</div>

<?php
include (ROOT_DIR . '/footer.php');
?>