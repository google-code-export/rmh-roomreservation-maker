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
 * Only fields in the reservation itself are editable. Those fields are the begin and end dates, the diagnosis and notes
 * To edit family information, the SW must use the Family Profile Edit
 * 
 */

/*
 * This script works by retrieving the reservation information the first time it is accessed. It then
 * displays a form with the reservation information. Some of the fields are editable (only the fields that 
 * correspond to the reservation request record itself, not the family profile).
 * After the user edits the form and hits submit, the script checks that the information is valid.
 * If it is, a new room reservation request record is generated with the changes, a status of 'Unconfirmed" and
 * a type of 'Modify'
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

// the first time the site is visited
if (isset($_SESSION['RequestID'])) {
    $idChosen = $_SESSION['RequestID'];

    error_log("in editReservation, request id is $idChosen");

    $informationroom = retrieve_RoomReservationActivity_byRequestId($idChosen);

    $beginDate = new DateTime($informationroom->get_beginDate());
    $endDate = new DateTime($informationroom->get_endDate());
    $formattedBeginDate = $beginDate->format('Y-m-d');
    $formattedEndDate = $endDate->format('Y-m-d');


    $showForm = true;
    unset($_SESSION['RequestID']);  // so that we won't go through the retrieval steps after the first time
}// end stuff that is done the first time the form is visited

//process the editing form
if (isset($_POST['form_token']) && validateTokenField($_POST)) {
    error_log("will process the edit form");
    
   $informationroom = readFormData();
   
    $fid = $informationroom->get_familyProfileId();
    error_log("read data, informationroom->familyProfileID is  $fid");
    $rid= $informationroom->get_rmhStaffProfileId();
    error_log("read data, informationroom->rmh staff  is  $rid");
    
     $beginDate = new DateTime($informationroom->get_beginDate());
    $endDate = new DateTime($informationroom->get_endDate());
    $formattedBeginDate = $beginDate->format('Y-m-d');
     $formattedEndDate = $endDate->format('Y-m-d');
     if ($showForm == true)
         error_log('showForm is true');
     else
         error_log('showForm is false');

     if ($showReport == true)
     {
         error_log("will call updateReservation");
         $ret = updateReservation($informationroom);
         
         // display messages based on return value
     }
    
}   // end form processing


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
    
    error_log("no post data");
  
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
    error_log("will display the editing form");
    //FORM
    ?>
<section class="content">
    <form name ="Edit Reservation" method="POST" action="EditReservation.php">
    <?php echo generateTokenField(); ?>
        <label for="BeginDate">Begin Date:</label>
        <input name="begindate" type="date" value="<?php echo htmlspecialchars($formattedBeginDate); ?>">
        <br><br>
        <label for="endDate">End Date:</label>
        <input name="enddate" type="date" value="<?php echo htmlspecialchars($formattedEndDate); ?>">
        <br><br>
        <input type="hidden" name="reservationKey" id="hiddenField" value="<?php echo $informationroom->get_roomReservationKey()?>"/>
        <input type="hidden" name="activityID" id="hiddenField" value="<?php echo $informationroom->get_roomReservationActivityID()?>"/>
        <input type="hidden" name="reservationRequestID" id="hiddenField" value="<?php echo $informationroom->get_roomReservationRequestID()?>"/>
        <input type="hidden" name="familyProfileID" id="hiddenField" value="<?php echo $informationroom->get_familyProfileId()?>"/>
        <input type="hidden" name="rmhStaffProfileID" id="hiddenField" value="<?php echo $informationroom->get_rmhStaffProfileId()?>"/>
        <input type="hidden" name="swDateStatusSubmitted" id="hiddenField" value="<?php echo $informationroom->get_swDateStatusSubmitted()?>"/>
        <input type="hidden" name="rmhDateStatusSubmitted" id="hiddenField" value="<?php echo $informationroom->get_rmhDateStatusSubmitted()?>"/>
        <input type="hidden" name="status" id="hiddenField" value="<?php echo $informationroom->get_status()?>"/>
        Patient Last Name<br>
        <input class="formt formtop" id="patientlname" type="text" name="PatientLastName" value="<?php echo htmlspecialchars($informationroom->get_patientLastName()); ?>"  readonly="readonly" onfocus="if(this.value == 'Patient Last Name'){ this.value = ''; }"/><br>
        Patient First Name<br>
        <input class="formt" id="patientfname" type="text" name="PatientFirstName" value= "<?php echo htmlspecialchars($informationroom->get_patientFirstName()); ?>" readonly="readonly" onfocus="if(this.value == 'Patient First Name'){ this.value = ''; }"/><br>
        Patient Diagnosis<br>        
        <input class="formt" id="patientdiagnosis" type="text" name="PatientDiagnosis" value="<?php echo htmlspecialchars($informationroom->get_patientDiagnosis()); ?>" onfocus="if(this.value == 'PatientDiagnosis'){ this.value = ''; }"/><br>
        Notes<br>         
        <input class="formt" id="notes" type="text" name="Notes" value="Notes" onfocus="if(this.value == 'Notes'){ this.value = ''; }"/><br>
        Parent Last Name<br>         
        <input class="formt" id="parentlname" type="text" name="ParentLastName" value="<?php echo htmlspecialchars($informationroom->get_parentLastName()); ?>" readonly="readonly" onfocus="if(this.value == 'ParentLastName'){ this.value = ''; }"/><br>
        Parent First Name<br>         
        <input class="formt formbottom" id="parentfirstname" type="text" name="ParentFirstName" value="<?php echo htmlspecialchars($informationroom->get_parentFirstName()); ?>" readonly="readonly"onfocus="if(this.value == 'ParentFirstName'){ this.value = ''; }"/><br>


        <input class="formsubmit"type="submit" value="Save" name="submit" />
    </form>            
</section>
    <?php
}   // end displaying the form


// This reads and validates the information in the editing form, where the user might have
// changed some of the information
// it constructs and returns a new reservation object
// since much of the information in a reservation object is not in the form, we use
// hidden variables to pass the values from the original reservation object through the form
// these must also be read and copied to the new reservation object
function readFormData()
{
    error_log("in readFormData");
    global $showForm;
    global $showReport;
    
    $hasError = false;
    
    $formattedBeginDate="";
    $formattedEndDate="";
    $message=array();
     $ret = readAndValidateDates($formattedBeginDate, $formattedEndDate,$message);
     error_log("after reading dates, begin date is $formattedBeginDate");
     if ($ret == false)
         $hasError = true;
     
    
    if (isset($_POST['reservationKey']) && !empty($_POST['reservationKey'])) {
        $newReservationKey = sanitize($_POST['reservationKey']);
    } else {
        $message['reservationkey'] = '<p><font color="red">Missing reservation key.</font></p>';
        error_log("no reservation key");
        $hasError = true;
    }
    
    if (isset($_POST['activityID']) && !empty($_POST['activityID'])) {
        $newActivityID = sanitize($_POST['activityID']);
        error_log("posted activity id is $newActivityID");
    } else {
        $message['activityID'] = '<p><font color="red">Missing activity id.</font></p>';
        error_log("no activity id");
        $hasError = true;
    }
     if (isset($_POST['reservationRequestID']) && !empty($_POST['reservationRequestID'])) {
        $newReservationRequestID = sanitize($_POST['reservationRequestID']);
    } else {
        $message['resevationRequestID'] = '<p><font color="red">Missing reservation request id.</font></p>';
        error_log("no reservation request id");
        $hasError = true;
    }
    
      if (isset($_POST['familyProfileID']) && !empty($_POST['familyProfileID'])) {
        $newFamilyProfileID = sanitize($_POST['familyProfileID']);
        error_log("posted family profile id is $newFamilyProfileID");
    } else {
        error_log("no family profile id");
        $hasError = true;
    }
    
      if (isset($_POST['rmhStaffProfileID']) && !empty($_POST['rmhStaffProfileID'])) {
        $newrmhStaffProfileID = sanitize($_POST['rmhStaffProfileID']);
        error_log("posted rmh staff profile id is $newrmhStaffProfileID");
    } else {
        error_log("no rmh staff profile id");
        $newrmhStaffProfileID = 'NULL';
      //  $hasError = true;
        // this is not actually an error condition since an unconfirmed reservation will not have
        // a staff approver yet
    }
    
    
   if (isset($_POST['swDateStatusSubmitted']) && !empty($_POST['swDateStatusSubmitted'])) {
        $newSWDateStatusSubmitted = sanitize($_POST['swDateStatusSubmitted']);
        error_log("posted sw date status submitted is $newSWDateStatusSubmitted");
    } else {
     //   $message['resevationRequestID'] = '<p><font color="red">Missing reservation request id.</font></p>';
        error_log("no sw date status submitted");
        $hasError = true;
    }
    
   if (isset($_POST['rmhDateStatusSubmitted']) && !empty($_POST['rmhDateStatusSubmitted'])) {
        $newRMHDateStatusSubmitted= sanitize($_POST['rmhDateStatusSubmitted']);
        error_log("posted rmh date status submitted is $newRMHDateStatusSubmitted");
    } else {
     //   $message['resevationRequestID'] = '<p><font color="red">Missing reservation request id.</font></p>';
        error_log("no rmh date status submitted");
        $newRMHDateStatusSubmitted= "00-00";
      //  $hasError = true;
        // this is not actually an error condition since an unconfirmed reservation will not have
        // a staff approver yet
    }
    
 if (isset($_POST['status']) && !empty($_POST['status'])) {
        $newStatus= sanitize($_POST['status']);
    } else {
     //   $message['resevationRequestID'] = '<p><font color="red">Missing reservation request id.</font></p>';
        error_log("status is missing");
        $hasError = true;
    }
    
     //patient first name is not set
    if (isset($_POST['PatientFirstName']) && !empty($_POST['PatientFirstName'])) {
        $newPatientFirstName = sanitize($_POST['PatientFirstName']);
        error_log("posted patient first name is $newPatientFirstName");
      
    } else {
        // this should not happen
        error_log("no patient first name");
        $hasError= true;
    }
    
         //patient last name is not set
    if (isset($_POST['PatientLastName']) && !empty($_POST['PatientLastName'])) {
        $newPatientLastName = sanitize($_POST['PatientLastName']);
    
    } else {
        // this should not happen
       // $message['PatientLastName'] = '<p><font color="red">You must enter the Patient Last Name.</font></p>';
        error_log("no patient last name");
        $hasError = true;
    }
    //patient diagnosis is not set
    if (isset($_POST['PatientDiagnosis']) && !empty($_POST['PatientDiagnosis'])) {
        $newPatientDiagnosis = sanitize($_POST['PatientDiagnosis']);
        
    } else {
        $message['PatientDiagnosis'] = '<p><font color="red">You must enter the Patient Diagnosis.</font></p>';
        error_log("no patient diagnosis");
        $hasError = true;
    }
    
    // notes can be empty
    if (isset($_POST['Notes'])) {
        $newNotes = sanitize($_POST['Notes']);
       
    }
    //parent last name is not set
    if (isset($_POST['ParentLastName']) && !empty($_POST['ParentLastName'])) {
        $newParentLastName = sanitize($_POST['ParentLastName']);
      
    } else {
        // this should not happen
      //  $message['ParentLastName'] = '<p><font color="red">You must enter the Parents Last Name.</font></p>';
        error_log("no parent last name");
        $hasError = true;
    }
    //parent first name is not set
    if (isset($_POST['ParentFirstName']) && !empty($_POST['ParentFirstName'])) {
        $newParentFirstName = sanitize($_POST["ParentFirstName"]);
      
    } else {
        error_log("no parent first name");
        $hasError = true;
    }
    echo '<div id="content" style="margin-left: 300px; margin-top: 23px;">';
    if (!empty($message)) {
        foreach ($message as $messages) {
            echo $messages;
        }
}
if ($hasError == true)  // something could not be validated or read
{
    error_log("there was a problem in the form");
    $showForm = true;
}
else
    $showReport = true;

  $theReservation = new Reservation($newReservationKey, $newActivityID, $newReservationRequestID, $newFamilyProfileID,$newParentLastName,
    $newParentFirstName, $newPatientLastName, $newPatientFirstName, 'socialWorkerID','socialWorkerLastName', 'socialWorkerFirstName',$newrmhStaffProfileID, 'rmhStaffLastName', 'rmhStaffFirstName',
    $newSWDateStatusSubmitted, $newRMHDateStatusSubmitted, 'Modify', $newStatus, 
    $formattedBeginDate, $formattedEndDate, $newPatientDiagnosis, $newNotes);
  error_log("will return a reservation object");
  return $theReservation;
}// end function to read and validate data

function readAndValidateDates(&$formattedBeginDate, &$formattedEndDate,&$message)
{
    $bdate = new DateTime();
    $edate = new DateTime();
    $hasError = false;
        //startDate is not set
    if ((empty($_POST['begindate']))) {
        $message['BeginningDate'] = '<p><font color="red">You must select a beginning date!</font></p>';
        error_log('missing begin date');
        $hasError = true;
    }
    //endDate is not set
    if ((empty($_POST['enddate']))) {
        $message['EndDate'] = '<p><font color="red">You must select an end date!</font></p>';
        error_log('missing end date');
        $hasError = true;
    }
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
            error_log('end date after begin date');
            $hasError = true;
        }
        //request dates are in the past
        if ($currentdate - $formatedate >= 0 || $currentdate - $formatbdate > 0) {
            $message['DatesInThePast'] = '<p><font color="red">Dates cannot be in the past!</font></p>';
            error_log('request dates are in the past');
            $hasError = true;
        } 
      
    }
    if ($hasError)
      return false;
 
    // no problems with the dates
      $formattedBeginDate = $bdate->format('Y-m-d');

     $formattedEndDate = $edate->format('Y-m-d');
     return true;
   
} // end readAndValidateDates

function updateReservation(Reservation $informationroom)
{
     error_log("will do the actual insert to the database");
   // $newBeginDate = $informationroom->get_beginDate();
      
   // $newEndDate = $informationroom->get_endDate();
          

    //retrieves the sw, and gets id, firstname and lastname      
    $currentUser = getUserProfileID();
    
    // if the person doing the edit is a social worker, add their name and id to the reservation 
    // activity record
    if (getUserAccessLevel()==1)
    {
        $sw = retrieve_UserProfile_SW($currentUser);
         $swObject = current($sw);   // there is only one record in the returned array, so get it
                                                    // consider changing this code
        $informationroom->set_socialWorkerProfileId($swObject->get_swProfileId());
        $informationroom->set_swFirstName($swObject->get_swFirstName());
        $informationroom->set_swLastName($swObject->get_swLastName());
            $informationroom->set_status("Unconfirmed");
    }
    // if the person doing the edit is a RMH staff person, add their name and id to the reservation
    // activity record. Will give it a status of Confirmed instead of Unconfirmed
    else if (getUserAccessLevel()==2)
    {
        $rmhStaff = retrieve_UserProfile_RMHApprover_OBJ($currentUser);
        $informationroom->set_rmhStaffProfileId($rmhStaff->get_rmhStaffProfileId());
        $informationroom->set_rmhStaffFirstName($rmhStaff->get_rmhStaffFirstName());
        $informationroom->set_rmhStaffLastName($rmhStaff->get_rmhStaffLastName());
            $informationroom->set_status("Confirmed");
    }
        
   
    $informationroom->set_activityType("Modify");

    $informationroom->set_swDateStatusSubmitted(date("Y-m-d H:i:s"));
 //   $userId = sanitize(getCurrentUser());

     $fid = $informationroom->get_familyProfileId();
    error_log("in update, informationroom->familyProfileID is  $fid");
    $rid= $informationroom->get_rmhStaffProfileId();
    error_log("in update, informationroom->rmh staff  is  $rid");
    $begdt= $informationroom->get_beginDate();
    error_log("in update, informationroom->get_beginDate is $begdt");

   
   
    // insert a new activity record with a Modify status
    // because we keep track of all changes, never update
    // the current activity record. instead, insert a new one
    // with the same request id but new activity id
    
    $retval = insert_RoomReservationActivity ($informationroom);
    if ($retval == -1) {
         echo"Could not update the Room Reservation";
    }
    else
        echo "Update was successful";
} // end updateReservation
?>
</div>
</div>

<?php
include (ROOT_DIR . '/footer.php');
?>