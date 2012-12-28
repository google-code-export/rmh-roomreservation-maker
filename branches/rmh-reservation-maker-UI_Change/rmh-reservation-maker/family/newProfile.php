<?php
/**
 * @author Jessica Cheong
 * @version May 5, 2012
 * 
 * New Family Profile module for RMH-RoomReservationMaker.
 * 
 * To make a new family profile, the new family profile form is required to be filled out completely.
 * The form is then saved in another table until the record is validated by the RMH approver. 
 * A history of the activity is stored for future references. 
 * 
 */
//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "New Family Profile"; //This should be the title for the page, included in the <title></title>

include('../header.php'); //including this will further include (globalFunctions.php and config.php)

include_once(ROOT_DIR . '/domain/UserProfile.php');
include_once(ROOT_DIR . '/domain/ProfileActivity.php');
include_once(ROOT_DIR . '/database/dbProfileActivity.php');
include_once(ROOT_DIR . '/database/dbUserProfile.php');
include_once(ROOT_DIR . '/mail/functions.php');

$message = array();

if (isset($_POST['form_token']) && validateTokenField($_POST)) {
    $activityType = "Create";
    $profileActitivityStatus = "Unconfirmed";

    //retrieves the sw, and gets id, firstname and lastname      
    $currentUser = getUserProfileID();
    $sw = retrieve_UserProfile_SW($currentUser);
    //print_r($sw);
    $swObject = current($sw);
    $sw_id = $swObject->get_swProfileId();
    $sw_fname = $swObject->get_swFirstName();
    $sw_lname = $swObject->get_swLastName();
    $dateSubmit = date("Y-m-d");

    if (
            isset($_POST['ParentFirstName']) && 
//            $_POST['ParentFirstName'] != "Parent First Name" && 
            $_POST['ParentFirstName'] != "") {
        $parentFirstName = $_POST['ParentFirstName'];    
    } 
    else {
        $message['ParentFirstName'] = '<p><font color="red">You must enter the Parent First Name.</font></p>';
    }
    
    if (
            isset($_POST['ParentLastName']) && 
//            $_POST['ParentLastName'] != "Parent Last Name" && 
            $_POST['ParentLastName'] != "") {
        $parentLastName = $_POST['ParentLastName'];
    } 
    else {
        $message['ParentLastName'] = '<p><font color="red">You must enter the Parent Last Name.</font></p>';
        // print_r($message);
    }
    
    if (
            isset($_POST['Email']) && 
//            $_POST['Email'] != "E-Mail" && 
            $_POST['Email'] != "") {
        $parentEmail = $_POST['Email'];
    } 
    else {
        $message['Email'] = '<p><font color="red">You must enter the Email.</font></p>';
    }
    
    if (
            isset($_POST['Phone1']) && 
//            $_POST['Phone1'] != "Phone # 1" && 
            $_POST['Phone1'] != "") {
        $phone1 =$_POST['Phone1'];
    } 
    else {
        $message['Phone1'] = '<p><font color="red">You must enter the Parent Primary Phone Number</font></p>';
        //print_r($message);
    }
    
    if (
            isset($_POST['Phone2']) && 
//            $_POST['Phone2'] != "Phone # 2" && 
            $_POST['Phone2'] != "") {
        $phone2 = $_POST['Phone2'];
    } 
    else {
        $phone2 = "";
    }
    
    if (
            isset($_POST['Address']) && 
//            $_POST['Address'] != "Address" && 
            $_POST['Address'] != "") {
        $address = $_POST['Address'];
    } 
    else {
        $message['Address'] = '<p><font color="red">You must enter the Address.</font></p>';
    }
    
    if (
            isset($_POST['City']) && 
//            $_POST['City'] != "City" && 
            $_POST['City'] != "") {
        $city = $_POST['City'];
    } 
    else {
        $message['City'] = '<p><font color="red">You must enter the City.</font></p>';
    }
    
    if (
            isset($_POST['State']) && 
//            $_POST['State'] != "State" && 
            $_POST['State'] != "") {
        $state = $_POST['State'];
    } 
    else {
        $message['State'] = '<p><font color="red">You must enter the State.</font><p>';
    }
    
    if (
            isset($_POST['ZipCode']) && 
//            $_POST['ZipCode'] != "Zip Code" && 
            $_POST['ZipCode'] != "") {
        $zip = $_POST['ZipCode'];
    } 
    else {
        $message['ZipCode'] = '<p><font color="red">You must enter the Zip Code.</font></p>';
    }
    
    if (
            isset($_POST['Country']) && 
//            $_POST['Country'] != "Country" && 
            $_POST['Country'] != "") {
        $country = $_POST['Country'];
    } else {
        $message['Country'] = '<p><font color="red">You must enter the Country.</font></p>';
    }
    
    if (
            isset($_POST['PatientFirstName']) && 
//            $_POST['PatientFirstName'] != "Patient First Name" && 
            $_POST['PatientFirstName'] != "") {
        $patientFirstName = $_POST['PatientFirstName'];
    } 
    else {
        $message['PatientFirstName'] = '<p><font color="red">You must enter the Patient First Name.</font></p>';
    }
    
    if (
            isset($_POST['PatientLastName']) && 
//            $_POST['PatientLastName'] != "Patient Last Name" && 
            $_POST['PatientLastName'] != "") {
        $patientLastName = $_POST['PatientLastName'];
    } 
    else {
        $message['PatientLastName'] = '<p><font color="red">You must enter the Patient Last Name.</font><p>';
    }
    
    if (
            isset($_POST['PatientRelation']) && 
//            $_POST['PatientRelation'] != "Patient Relation" && 
            $_POST['PatientRelation'] != "") {
        $patientRelation = $_POST['PatientRelation'];
    } else {
        $message['PatientRelation'] = '<p><font color="red">You must enter the Patient Relation.</font></p>';
    }
    
    if (
            isset($_POST['PatientDOB']) && 
//            $_POST['PatientDOB'] != "Patient Date Of Birth" && 
            $_POST['PatientDOB'] != "") {
        $patientDateOfBirth = $_POST['PatientDOB'];
    } else {
        $message['PatientDOB'] = '<p><font color="red">You must enter the Patient Date of Birth.</font></p>';
    }
    
    if (
            isset($_POST['PatientDiagnosis']) && 
//            $_POST['PatientDiagnosis'] != "Patient Diagnosis" && 
            $_POST['PatientDiagnosis'] != "") {
        $patientFormPDF = $_POST['PatientDiagnosis'];
    } else {
        $patientFormPDF = "";
    }
    
    if (
            isset($_POST['PatientNote']) && 
//            $_POST['PatientNote'] != "Patient's Notes" && 
            $_POST['PatientNote'] != "") {
        $patientNote = $_POST['PatientNote'];
    } else {
        $patientNote = "";
    }
    
    if (
            isset($_POST['swNote']) && 
//            $_POST['swNote'] != "Notes from Social Worker" && 
            $_POST['swNote'] != "") {
        $profileActityNotes = $_POST['swNote'];
    } else {
        $profileActityNotes = "";
    }
//                      print_r($message);
//                      var_dump($message);                               

    if (!empty($message)) {
//            echo "Cannot create New Profile" . "<br/>";
//            
//            foreach ($message as $messages){
//                echo $messages . "<br/>";               
//            }
    } else if (empty($message)) {
        //TODO: Create familyProfile object.
        $temporaryFamilyProfile = new Family(
                0,                          //$familyProfileId, 
                "Pending",                  //$familyProfileStatus, 
                $parentFirstName, 
                $parentLastName, 
                $parentEmail, 
                $phone1,              //
                $phone2, 
                $address, 
                $city, 
                $state, 
                $zip, 
                $country, 
                $patientFirstName, 
                $patientLastName, 
                $patientRelation, 
                date($patientDateOfBirth), 
                $patientFormPDF, 
                $patientNote);
        
        //TODO: Insert familyProfile object.
        if(insert_FamilyProfile($temporaryFamilyProfile)) 
            echo '
                <div id="container">
                    <div id="content">
                        <p>Temporary family profile inserted successfully.</p>
                    </div>
                </div>';
        //TODO: Get familyProfileID from the familyProfile object.
        
        $results = retrieve_FamilyProfileByName($temporaryFamilyProfile->get_parentfname(), $temporaryFamilyProfile->get_parentlname());
        $resultsFamily = $results[0];
        $temporaryFamilyProfileID = $resultsFamily->get_familyProfileId();
        
        //TODO: Set the profileActivity to the familyprofile's values.
        //no error messages
        //create profile activity object
        
        $current_activity = new ProfileActivity(
                0,                          //$profileActivityId
                0,                          //$profileActivityRequestId
                $temporaryFamilyProfileID,    //$familyProfileId
                    //requestID set to 0 as placeholders.         
                    //TODO: change this!
                $sw_id,                     //
                $sw_lname,                  //
                $sw_fname,                  //
                0,                          //$rmhStaffProfileId
                "",                         //$rmhStaffLastName
                "",                         //$rmhStaffFirstName
                $dateSubmit,                //$swDateStatusSubm
                0,                          //$rmhDateStatusSubm
                $activityType,              //
                $profileActitivityStatus,   //
                $parentFirstName,           //
                $parentLastName,            //
                $parentEmail,               //
                $phone1,                    //
                $phone2,                    //
                $address,                   //
                $city,                      //
                $state,                     //
                $zip,                       //
                $country,                   //
                $patientFirstName,          //
                $patientLastName,           //
                $patientRelation,           //
                $patientDateOfBirth,        //
                $patientFormPDF,            //
                $patientNote,               //
                $profileActityNotes         //
        );

//            print_r($message);
//            var_dump($message);
        // check if insert function returns true, then insert profileactivity                     
        
        if (insert_ProfileActivity($current_activity)) {
            echo '
                <div id="container">
                    <div id="content">
                        <p>Successfully inserted a profile activity request.</p>
                    ';

//            //if profileActivity is inserted, send the email to rmh approver
//            $profileID = $current_activity->get_profileActivityId();
//            NewFamilyProfile($profileID);
            
            $_SESSION['familyID'] = $temporaryFamilyProfileID;
            echo '
                        <p><a href="' . BASE_DIR . '/referralForm.php">Create Room Reservation</a></p>
                    </div>
                </div>';
        }
    }
}//end of success validation of tokens
else if (isset($_POST['form_token']) && !validateTokenField($_POST)) {
    //if the security validation failed. display/store the error
    //'The request could not be completed security check failed!'
    echo "The request could not be completed.";
}
?>

<div id="container">

    <div id="content">

        <form name ="newProfileForm" method="post" action="newProfile.php">
<?php echo generateTokenField(); ?>

            <div>                         
                <th colspan="2"> <h2> New Family Profile Form </h2></th>
            </div>

            <div>
<?php
if (!empty($message)) {
    echo "Cannot create New Profile: " . "</br>";
    foreach ($message as $messages) {
        echo $messages;
    }
}
?>
            </div>

            <div>
                <input class="formtop formt" 
                       type="text" 
                       name="ParentFirstName" 
                       onfocus="if(this.value == 'Parent First Name') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Parent First Name'; }"
                       value ="Parent First Name"
                       <?php isset($parentFirstName) ? print ("value=\"$parentFirstName\"") : print("");?>
                       />
            
                <input class="formt" 
                       type="text" 
                       name="ParentLastName" 
                        onfocus="if(this.value == 'Parent Last Name') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Parent Last Name'; }" value="Parent Last Name"                       <?php isset($parentLastName) ? print ("value=\"$parentLastName\"") : print("");?>
                       />
            
                <input class="formt" 
                       type="text" 
                       name="Email" 
                       onfocus="if(this.value == 'Parent Email Address') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Parent Email Address'; }" value="Parent Email Address"
                       <?php isset($parentEmail) ? print ("value=\"$parentEmail\"") : print("");?>            
                       />
                
                <input class="formt" 
                       type="text" 
                       name="Phone1" 
                       onfocus="if(this.value == 'Parent\'s Primary Phone Number') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Parent\'s Primary Phone Number'; }" value="Parent's Primary Phone Number"
                       <?php isset($phone1) ? print ("value=\"$phone1\"") : print("");?>
                       />
                
                <input class="formt" 
                       type="text" 
                       name="Phone2" 
                       onfocus="if(this.value == 'Parent\'s Secondary Phone Number') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Parent\'s Secondary Phone Number'; }" value="Parent's Secondary Phone Number"
                       <?php isset($phone2) ? print ("value=\"$phone2\"") : print("");?>
                       />
            
                <input class="formt" 
                       type="text" 
                       name="Address" 
                       onfocus="if(this.value == 'Address') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Address'; }" value="Address"
                       <?php isset($address) ? print ("value=\"$address\"") : print("");?>
                       />
                
                <input class="formt" 
                       type="text" 
                       name="City" 
                       onfocus="if(this.value == 'City') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'City'; }" value="City"
                       <?php isset($city) ? print ("value=\"$city\"") : print("");?>
                       />
                
                <input class="formt" 
                       type="text" 
                       name="State" 
                       onfocus="if(this.value == 'State') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'State'; }" value="State"
                       <?php isset($state) ? print ("value=\"$state\"") : print("");?>
                       />
                
                <input class="formt"  
                       type="text" 
                       name="ZipCode" 
                       onfocus="if(this.value == 'Zipcode') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Zipcode'; }" value="Zipcode"
                       <?php isset($zip) ? print ("value=\"$zip\"") : print("");?>        
                       />
            
                <input class="formt" 
                       type="text" 
                       name="Country" 
                       onfocus="if(this.value == 'Country') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Country'; }" value="Country"
                       <?php isset($country) ? print ("value=\"$country\"") : print("");?>
                       />

                <input class="formt" 
                       type="text" 
                       name="PatientFirstName" 
                       onfocus="if(this.value == 'Patient\'s First Name') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Patient\'s First Name'; }" value="Patient's First Name"
                       <?php isset($patientFirstName) ? print ("value=\"$patientFirstName\"") : print("");?>
                       />

                <input class="formt" 
                       type="text" 
                       name="PatientLastName" 
                       onfocus="if(this.value == 'Patient\'s Last Name') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Patient\'s Last Name'; }" value="Patient's Last Name"
                       <?php isset($patientLastName) ? print ("value=\"$patientLastName\"") : print("");?>
                       />

                <input class="formt"  
                       type="text" 
                       name="PatientRelation" 
                       onfocus="if(this.value == 'Patient\'s Relationship Toward Parent') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Patient\'s Relationship Toward Parent'; }" value="Patient's Relationship Toward Parent"
                       <?php isset($patientRelation) ? print ("value=\"$patientRelation\"") : print("");?>                    
                       />

                <input class="formt"
                       type="date"
                       name="PatientDOB"
                       onfocus="if(this.value == 'Patient\'s Date of Birth') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Patient\'s Date of Birth'; }" value="Patient\'s Date of Birth"
                       <?php // isset($patientDateOfBirth) ? print ("value=\"$patientDateOfBirth\"") : print("");?>
                       />

                <input class="formt" 
                       type="text" 
                       name="PatientDiagnosis" 
                       onfocus="if(this.value == 'Patient\'s Current Diagnosis') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Patient\'s Current Diagnosis'; }" value="Patient's Current Diagnosis"
                       <?php isset($patientFormPDF) ? print ("value=\"$patientFormPDF\"") : print("");?>
                       />

                <input class="formt" 
                       type="text" 
                       name="PatientNote" 
                       onfocus="if(this.value == 'Notes on Patient') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Notes on Patient'; }" value="Notes on Patient"
                       <?php isset($patientNote) ? print ("value=\"$patientNote\"") : print("");?>
                       />

                <input class="formt formbottom" 
                       type="text" 
                       name="swNote" 
                       onfocus="if(this.value == 'Anything you would like to note') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Anything you would like to note'; }" value="Anything you would like to note"

                       <?php isset($profileActityNotes) ? print ("value=\"$profileActityNotes\"") : print("");?>
                       />
            </div>

            <div>                        
                <input class="formsubmit" 
                       type="submit" 
                       name="submit" 
                       value="Create New Profile"
                       />
            </div>

        </form>
        <br><br><br>
        <input class="helpbutton" type="submit" value="Help" align="bottom" onclick="location.href='../help/CreatingFamilyProfile.php'" />

</div>

<?php
include (ROOT_DIR . '/footer.php');
//include the footer file, this contains the proper </body> and </html> ending tag.
?>