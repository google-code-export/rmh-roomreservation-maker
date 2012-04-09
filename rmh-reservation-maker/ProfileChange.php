<?php
/**
 * @author Jessica Cheong
 * 
 * Profile Change Request page
 * 
 * This page deals with the profile change function. When the SW creates a room reservation, and there is
 * a need to modify an existing family profile. This is the page that would direct the SW to make the
 * appropriate change. The change would be stored in a different table until the data is verfied by the
 * RMH approver. This activity is stored for future references. 
 */

session_start();
session_cache_expire(30);

$title = "Family Profile Modification";

include('header.php');

//includes the database and domain scripts 
include_once('domain/ProfileChange.php');
include_once('domain/UserProfile.php');
include_once('database/dbinfo.php');


/*
    //retrieves a record of the targeted family profile
    $familyProfileID = $_GET['familyProfile'];
    //sets currentFamily to get the family profile
    $currentFamily = retrieve_family_profile($familyProfileID); // domain object function               
   
        //checks if the profile is valid 
        if ($currentFamily instanceof familyProfile){ 
            
*/  
    /*
     * Until the room reservation is done. 
    $sw = $_SESSION['id'];
    $name = (get_firstName()." ". get_lastName());
    */

    $need_change = array();
    $n = 0;
    
    if(isset($_POST["ParentFirstName"])){
        $newParentFirstName = $sanitize($_POST['ParentFirstName']);
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

    //connect(); 
    //function to add activity
    //function to add temp infomation
    
    print_r($need_change);
        

?>

<?php 
include ('footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
?>