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


//get family values from database to fill into form
if (isset($_GET['family'])) {
    $familyID = sanitize($_GET['family']);
    $family = retrieve_FamilyProfile($familyID);
    $parentfname = $family->get_parentfname();
    $parentlname = $family->get_parentlname();
    $parentemail = $family->get_parentemail();
    $parentphone1 = $family->get_parentphone1();
    $parentphone2 = $family->get_parentphone2();
    $parentAddr = $family->get_parentaddress();
    $parentcity = $family->get_parentcity();
    $parentstate = $family->get_parentstate();
    $parentzip = $family->get_parentzip();
    $parentcountry = $family->get_parentcountry();
    $patientfname = $family->get_patientfname();
    $patientlname = $family->get_patientlname();
    $patientRelation = $family->get_patientRelation();
    $patientdob = $family->get_patientdob();
    $patientDiagnosis = $family->get_patientformpdf();
    $patientnotes = $family->get_patientnotes();
    setFamilyID($familyID);
} else {
    $family = retrieve_FamilyProfile($_SESSION['familyID']);
    $parentfname = $family->get_parentfname();
    $parentlname = $family->get_parentlname();
    $parentemail = $family->get_parentemail();
    $parentphone1 = $family->get_parentphone1();
    $parentphone2 = $family->get_parentphone2();
    $parentAddr = $family->get_parentaddress();
    $parentcity = $family->get_parentcity();
    $parentstate = $family->get_parentstate();
    $parentzip = $family->get_parentzip();
    $parentcountry = $family->get_parentcountry();
    $patientfname = $family->get_patientfname();
    $patientlname = $family->get_patientlname();
    $patientRelation = $family->get_patientRelation();
    $patientdob = $family->get_patientdob();
    $patientDiagnosis = $family->get_patientformpdf();
    $patientnotes = $family->get_patientnotes();
}


if (isset($_POST['form_token']) && validateTokenField($_POST)) {
    $activityType = "Edit";
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

    if (isset($_GET['familyID'])) {
        $parentfname = $family->get_parentfname();
        $parentlname = $family->get_parentlname();
        $parentemail = $family->get_parentemail();
        $parentphone1 = $family->get_parentphone1();
        $parentphone2 = $family->get_parentphone2();
        $parentAddr = $family->get_parentaddress();
        $parentcity = $family->get_parentcity();
        $parentstate = $family->get_parentstate();
        $parentzip = $family->get_parentzip();
        $parentcountry = $family->get_parentcountry();
        $patientfname = $family->get_patientfname();
        $patientlname = $family->get_patientlname();
        $patientRelation = $family->get_patientRelation();
        $patientdob = $family->get_patientdob();
        $patientDiagnosis = $family->get_patientformpdf();
        $patientnotes = $family->get_patientnotes();
        setFamilyID($familyID);
    }

    if (
            isset($_POST['ParentFirstName']) &&
            $_POST['ParentFirstName'] != "") {
        $parentFirstName = $_POST['ParentFirstName'];
    }


    if (
            isset($_POST['ParentLastName']) &&
            $_POST['ParentLastName'] != "") {
        $parentLastName = $_POST['ParentLastName'];
    }


    if (
            isset($_POST['Email']) &&
            $_POST['Email'] != "") {
        $parentemail = $_POST['Email'];
    }


    if (
            isset($_POST['Phone1']) &&
            $_POST['Phone1'] != "") {
        $parentphone1 = $_POST['Phone1'];
    }


    if (
            isset($_POST['Phone2']) &&
            $_POST['Phone2'] != "") {
        $parentphone2 = $_POST['Phone2'];
    } else {
        $phone2 = "";
    }

    if (
            isset($_POST['parentAddr']) &&
            $_POST['parentAddr'] != "") {
        $parentAddr = $_POST['parentAddr'];
    }


    if (
            isset($_POST['parentcity']) &&
            $_POST['parentcity'] != "") {
        $parentcity = $_POST['parentcity'];
    }


    if (
            isset($_POST['parentstate']) &&
            $_POST['parentstate'] != "") {
        $parentstate = $_POST['parentstate'];
    }


    if (
            isset($_POST['parentzip']) &&
            $_POST['parentzip'] != "") {
        $parentzip = $_POST['parentzip'];
    }


    if (
            isset($_POST['parentcountry']) &&
            $_POST['parentcountry'] != "") {
        $parentcountry = $_POST['parentcountry'];
    }

    if (
            isset($_POST['PatientFirstName']) &&
            $_POST['PatientFirstName'] != "") {
        $patientFirstName = $_POST['PatientFirstName'];
    }


    if (
            isset($_POST['PatientLastName']) &&
            $_POST['PatientLastName'] != "") {
        $patientLastName = $_POST['PatientLastName'];
    }


    if (
            isset($_POST['PatientRelation']) &&
            $_POST['PatientRelation'] != "") {
        $patientRelation = $_POST['PatientRelation'];
    }

    if (
            isset($_POST['PatientDOB']) &&
            $_POST['PatientDOB'] != "") {
        $patientDateOfBirth = $_POST['PatientDOB'];
    }

    if (
            isset($_POST['PatientDiagnosis']) &&
            $_POST['PatientDiagnosis'] != "") {
        $patientDiagnosis = $_POST['PatientDiagnosis'];
    } else {
        $patientDiagnosis = "";
    }

    if (
            isset($_POST['PatientNote']) &&
            $_POST['PatientNote'] != "") {
        $patientNote = $_POST['PatientNote'];
    } else {
        $patientNote = "";
    }

    if (
            isset($_POST['swNote']) &&
            $_POST['swNote'] != "") {
        $profileActityNotes = $_POST['swNote'];
    } else {
        $profileActityNotes = "";
    }

        //TODO: Create familyProfile object.
        $FamilyProfile = new Family(
                0,                          //$familyProfileId, 
                "Pending",                  //$familyProfileStatus, 
                $parentFirstName, 
                $parentLastName, 
                $parentemail, 
                $parentphone1,              //
                $parentphone2, 
                $parentAddr,
                $parentcity, 
                $parentstate, 
                $parentzip, 
                $parentcountry, 
                $patientFirstName, 
                $patientLastName, 
                $patientRelation, 
                date($patientDateOfBirth), 
                $patientDiagnosis, 
                $patientNote);
        
        //TODO: Insert familyProfile object.
        $RequestKey = update_FamilyProfile($FamilyProfile);
        if($RequestKey)
            echo '
                <div id="container" >
                    <div id="content" >
                        <p align=center>Family profile updated successfully.</p>
                    </div>
                </div>';
    // Get familyProfileID from the familyProfile object.

    $results = retrieve_FamilyProfileByName($FamilyProfile->get_parentfname(), $FamilyProfile->get_parentlname());
    $resultsFamily = $results[0];
    $FamilyProfileID = $resultsFamily->get_familyProfileId();

    //Set the profileActivity to the familyprofile's values.
    
    //create profile activity object

    $current_activity = new ProfileActivity(
                    0, //$profileActivityId
                    0, //$profileActivityRequestId
                    $FamilyProfileID, //$familyProfileId
                    //requestID set to 0 as placeholders.         
                    //TODO: change this!
                    $sw_id, //
                    $sw_lname, //
                    $sw_fname, //
                    0, //$rmhStaffProfileId
                    "", //$rmhStaffLastName
                    "", //$rmhStaffFirstName
                    $dateSubmit, //$swDateStatusSubm
                    0, //$rmhDateStatusSubm
                    $activityType, //
                    $profileActitivityStatus, //
                    $parentFirstName, //
                    $parentLastName, //
                    $parentemail, //
                    $parentphone1, //
                    $parentphone2, //
                    $parentAddr, //
                    $parentcity, //
                    $parentstate, //
                    $parentzip, //
                    $parentcountry, //
                    $patientFirstName, //
                    $patientLastName, //
                    $patientRelation, //
                    $patientDateOfBirth, //
                    $patientDiagnosis, //
                    $patientNote, //
                    $profileActityNotes         //
    );


    // check if insert function returns true, then insert profileactivity                     

        // check if insert function returns true, then insert profileactivity                     
        
        if (insert_ProfileActivity($current_activity)) {
            echo '
                <div id="container" >
                    <div id="content">
                 <form id="informationForm" style="visibility:hidden">
                <div id="success" align=center>
                        <p>Successfully updated family profile.</p>
                 </div>
                 </form>
                 </div>
                </div>
                    ';
           
            // sending email about Request the modification of the Profile
//            newFamilyMod($RequestKey, $dateSubmit, $FamilyProfileID);
          
//            //if profileActivity is inserted, send the email to rmh approver
//            
    }
}//end of success validation of tokens
else if (isset($_POST['form_token']) && !validateTokenField($_POST)) {
    //if the security validation failed. display/store the error
    //'The request could not be completed security check failed!'
    echo "Family Profile could not be updated.";
}
?>

<div id="container">

    <div id="content">

        <form id="informationForm" name ="EditFamilyProfile" method="post" action="EditFamilyProfile.php">
<?php echo generateTokenField(); ?>

            <div>                         
                <th colspan="2"> <h2> Edit Family Profile </h2></th>
            </div>



            <div>
                Parent First Name:<br>                   
                <input class="formtop formt" 
                       type="text" 
                       name="ParentFirstName" 
                       value="<?php echo htmlspecialchars($parentfname); ?>"
                       />
                <br>Parent Last Name:<br>
                <input class="formt" 
                       type="text" 
                       name="ParentLastName" 
                       value="<?php echo htmlspecialchars($parentlname); ?>"
                       />
                <br> Email:<br>
                <input class="formt" 
                       type="text" 
                       name="Email" 
                       value="<?php echo htmlspecialchars($parentemail); ?>"
                       />
                <br>Number of Phone1:<br>
                <input class="formt" 
                       type="text" 
                       name="Phone1" 
                       value="<?php echo htmlspecialchars($parentphone1); ?>"
                       />
                <br>Number of Phone2:<br>
                <input class="formt" 
                       type="text" 
                       name="Phone2" 
                       value="<?php echo htmlspecialchars($parentphone2); ?>"
                       />
                <br>Address:<br>
                <input class="formt" 
                       type="text" 
                       name="parentAddr" 
                       value="<?php echo htmlspecialchars($parentAddr); ?>"
                       />
                <br>City:<br>
                <input class="formt" 
                       type="text" 
                       name="parentcity" 
                       value="<?php echo htmlspecialchars($parentcity); ?>"
                       />
                <br>State:<br>
                <input class="formt" 
                       type="text" 
                       name="parentstate" 
                       value="<?php echo htmlspecialchars($parentstate); ?>"
                       />
                <br>Zip Code:<br>
                <input class="formt" 
                       type="text" 
                       name="parentzip" 
                       value="<?php echo htmlspecialchars($parentzip); ?>"
                       />
                <br>Country:<br>
                <input class="formt"  
                       type="text" 
                       name="parentcountry" 
                       value="<?php echo htmlspecialchars($parentcountry); ?>"      
                       />

                <br>Patient First Name:<br>
                <input class="formt" 
                       type="text" 
                       name="PatientFirstName" 
                       value="<?php echo htmlspecialchars($patientfname); ?>"
                       />
                <br>Patient Last Name:<br>
                <input class="formt" 
                       type="text" 
                       name="PatientLastName" 
                       value="<?php echo htmlspecialchars($patientlname); ?>"
                       />
                <br>Patient Relation:<br>
                <input class="formt"  
                       type="text" 
                       name="PatientRelation" 
                       value="<?php echo htmlspecialchars($patientRelation); ?>"      
                       />
                <br>Patient Date of Birthday: Year-Month-Date<br>
                <input class="formt"
                       type="text"
                       name="PatientDOB"
                       value="<?php echo htmlspecialchars($patientdob); ?>"
                       />
                <br>Diagnosis:<br>
                <input class="formt" 
                       type="text" 
                       name="PatientDiagnosis" 
                       value="<?php echo htmlspecialchars($patientDiagnosis); ?>"
                       />
                <br>Notes:<br>
                <input class="formt" 
                       type="text" 
                       name="PatientNotes" 
                       value="<?php echo htmlspecialchars($patientnotes); ?>"
                       />



            </div>

            <div style="margin-top: 30px" >                     
                <input class="formsubmit" type="submit" name="submit" value="Save Profile"/>
                <input class="helpbutton" type="submit" value="Help" align="bottom" onclick="location.href='../help/SearchingFamilyProfile.php'" />
            </div>

        </form>

    </div>
</div>

<?php
include (ROOT_DIR . '/footer.php');
//include the footer file, this contains the proper </body> and </html> ending tag.
?>
