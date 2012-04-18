<?php
/**
 * @author Jessica Cheong
 * 
 * Profile Change Request handler page
 * 
 * This page deals with the profile change function. When the SW creates a room reservation, and there is
 * a need to modify an existing family profile. This is the page that would direct the SW to make the
 * appropriate change. The change would be stored in a different table until the data is verfied by the
 * RMH approver. This activity is stored for future references. 
 */

session_start();
session_cache_expire(30);

$title = "Family Profile Change Request";

include('../header.php');

include_once(ROOT_DIR .'domain/UserProfile.php');
include_once(ROOT_DIR .'domain/ProfileChange.php');
include_once(ROOT_DIR .'database/dbProfileActivity.php');
include_once(ROOT_DIR .'database/dbUserProfile.php');
include_once(ROOT_DIR .'mail/functions.php');

       //gets the family profileID and retrieves the fields into an array to validate the input changes
       //and to display in the html form
        if(isset($_GET['family']) ){
            $familyID = sanitize($_GET['family']);
            
            $Profile = array();
            $familyProfile = retrieve_dbFamilyProfile($familyID);
            $Profile['parentfname']=$familyProfile->get_parentfname();
            $Profile['parentlname']=$familyProfile->get_parentlname();
            $Profile['parentemail']=$familyProfile->get_parentemail();
            $Profile['parentphone1']=$familyProfile->get_parentphone1();
            $Profile['parentphone2']=$familyProfile->get_parentphone2();
            $Profile['parentAddr']=$familyProfile->get_parentaddress();
            $Profile['parentcity']=$familyProfile->get_parentcity();
            $Profile['parentstate']=$familyProfile->get_parentstate();
            $Profile['parentzip']=$familyProfile->get_parentzip();
            $Profile['parentcountry']=$familyProfile->get_parentcountry();
            $Profile['patientfname']=$familyProfile->get_patientfname();
            $Profile['patientlname']=$familyProfile->get_patientlname();
            $Profile['patientrelation']=$familyProfile->get_patientrelation();
            $Profile['patientdob']=$familyProfile->get_patientdob();
            $Profile['patientformpdf']=$familyProfile->get_patientformpdf();
            $Profile['patientnotes']=$familyProfile->get_patientnotes();
        }

 if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        $current_activity = new ProfileActivity();
     
        //default types and status of the profileactivity object
        $activityType = "Modify";
        $profileActitivityStatus = "Unconfirmed";

        //gets the sw id and the name
        $sw = $_SESSION['id'];
        $sw_name = $sw->get_firstName()." ". $sw->get_lastName();
        $dateSubmit = date("Y-m-d");
        
        $current_activity->socialWorkerProfileID = $sw;
        $current_activity->swDateStatusSubm = $dateSubmit;
        $current_activity->familyProfileId = $familyID;
        $current_activity->activityType = $activityType;
        $current_activity->profileActivityStatus = $profileActitivityStatus;
        $current_activity->profileActityNotes = sanitize($_POST["swNote"]) ;
     
        //comparing old family profile record with new data
        //if nothing is changed, then $change remains false and the request would not be inserted
        $change = false;
            
            if($_POST['text_parentfname']!= $Profile['parentfname']){
                $newParentFirstName = $sanitize($_POST['text_parentfname']);
                $current_activity->parentFirstName = $newParentFirstName;
                $change = true;
            }
            if($_POST['text_parentlname']!= $Profile['parentlname']){
                $newParentLastName = $sanitize($_POST['text_parentlname']);
                $current_activity->parentLastName = $newParentLastName;
                 $change = true;
            }
            if($_POST['text_parentemail']!= $Profile['parentemail']){
                 $newEmail = $sanitize($_POST['text_parentemail']);
                 $current_activity->parentEmail = $newEmail; 
                  $change = true;
            }
            if($_POST['text_parentphone1']!= $Profile['parentphone1']){
                $newPhone1 = $sanitize($_POST['text_parentphone1']);
                $current_activity->parentPhone1 = $newPhone1; 
                 $change = true;
            }
            if($_POST['text_parentphone2']!= $Profile['parentphone2']){
                $newPhone2 = $sanitize($_POST['text_parentphone2']);
                 $current_activity->parentPhone2 = $newPhone2; 
                  $change = true;
            }
            if($_POST['text_parentAddr']!= $Profile['parentAddr']){
                $newAddress = $sanitize($_POST['text_parentAddr']);
                $current_activity->parentAddress = $newAddress; 
                 $change = true;
            }
            if($_POST['text_parentcity']!= $Profile['parentcity']){
                $newCity = $sanitize($_POST['text_parentcity']);
                $current_activity->parentCity = $newCity; 
                 $change = true;
            }
            if($_POST['text_parentstate']!= $Profile['parentstate']){
                $newState = $sanitize($_POST['text_parentstate']);
                $current_activity->parentState = $newState; 
                 $change = true;
            }
            if($_POST['text_parentzip']!= $Profile['parentzip']){
                $newZipCode = $sanitize($_POST['text_parentzip']);
                $current_activity->parentZip = $newZipCode; 
                 $change = true;
            }
            if($_POST['text_parentcountry']!= $Profile['parentcountry']){
                $newCountry = $sanitize($_POST['text_parentcountry']);
                $current_activity->parentCountry = $newCountry;
                 $change = true;
            }
             if($_POST['text_patientfname']!= $Profile['patientfname']){
                $newPatientFirstName = $sanitize($_POST['text_patientfname']);
                $current_activity->patientFirstName = $newPatientFirstName;
                 $change = true;
            }
             if($_POST['text_patientlname']!= $Profile['patientlname']){
                $newPatientLastName = $sanitize($_POST['text_patientlname']);
                $current_activity->patientLastName = $newPatientLastName;
                 $change = true;
            }
             if($_POST['text_patientrelation']!= $Profile['patientrelation']){
                $newPatientRelation = $sanitize($_POST['text_patientrelation']);
                  $current_activity->patientRelation = $newPatientRelation;
                   $change = true;
            }
             if($_POST['text_patientdob']!= $Profile['patientdob']){
                $newPatientBirthDate = $sanitize($_POST['text_patientdob']);
                $current_activity->patientDOB = $newPatientBirthDate;
                 $change = true;
            }
             if($_POST['text_patientformpdf']!= $Profile['patientformpdf']){
                $newPatientDiagnosise = $sanitize($_POST['text_patientformpdf']);
                $current_activity->formPdf = $newPatientDiagnosise;
                 $change = true;
            }
            if($_POST['text_patientnotes']!= $Profile['patientnotes']){
                $newPatientNotes = $sanitize($_POST['text_patientnotes']);
                $current_activity->familyNotes = $newPatientNotes;
                 $change = true;
            }
            
           if ($change == true){
            insert_ProfileActivity($current_activity);
           }
        /*
        EMAIL
                     
        call email function to send unconfirmed status email to rmh staff
        what should the requestkey be??
        */
           
        $RequestKey = $current_activity.get_profileActivityRequestId();
         
        newFamilyMod($RequestKey, $dateSubmit);
         
    } //end of success token validation
    
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        //if the security validation failed. display/store the error:
        echo "The request could not be completed.";

    }
    else
    {
        echo "Unexpected Error";
    }

    ?>

    <div id="container">

    <?php include(ROOT_DIR.'/navigation.php');?>

    <div id="content">
                    
       <form name ="profileChangeForm" method="post" action="profileChange.php">
            <?php echo generateTokenField(); ?>    
           
            <label for="parentFname">Parent First Name: </label>
            <input type ="text" name ="text_parentfname" value="<?php echo $Profile['parentfname'] ?>" size="20" /><br>
          
            <label for="parentLname">Parent Last Name: </label>
            <input type ="text" name ="text_parentlname" value="<?php echo $Profile['parentlname'] ?>" size="20" /><br>
                        
            <label for="email"> Email: </label> 
            <input type ="text" name ="text_parentemail" value="<?php echo $Profile['parentemail'] ?>" size="20" /><br>
            
            <label for="phone1"> Phone1: </label> 
            <input type ="text" name ="text_parentphone1" value="<?php echo $Profile['parentphone1'] ?>" size="20" /><br>
            <label for="phone2"> Phone2: </label> 
            <input type ="text" name ="text_parentphone2" value="<?php echo $Profile['parentphone2'] ?>" size="20" /><br>
            <label for="address"> Address: </label> 
            <input type ="text" name ="text_parentAddr" value="<?php echo $Profile['parentAddr'] ?>" size="20" /><br>
            <label for="city"> City: </label> 
            <input type ="text" name ="text_parentcity" value="<?php echo $Profile['parentcity'] ?>" size="20" /><br>
            <label for="state"> State: </label> 
            <input type ="text" name ="text_parentstate" value="<?php echo $Profile['parentstate'] ?>" size="20" /><br>
             <label for="zip"> Zip Code: </label> 
            <input type ="text" name ="text_parentzip" value="<?php echo $Profile['parentzip'] ?>" size="20" /><br>
             <label for="country"> Country: </label> 
            <input type ="text" name ="text_parentcountry" value="<?php echo $Profile['parentcountry'] ?>" size="20" /><br>
            <label for="patientfname"> Patient First Name: </label> 
            <input type ="text" name ="text_patientfname" value="<?php echo $Profile['patientfname'] ?>" size="20" /><br> 
            <label for="patientlname"> Patient Last Name: </label> 
            <input type ="text" name ="text_patientlname" value="<?php echo $Profile['patientlname'] ?>" size="20" /><br>
             <label for="patientrelation"> Patient Relation: </label> 
            <input type ="text" name ="text_patientrelation" value="<?php echo $Profile['patientrelation'] ?>" size="20" /><br>
             <label for="dob"> Patient Day Of Birth: </label> 
            <input type ="text" name ="text_patientdob" value="<?php echo $Profile['patientdob'] ?>" size="20" /><br>
             <label for="pdf"> Patient Diagnosis: </label> 
            <input type ="text" name ="text_patientformpdf" value="<?php echo $Profile['patientformpdf'] ?>" size="20" /><br>
             <label for="notes"> Patient's Notes: </label> 
            <input type ="text" name ="text_patientnotes" value="<?php echo $Profile['patientnotes'] ?>" size="20" /><br>
            
            <label for="swnotes"> Notes from Social Worker: </label> 
            <input type ="text" name ="text_swnotes" value="" size="20" /><br>
            
            
            
            <input type="submit" name="modify" value="Modify"/>
            
  
           
       </form>

    </div>
</div>

?>

<?php 
include (ROOT_DIR .'footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
?>
