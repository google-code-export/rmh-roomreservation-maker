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
        //the security validation was successful, perform required operation here below.
        //*** NOTE *** The validateTokenField DOES NOT filter/sanitize/clean the data fields.
        //A separate function sanitize() should be called to clean the data so that it is html/db safe
     
     //Each change in the profilechangeform is a new profile activity type...
     //might create a new function for this...
     $current_activity = new ProfileActivity();
     
        //default types and status of the profileactivity object
        $activityType = "Profile Change";
        $profileActitivityStatus = "Unconfirmed";

        //gets the sw id and the name
        $sw = $_SESSION['id'];
        $sw_name = $sw->get_firstName()." ". $sw->get_lastName();

        $current_activity->socialWorkerProfileID = $sw;
        $current_activity->swDateStatusSubm = date("Y-m-d");
        $current_activity->familyProfileId = $familyID;
        $current_activity->activityType = $activityType;
        $current_activity->profileActivityStatus = $profileActitivityStatus;
        //$current_activity->profileActityNotes = sanitize($_POST["swNote"]) ;
     
            if($_POST['text_parentfname']!= $Profile['parentfname']){
                $newParentFirstName = $sanitize($_POST['text_parentfname']);
            }
    }
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        //if the security validation failed. display/store the error:
        echo "The request could not be completed.";

    }
    else
    {
        //there was no POST DATA
    }
    

    //test the submission of profile change form
    if(($_POST['Modify'] == "submit")){
       
    $need_change = array();
    $n = 0;
    
    if(isset($_POST["ParentFirstName"])){
        $newParentFirstName = $sanitize($_POST['ParentFirstName']);
        $newParentFirstName = $current_change->
        $need_change[n] = $newParentFirstName; 
        $n++;
    }
        if(isset($_POST["ParentLastName"])){
        $newParentLastName = $sanitize($_POST["ParentLastName"]);
        $need_change[n] = $newParentLastName; 
        $n++;
    }
        if(isset($_POST["Email"])){
        $newEmail = $sanitize($_POST["Email"]);
        $need_change[n] = $newEmail; 
        $n++;
    }
     if(isset($_POST["Phone1"])){
        $newPhone = $sanitize($_POST["Phone1"]);
        $need_change[n] = $newPhone; 
        $n++;
    }
    if(isset($_POST["Phone2"])){
        $newPhone2 = $sanitize($_POST["Phone2"]);
        $need_change[n] = $newPhone2; 
        $n++;
    }
     if(isset($_POST["Address"])){
        $newAddress = $sanitize($_POST["Address"]);
        $need_change[n] = $newAddress; 
        $n++;
    }
     if(isset($_POST["City"])){
        $newCity = $sanitize($_POST["City"]);
        $need_change[n] = $newCity; 
        $n++;
    }
    
     if(isset($_POST["State"])){
        $newState = $sanitize($_POST["State"]);
        $need_change[n] = $newState; 
        $n++;
    }
     if(isset($_POST["ZipCode"])){
        $newZipCode = $sanitize($_POST["ZipCode"]);
        $need_change[n] = $newZipCode; 
        $n++;
    }
     if(isset($_POST["PatientFirstName"])){
        $newPatientFirstName = $sanitize($_POST["PatientFirstName"]);
        $need_change[n] = $newPatientFirstName; 
        $n++;
    }
     if(isset($_POST["PatientLastName"])){
        $newPatientLastName = $sanitize($_POST["PatientLastName"]);
        $need_change[n] = $newPatientLastName; 
        $n++;
    }
     if(isset($_POST["PatientRelation"])){
        $newPatientRelation = $sanitize($_POST["PatientRelation"]);
        $need_change[n] = $newPatientRelation; 
        $n++;
    }
     if(isset($_POST["PatientBirthDate"])){
        $newPatientBirthDate = $sanitize($_POST["PatientBirthDate"]);
        $need_change[n] = $newPatientBirthDate; 
        $n++;
    }
     if(isset($_POST["PatientDiagnosis"])){
        $newPatientDiagnosis = $sanitize($_POST["PatientDiagnosis"]);
        $need_change[n] = $newPatientDiagnosis; 
        $n++;
    }

    //message display if user made no changes
    if(empty($need_change)){
        echo("You did not make any changes. ");
    }
    else
    {
        $num_change = count($need_change);
        
        //display the changes
        echo("You made $num_change modification(s): ");
        for ($i = 0; $i < $num_change; $i++){
            echo($need_change[$i]. PHP_EOL);
        }
    } 

    
    }//end of if submit
    ?>

    <div id="container">

    <?php include(ROOT_DIR.'/navigation.php');?>

    <div id="content">
                    
       <form name ="profileChangeForm" method="post" action="newProfile.php">
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
             <label for="notes"> Notes from Social Worker: </label> 
            <input type ="text" name ="text_patientnotes" value="<?php echo $Profile['patientnotes'] ?>" size="20" /><br>
            
            
            
            <input type="submit" name="modify" value="Modify"/>
            
  
           
       </form>

    </div>
</div>

?>

<?php 
include (ROOT_DIR .'footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
?>
