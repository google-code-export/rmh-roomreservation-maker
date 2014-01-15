<?php
/*
 * @author Bruno Constantino
 * @author Kristen Gentle
 * 
 * @version December 12, 2012
 *
 * Edit Family Profile 
 * 
 * This page allows SW to update a family's profile.
 * When the family is selected, their profile information is displayed and
 * three options are given to the SW:
 * 
 * 1. Modify the profile.
 * 2. Cancel family profile.
 * 3. Create Room Reservation.
 * 
 */
session_start();
session_cache_expire(30);

$title = "Edit Family Profile"; //This should be the title for the page, included in the <title></title>

include('../header.php'); //including this will further include (globalFunctions.php and config.php)

include_once(ROOT_DIR . '/domain/UserProfile.php');
include_once(ROOT_DIR . '/domain/ProfileActivity.php');
include_once(ROOT_DIR . '/database/dbProfileActivity.php');
include_once(ROOT_DIR . '/database/dbUserProfile.php');
include_once(ROOT_DIR . '/mail/functions.php');
include_once(ROOT_DIR . '/domain/Family.php');
include_once(ROOT_DIR . '/database/dbFamilyProfile.php');

error_log("in EditFamilyProfile");
$showForm = false;
$showResult = false;
$message = array();


// the first time the site is visited
// if the user clicked on the patient name in the table of family profiles, then a new request
    // is sent with $id set to the family profile id, and this section of code is invoked
   // function displayProfile( $familyProfile )//should this be pass by ref and set as const?
    if (isset($_GET['id']) )
    {   //gets the familyid passed down by the family profile search and when the profile is selected(clicked)
            $familyID = sanitize( $_GET['id'] );

            error_log("family profile id is $familyID");
           
            $familyProfile = retrieve_FamilyProfile ($familyID);
            if($familyProfile){
                $showForm = TRUE;
            }
            else
            {
                echo ' cannot retrieve family profile record';
            }
}// end stuff that is done the first time the form is visited


if (isset($_POST['form_token']) && validateTokenField($_POST)) {
    
   error_log('will process the editing form');
 //   $activityType = "Edit";
    $profileActitivityStatus = "Unconfirmed";

    //retrieves the sw, and gets id, firstname and lastname      
    $currentUser = getUserProfileID();
    $sw = retrieve_UserProfile_SW($currentUser);  // what if the current user is a RMH staff?
    //print_r($sw);
    $swObject = current($sw);
    $sw_id = $swObject->get_userProfileId();
    $sw_fname = $swObject->get_swFirstName();
    $sw_lname = $swObject->get_swLastName();
    $dateSubmit = date("Y-m-d");

    $familyProfile =   readFormData();
    error_log('read the form data, parent last name is '.$familyProfile->get_parentlname());
    
    if ($showResult)
{
         error_log("will call updateProfile");
         $ret = updateFamilyProfile($familyProfile);
          if ($ret== false) {
            echo "<section class=\"content\">";
         echo"Database error - could not update the family profile";
          
    }
    else
    {
        echo "<section class=\"content\">";
        echo "Update was successful";
    }
  
   }  // end $showResult is true
   else
   {
       echo "<section class=\"content\">";
       error_log("the family profile was not updated");
       echo "The family profile has not been updated. Please correct errors and try again";
   }
   echo "</section>";
}
 
//if $showForm = true, display form to enter data
if ($showForm == true) {
    error_log("will display the editing form");
    //FORM
   
?>
<section class="content">
<div id="container">

    <div id="content">

        <form id="informationForm" name ="EditFamilyProfile" method="post" action="EditFamilyProfile.php">
<?php echo generateTokenField(); ?>

            <div>                         
                <th colspan="2"> <h2> Edit Family Profile </h2></th>
            </div>

            <div>
                <input type="hidden" name="familyProfileID" id="hiddenField" value="<?php echo $familyProfile->get_familyProfileId()?>"/>
                <input type="hidden" name="status" id="hiddenField" value="<?php echo $familyProfile->get_familyProfileStatus()?>"/>
                Parent First Name:<br>                   
                <input class="formtop formt" 
                       type="text" 
                       name="ParentFirstName" 
                       value="<?php echo htmlspecialchars($familyProfile->get_parentfname()); ?>"
                       />
                <br>Parent Last Name:<br>
                <input class="formt" 
                       type="text" 
                       name="ParentLastName" 
                       value="<?php echo htmlspecialchars($familyProfile->get_parentlname()); ?>"
                       />
                <br> Email:<br>
                <input class="formt" 
                       type="text" 
                       name="Email" 
                       value="<?php echo htmlspecialchars($familyProfile->get_parentemail()); ?>"
                       />
                <br>Number of Phone1:<br>
                <input class="formt" 
                       type="text" 
                       name="Phone1" 
                       value="<?php echo htmlspecialchars($familyProfile->get_parentphone1()); ?>"
                       />
                <br>Number of Phone2:<br>
                <input class="formt" 
                       type="text" 
                       name="Phone2" 
                       value="<?php echo htmlspecialchars($familyProfile->get_parentphone2()); ?>"
                       />
                <br>Address:<br>
                <input class="formt" 
                       type="text" 
                       name="parentAddr" 
                       value="<?php echo htmlspecialchars($familyProfile->get_parentaddress()); ?>"
                       />
                <br>City:<br>
                <input class="formt" 
                       type="text" 
                       name="parentcity" 
                       value="<?php echo htmlspecialchars($familyProfile->get_parentcity()); ?>"
                       />
                <br>State:<br>
                <input class="formt" 
                       type="text" 
                       name="parentstate" 
                       value="<?php echo htmlspecialchars($familyProfile->get_parentstate()); ?>"
                       />
                <br>Zip Code:<br>
                <input class="formt" 
                       type="text" 
                       name="parentzip" 
                       value="<?php echo htmlspecialchars($familyProfile->get_parentzip()); ?>"
                       />
                <br>Country:<br>
                <input class="formt"  
                       type="text" 
                       name="parentcountry" 
                       value="<?php echo htmlspecialchars($familyProfile->get_parentcountry()); ?>"      
                       />

                <br>Patient First Name:<br>
                <input class="formt" 
                       type="text" 
                       name="PatientFirstName" 
                       value="<?php echo htmlspecialchars($familyProfile->get_patientfname()); ?>"
                       />
                <br>Patient Last Name:<br>
                <input class="formt" 
                       type="text" 
                       name="PatientLastName" 
                       value="<?php echo htmlspecialchars($familyProfile->get_patientlname()); ?>"
                       />
                <br>Patient Relation:<br>
                <input class="formt"  
                       type="text" 
                       name="PatientRelation" 
                       value="<?php echo htmlspecialchars($familyProfile->get_patientRelation()); ?>"      
                       />
                <br>Patient Date of Birthday: Year-Month-Date<br>
                <input class="formt"
                       type="text"
                       name="PatientDOB"
                       value="<?php echo htmlspecialchars($familyProfile->get_patientdob()); ?>"
                       />
          <!--      <br>Diagnosis:<br>
                <input class="formt" 
                       type="text" 
                       name="PatientDiagnosis" 
                       value="<?php echo htmlspecialchars($familyProfile->get_patientformpdf()); ?>"
                       />
                <br>Notes:<br> -->
          <input type="hidden" name="patientFormPDF" id="hiddenField" value="<?php echo $familyProfile->get_patientformpdf()?>"/>  
          <input class="formt" 
                       type="text" 
                       name="PatientNotes" 
                       value="<?php echo htmlspecialchars($familyProfile->get_patientnotes()); ?>"
                       />

            </div>

            <div style="margin-top: 30px" >                     
                <input class="formsubmit" type="submit" name="submit" value="Save Profile"/>
                <input class="helpbutton" type="submit" value="Help" align="bottom" onclick="location.href='../help/SearchingFamilyProfile.php'" />
            </div>

        </form>

    </div>
</div>
</section>

<?php
}   // end if (showForm -==TRUE)

function readFormData() {
    error_log("inside readFormData");
   
    global $showForm;
    global $showResult;
 
    
    $hasError = false;
    $familyProfile = NULL;
     if ( isset($_POST['familyProfileID']) && (!empty($_POST['familyProfileID'])))
        {
        $familyID = sanitize($_POST['familyProfileID']);
        error_log('in readData, family Profile ID is '.$familyID);
    }
    else
    {
        // this shouldn't happwen
         error_log("family profile id is empty");
        $hasError = true;
    }
    
 if ( isset($_POST['status']) && (!empty($_POST['status'])))
        {
        $status = sanitize($_POST['status']);
    }
    else
    {
         $message['status'] = '<p><font color="red">Missing status.</font></p>';
         error_log("family status is empty");
         $status="";
        $hasError = true;
    }
     if ( isset($_POST['ParentFirstName']) && (!empty($_POST['ParentFirstName'])))
        {
        $parentFirstName = sanitize($_POST['ParentFirstName']);
    }
    else
    {
          $message['parentFName'] = '<p><font color="red">Missing parent first name.</font></p>';
         error_log("parent first name is empty");
         $parentFirstname ="";
        $hasError = true;
    }
    if ( isset($_POST['ParentLastName']) && (!empty($_POST['ParentLastName'])))
        {
        $parentLastName = sanitize($_POST['ParentLastName']);
    }
    else
    {
          $message['parentLName'] = '<p><font color="red">Missing parent last name.</font></p>';
         error_log("parent last name is empty");
         $parentLastName='';
        $hasError = true;
    }


    if (isset($_POST['Email']) &&(!empty($_POST['Email'])))
       {
        $parentEmail = sanitize($_POST['Email']);
    }
 else
    {
       $message['email'] = '<p><font color="red">Missing parent email.</font></p>';
         error_log("parent email is empty");
         $parentEmail='';
        $hasError = true;
    }

    if (isset($_POST['Phone1']) &&(!empty($_POST['Phone1'])))
        {
        $parentPhone1 = sanitize($_POST['Phone1']);
    }
    else
    {
          $message['phone1'] = '<p><font color="red">Missing parent phone.</font></p>';
         error_log("parent phone1 is empty");
         $parentPhone1='';
        $hasError = true;
    }


    if (isset($_POST['Phone2']) && (!empty($_POST['Phone2'])))
        {
        $parentPhone2 = sanitize($_POST['Phone2']);
    } else {
        $parentPhone2 = "";
    }

    if (isset($_POST['parentAddr']) && (!empty($_POST['parentAddr'])))
      {
        $parentAddress = sanitize($_POST['parentAddr']);
    }
 else
    {
       $message['parentAddress'] = '<p><font color="red">Missing parent address.</font></p>';
         error_log("parent address is empty");
         $parentAddress='';
        $hasError = true;
    }

    if (isset($_POST['parentcity']) && (!empty($_POST['parentcity'])))
      {
        $parentCity = sanitize($_POST['parentcity']);
    }
else
    {
        $message['parentCity'] = '<p><font color="red">Missing parent city.</font></p>';
         error_log("parent city is empty");
         $parentCity='';
        $hasError = true;
    }

    if ( isset($_POST['parentstate']) && (!empty($_POST['parentstate'])))
       {
        $parentState = $_POST['parentstate'];
    }
else
    {
      $message['parentState'] = '<p><font color="red">Missing parent state.</font></p>';
         error_log("parent state is empty");
         $parentState='';
        $hasError = true;
    }

    if (isset($_POST['parentzip']) && (!empty($_POST['parentstate'])))
      {
        $parentZIP = sanitize($_POST['parentzip']);
    }
else
    {
      $message['parentzip'] = '<p><font color="red">Missing parent zipcode.</font></p>';
         error_log("parent zip is empty");
         $parentZIP='';
        $hasError = true;
    }

    if (isset($_POST['parentcountry']) && (!empty($_POST['parentcountry'])))
        {
        $parentCountry = sanitize($_POST['parentcountry']);
    }
  else
    {
        $message['parentCountry'] = '<p><font color="red">Missing country.</font></p>';
        $parentCountry = "";
         error_log("parent country is empty");
        $hasError = true;
    }
    
    if ( isset($_POST['PatientFirstName']) && (!empty($_POST['PatientFirstName'])))
       {
        $patientFirstName = sanitize($_POST['PatientFirstName']);
    }
     else
    {
           $message['patFName'] = '<p><font color="red">Missing patient first name.</font></p>';
         error_log("patient first name is empty");
         $patientFirstName='';
        $hasError = true;
    } 


    if (isset($_POST['PatientLastName']) && (!empty($_POST['PatientLastName'])))
       {
        $patientLastName = sanitize($_POST['PatientLastName']);
    }
     else
    {
           $message['patLname'] = '<p><font color="red">Missing patient last name.</font></p>';
         error_log("patient last name is empty");
         $patientLastName='';
        $hasError = true;
    } 

    if (isset($_POST['PatientRelation']) && (!empty($_POST['PatientRelation'])))
       {
        $patientRelation = sanitize($_POST['PatientRelation']);
    }
  else
    {
        $message['patRel'] = '<p><font color="red">Missing patient relationship.</font></p>';
         error_log("patient relationship is empty");
         $patientRelation='';
        $hasError = true;
    } 
    
    if (isset($_POST['PatientDOB']) && (!empty($_POST['PatientDOB'])))
        {
        $patientDateOfBirth = sanitize($_POST['PatientDOB']);
    }
  else
    {
        $message['patDOB'] = '<p><font color="red">Missing patient date of birth.</font></p>';
         error_log("patient date of birth is empty");
         $patientDateOfBirth='';
        $hasError = true;
    }   

    if (isset($_POST['patientFormPDF']) && (!empty($_POST['patientFormPDF'])))
     {
        $patientFormPDF = sanitize($_POST['patientFormPDF']);
    } else {
        $patientFormPDF = "";
    }

    if (isset($_POST['PatientNote']) && (!empty($_POST['PatientNote'])))
       {
        $patientNote = sanitize($_POST['PatientNote']);
    } else {
        $patientNote = "";
    }

    if (isset($_POST['swNote']) &&  (!empty($_POST['swNote'])))
       {
        $profileActityNotes = sanitize($_POST['swNote']);
    } else {
        $profileActityNotes = "";
    }
    
if ($hasError == true)  // something could not be validated or read
{
    echo '<div id="content" style="margin-left: 300px; margin-top: 23px;">';
    if (!empty($message)) {
        foreach ($message as $messages) {
            echo $messages;
        }
    }
    error_log("there was a problem in the form");
    $showForm = true;
}
else
    $showResult = true;

 $familyProfile = new Family($familyID, $status, $parentFirstName, $parentLastName, $parentEmail, 
         $parentPhone1, $parentPhone2, $parentAddress, $parentCity, $parentState, $parentZIP,
            $parentCountry, $patientFirstName, $patientLastName, $patientRelation,
            $patientDateOfBirth, $patientFormPDF, $patientNote);

 return $familyProfile;

}

function updateFamilyProfile(Family $familyProfile)
{
     error_log("in updateFamilyProfile will do the actual insert to the database");

    $activityType = "Edit";
    //retrieves the sw, and gets id, firstname and lastname      
    $currentUser = getUserProfileID();
    

   $swID = "";
   $swFirstName = "";
   $swLastName = "";
   $rmhStaffProfileId = "";
   $rmhStaffFirstName = "";
   $rmhStaffLastName = "";
   $dateSWSubmit = 'NULL';
   $dateRMHApproved = 'NULL';
   
    // if the person doing the edit is a social worker, add their name and id to the reservation 
    // activity record
    if (getUserAccessLevel()==1)
    {
        $rmhStaffProfileId = 'NULL';
        $sw = retrieve_UserProfile_SW($currentUser);
         $swObject = current($sw);   // there is only one record in the returned array, so get it
                                                    // consider changing this code
         $swID = $swObject->get_swProfileId();
     //   $swFirstName = $swObject->get_swFirstName();
     //   $swLastName=$swObject->get_swLastName();
         $status= "Unconfirmed";
             $dateSWSubmit = date("Y-m-d H:i:s");
    }
    // if the person doing the edit is a RMH staff person, add their name and id to the reservation
    // activity record. Will give it a status of Confirmed instead of Unconfirmed
    else if (getUserAccessLevel()==2)
    {
        $rmhStaff = retrieve_UserProfile_RMHApprover_OBJ($currentUser);
        $rmhStaffProfileId = $rmhStaff->get_rmhStaffProfileId();
    //    $rmhStaffFirstName = $rmhStaff->get_rmhStaffFirstName();
      //  $rmhStaffLastName = $rmhStaff->get_rmhStaffLastName();
        $status = "Confirmed";
        $dateRMHApproved = date("Y-m-d H:i:s");
    }

    // only if this is an RMH staff approval
   // insert_FamilyProfile($familyProfile);
   
      error_log('in updateFamilyProfile, familyProfileId is '.$familyProfile->get_familyProfileId());
    // only insert an activity record - will insert change into FamilyProfile table only if
    // approved
   $currentProfileActivity = new ProfileActivity( 0,                          //$profileActivityId
			                0,                          //$profileActivityRequestId
			                $familyProfile->get_familyProfileId(),    //$familyProfileId
				//requestID set to 0 as placeholders.
				//TODO: change this!
				$swID,                     
				//$swLastName,                  
				//$swFirstName,                  
				$rmhStaffProfileId,                          //$rmhStaffProfileId
				//$rmhStaffLastName,                         //$rmhStaffLastName
				//$rmhStaffFirstName,                         //$rmhStaffFirstName
				$dateSWSubmit,                //$swDateStatusSubm
				$dateRMHApproved,                          //$rmhDateStatusSubm
				$activityType,              
				$status,   
				$familyProfile->get_parentfname(),           
				$familyProfile->get_parentlname(),            
				$familyProfile->get_parentemail(),               
				$familyProfile->get_parentphone1(),                    
				$familyProfile->get_parentphone2(),                    
				$familyProfile->get_parentaddress(),                   
				$familyProfile->get_parentcity(),                      
				$familyProfile->get_parentstate(),                     
				$familyProfile->get_parentzip(),                       
				$familyProfile->get_parentcountry(),                   
				$familyProfile->get_patientfname(),          
				$familyProfile->get_patientlname(),           
				$familyProfile->get_patientrelation(),           
				$familyProfile->get_patientdob(),        
				$familyProfile->get_patientformpdf(),            
				$familyProfile->get_patientnotes(),               
				$familyProfile->get_patientnotes()        
		);


    $retval = insert_ProfileActivity($currentProfileActivity);
   return $retval;
} // end updateReservation
include (ROOT_DIR . '/footer.php');
//include the footer file, this contains the proper </body> and </html> ending tag.
?>
