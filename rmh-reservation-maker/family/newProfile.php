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
    $sw_id = $swObject->get_userProfileId();
    $sw_fname = $swObject->get_swFirstName();
    $sw_lname = $swObject->get_swLastName();
    $dateSubmit = date("Y-m-d");

    if (
            isset($_POST['ParentFirstName']) && 
            $_POST['ParentFirstName'] != "Parent First Name" && 
            $_POST['ParentFirstName'] != "") {
        $parentFirstName = $_POST['ParentFirstName'];    
    } 
    else {
        $message['ParentFirstName'] = "Must enter Parent First Name.";
    }
    
    if (
            isset($_POST['ParentLastName']) && 
            $_POST['ParentLastName'] != "Parent Last Name" && 
            $_POST['ParentLastName'] != "") {
        $parentLastName = $_POST['ParentLastName'];
    } 
    else {
        $message['ParentLastName'] = "Must enter Parent Last Name.";
        // print_r($message);
    }
    
    if (
            isset($_POST['Email']) && 
            $_POST['Email'] != "E-Mail" && 
            $_POST['Email'] != "") {
        $parentEmail = $_POST['Email'];
    } 
    else {
        $message['Email'] = "Must enter Email.";
    }
    
    if (
            isset($_POST['Phone1']) && 
            $_POST['Phone1'] != "Phone # 1" && 
            $_POST['Phone1'] != "") {
        $phone1 =$_POST['Phone1'];
    } 
    else {
        $message['Phone1'] = "Must enter Phone1";
        //print_r($message);
    }
    
    if (
            isset($_POST['Phone2']) && 
            $_POST['Phone2'] != "Phone # 2" && 
            $_POST['Phone2'] != "") {
        $phone2 = $_POST['Phone2'];
    } 
    else {
        $phone2 = "";
    }
    
    if (
            isset($_POST['Address']) && 
            $_POST['Address'] != "Address" && 
            $_POST['Address'] != "") {
        $address = $_POST['Address'];
    } 
    else {
        $message['Address'] = "Must enter Address";
    }
    
    if (
            isset($_POST['City']) && 
            $_POST['City'] != "City" && 
            $_POST['City'] != "") {
        $city = $_POST['City'];
    } 
    else {
        $message['City'] = "Must enter City";
    }
    
    if (
            isset($_POST['State']) && 
            $_POST['State'] != "State" && 
            $_POST['State'] != "") {
        $state = $_POST['State'];
    } 
    else {
        $message['State'] = "Must enter State";
    }
    
    if (
            isset($_POST['ZipCode']) && 
            $_POST['ZipCode'] != "Zip Code" && 
            $_POST['ZipCode'] != "") {
        $zip = $_POST['ZipCode'];
    } 
    else {
        $message['ZipCode'] = "Must enter Zip Code";
    }
    
    if (
            isset($_POST['Country']) && 
            $_POST['Country'] != "Country" && 
            $_POST['Country'] != "") {
        $country = $_POST['Country'];
    } else {
        $message['Country'] = "Must enter Country";
    }
    
    if (
            isset($_POST['PatientFirstName']) && 
            $_POST['PatientFirstName'] != "Patient First Name" && 
            $_POST['PatientFirstName'] != "") {
        $patientFirstName = $_POST['PatientFirstName'];
    } 
    else {
        $message['PatientFirstName'] = "Must enter Patient First Name.";
    }
    
    if (
            isset($_POST['PatientLastName']) && 
            $_POST['PatientLastName'] != "Patient Last Name" && 
            $_POST['PatientLastName'] != "") {
        $patientLastName = $_POST['PatientLastName'];
    } 
    else {
        $message['PatientLastName'] = "Must enter Patient Last Name";
    }
    
    if (
            isset($_POST['PatientRelation']) && 
            $_POST['PatientRelation'] != "Patient Relation" && 
            $_POST['PatientRelation'] != "") {
        $patientRelation = $_POST['PatientRelation'];
    } else {
        $message['PatientRelation'] = " Must enter Patient Relation.";
    }
    
    if (
            isset($_POST['PatientDOB']) && 
            $_POST['PatientDOB'] != "Patient Date Of Birth" && 
            $_POST['PatientDOB'] != "") {
        $patientDateOfBirth = $_POST['PatientDOB'];
    } else {
        $message['PatientDOB'] = "Must enter Patient Date of Birth (yyyy-mm-dd).";
    }
    
    if (
            isset($_POST['PatientDiagnosis']) && 
            $_POST['PatientDiagnosis'] != "Patient Diagnosis" && 
            $_POST['PatientDiagnosis'] != "") {
        $patientFormPDF = $_POST['PatientDiagnosis'];
    } else {
        $patientFormPDF = "";
    }
    
    if (
            isset($_POST['PatientNote']) && 
            $_POST['PatientNote'] != "Patient's Notes" && 
            $_POST['PatientNote'] != "") {
        $patientNote = $_POST['PatientNote'];
    } else {
        $patientNote = "";
    }
    
    if (
            isset($_POST['swNote']) && 
            $_POST['swNote'] != "Notes from Social Worker" && 
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
        //no error messages
        //create profile activity object
        $current_activity = new ProfileActivity(0, 0, 0, $sw_id, $sw_lname, $sw_fname, //familyID and requestID set to 0 as placeholders. 
                        0, "", "", $dateSubmit, 0, $activityType, $profileActitivityStatus,
                        $parentFirstName, $parentLastName, $parentEmail, $phone1, $phone2,
                        $address, $city, $state, $zip,
                        $country, $patientFirstName, $patientLastName, $patientRelation,
                        $patientDateOfBirth, $patientFormPDF, $patientNote, $profileActityNotes);

//            print_r($message);
//            var_dump($message);
        // check if insert function returns true, then insert profileactivity                     
        if (insert_ProfileActivity($current_activity)) {
            echo "Successfully inserted a profile activity request" . "<br/>";

            //if profileActivity is inserted, send the email to rmh approver
            $profileID = $current_activity->get_profileActivityId();
            NewFamilyProfile($profileID);

            //Need to pass the familyID to room reservation script 
            echo '<a href="' . BASE_DIR . '/referralForm.php">Create Room Reservation</a>' . "\n";
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
        echo $messages . "<br/>";
    }
}
?>
            </div>

            <div>
                <input class="formtop formt" 
                       type="text" 
                       name="ParentFirstName" 
                       placeholder="Parent first name"
                       <?php isset($parentFirstName) ? print ("value=\"$parentFirstName\"") : print("");?>
                       size="40" 
                       />
            </div>
            
            <div>

                <input class="formt" 
                       type="text" 
                       name="ParentLastName" 
                       placeholder="Parent last name"
                       <?php isset($parentLastName) ? print ("value=\"$parentLastName\"") : print("");?>
                       size="40" 
                       />
            </div>
            
            <div>
                <input class="formt" 
                       type="text" 
                       name="Email" 
                       placeholder="Parent's email address"
                       <?php isset($parentEmail) ? print ("value=\"$parentEmail\"") : print("");?>
                       size="40" 
                       />
            </div>
            
            <div>
                <input class="formt" 
                       type="text" 
                       name="Phone1" 
                       placeholder="Parent's primary phone number"
                       <?php isset($phone1) ? print ("value=\"$phone1\"") : print("");?>
                       size="40" 
                       />
            </div>
            
            <div>
                <input class="formt" 
                       type="text" 
                       name="Phone2" 
                       placeholder="Parent's secondary phone number"
                       <?php isset($phone2) ? print ("value=\"$phone2\"") : print("");?>
                       size="40" 
                       />
            </div>
            
            <div>
                <input class="formt" 
                       type="text" 
                       name="Address" 
                       placeholder="Address"
                       <?php isset($address) ? print ("value=\"$address\"") : print("");?>
                       size="40" 
                       />
            </div>
            
            <div>
                <input class="formt" 
                       type="text" 
                       name="City" 
                       placeholder="City"
                       <?php isset($city) ? print ("value=\"$city\"") : print("");?>
                       size="40" 
                       />
            </div>
            
            <div>
                <input class="formt" 
                       type="text" 
                       name="State" 
                       placeholder="State"
                       <?php isset($state) ? print ("value=\"$state\"") : print("");?>
                       size="40" 
                       />
            </div>
            
            <div>
                <input class="formt"  
                       type="text" 
                       name="ZipCode" 
                       placeholder="ZipCode"
                       <?php isset($zip) ? print ("value=\"$zip\"") : print("");?>
                       size="40" 
                       />
            </div>

            
            <input class="formt" 
                   type="text" 
                   name="Country" 
                   placeholder="Country"
                   <?php isset($country) ? print ("value=\"$country\"") : print("");?>
                   size="40" 
                   />
            

            <input class="formt" 
                   type="text" 
                   name="PatientFirstName" 
                   placeholder="Patient's first name"
                   <?php isset($patientFirstName) ? print ("value=\"$patientFirstName\"") : print("");?>
                   size="40" 
                   />


            <input class="formt" 
                   type="text" 
                   name="PatientLastName" 
                   placeholder="Patient's last name"
                   <?php isset($patientLastName) ? print ("value=\"$patientLastName\"") : print("");?>
                   size="40" 
                   />


            <input class="formt"  
                   type="text" 
                   name="PatientRelation" 
                   placeholder="Parent's relationship toward patient"
                   <?php isset($patientRelation) ? print ("value=\"$patientRelation\"") : print("");?>
                   size="40" 
                   />


            <input class="formt" 
                   type="text" 
                   name="PatientDOB" 
                   placeholder="Patient's Date of Birth (yyyy-mm-dd)"
                   <?php isset($patientDateOfBirth) ? print ("value=\"$patientDateOfBirth\"") : print("");?>
                   size="40" 
                   />


            <input class="formt" 
                   type="text" 
                   name="PatientDiagnosis" 
                   placeholder="Patient's current diagnosis"
                   <?php isset($patientFormPDF) ? print ("value=\"$patientFormPDF\"") : print("");?>
                   size="40" 
                   />
            
            
            <input class="formt" 
                   type="text" 
                   name="PatientNote" 
                   placeholder="Notes on patient"
                   <?php isset($patientNote) ? print ("value=\"$patientNote\"") : print("");?>
                   size="40" 
                   />
        
        <input class="formt formbottom" 
               type="text" 
               name="swNote" 
               placeholder="Anything you would like to note"
               <?php isset($profileActityNotes) ? print ("value=\"$profileActityNotes\"") : print("");?>
               size="40"/>
    </div>
    
    <div>                        
        <input class="formsubmit" 
               type="submit" 
               name="submit" 
               value="Create New Profile"
               />
    </div>

</form>
        <input class="helpbutton" type="submit" value="Help" align="bottom" onclick="location.href='../help/CreatingFamilyProfile.php'" />

</div>

<?php
include (ROOT_DIR . '/footer.php');
//include the footer file, this contains the proper </body> and </html> ending tag.
?>

