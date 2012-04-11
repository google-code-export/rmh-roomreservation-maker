<?php
/**
 * This is a template for people who would want to create an interface for user interaction. The sequence of code blocks is important
 * because session handling requires proper sequence. Also the inclusion of header file is important. 
 * 
 * When you are creating a new file based on this template, make sure to add your page's permission requirement to the header.php file
 * example: $permission_array['template.php']=3;
 * where template.php is your file
 *         3 is the permission level required to access your page. this can be 0 through 3, where 0 is all, and 3 is admin
 * 
 * Detail explanation for each code
 * block has been provided for each section below:
 * Author:Gregorie Sylvester
 */

//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "New Referral Form"; //This should be the title for the page, included in the <title></title>

include('header.php'); //including this will further include (globalFunctions.php and config.php)
include_once (ROOT_DIR . '/domain/Requests.php');
include_once (ROOT_DIR . '/domain/ProfileChange.php');
include_once (ROOT_DIR . '/domain/Family.php');
include_once (ROOT_DIR . '/database/dbReservation.php');
include_once (ROOT_DIR . '/database/ProfileChange.php');


/*
 * If your page includes a form, please follow the instructions below.
 * If not, this code block can be deleted
 * 
 * If the page checks for $_POST data then it is important to validate the token that is attached with the form.
 * Attaching token to a form is described below in the HTML section.
 * Include the following check:
 */
    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        //the security validation was successful, perform required operation here below.
        //*** NOTE *** The validateTokenField DOES NOT filter/sanitize/clean the data fields.
        //A separate function sanitize() should be called to clean the data so that it is html/db safe
    }
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        //if the security validation failed. display/store the error:
        //'The request could not be completed: security check failed!'

    }
    else
    {
        //there was no POST DATA
    }
        

?>

<div id="container">

    <div id="content">
        
        <!-- ALL YOUR HTML CONTENT GOES HERE -->
        
        <!-- If your page has a form please follow the coding guideline:
        Once you have your form setup, add the following php code after the form declaration:
        generateTokenField() 
        
        IMPORTANT: Make sure that generateTokenField() is always after validateTokenField in your code sequence
        
        EXAMPLE code block below (can be deleted if not using form) -->
         
        <form name ="referralForm" method="post" action="referralForm.php">
            <?php echo generateTokenField(); ?>
            
           <h1> New Referral Form </h1> <br><br>
           <h3> fill in the all the fields for a New Referral Form </h3><br><br>
           
           Begin Date:  <input type="text" name="BeginDate" value="" size="6" /><br>
           End Date:    <input type="text" name="EndDate"   value="" size="6" /><br>
           Patient Diagnosis: <input type="text" name="PatientDiagnosis" value="" size="11" /><br>
           Notes: <input type="text" name="Notes" value="" size="30" /><br>
           Parent Last Name:   <input type="text" name="ParentLastName" value="" size="11" /><br>
           Parent First Name: <input type="text" name="ParentFirstName" value="" size="11" /><br>
           
          <input type="submit" name="submit" value="Submit"/>
           
          </form>
            
            
      </div>
</div>      

  <?php
        //test the submission of a room Referral
 
  if(($_POST['submit'] == "submit")){
        
   
   $new_referral = new RoomReservationActivity();
   
   $request = new Requests($roomReservationActivityID,$roomReservationRequestID,$socialWorkerProfileId,
           $rmhStaffProfileId,$familyProfileId,$activityType,$status,$swDateStatusSubmitted,$rmhDateStatusSubmitted,
           $beginDate,$endDate,$patientDiagnosis,$roomnote);
  
        
        
    $new_referral->roomReservationActivityID = $roomReservationActivityID;
    $new_referral->roomReservationRequestID = $roomReservationRequestID;
   
    
     $Referral = array();
       $r = 0;
        
       if(isset($_POST["BeginDate"])){
        $newBeginDate = $sanitize($_POST['BeginDate']);
        $Referral[r] = $newBeginDate; 
        $new_referral->beginDate = $newBeginDate;
        $r++;
    }
        if(isset($_POST["EndDate"])){
        $newEndDate = $sanitize($_POST["EndDate"]);
        $Referral[r] = $newEndDate; 
        $new_referral->endDate = $newEndDate;
        $r++;
    }
        if(isset($_POST["PatientDiagnosis"])){
        $newPatientDiagnosis = $sanitize($_POST["PatientDiagnosis"]);
        $Referral[r] = $newPatientDiagnosis; 
        $new_referral->patientDiagnosis = $newPatientDiagnosis;
        $r++;
    }
     if(isset($_POST["Notes"])){
        $newNotes = $sanitize($_POST["Notes"]);
        $Referral[r] = $newNotes; 
        $r++;
     }
      if(isset($_POST["ParentLastName"])){
        $newParentLastName = $sanitize($_POST["ParentLastName"]);
        $Referral[r] = $newParentLastName; 
        $r++;
      }
      if(isset($_POST["ParentFirstName"])){
        $newParentFirstName = $sanitize($_POST["ParentFirstName"]);
        $Referral[r] = $newParentFirstName; 
        $r++;
  
    }
    if(empty($Referral)){
        echo("You did not enter all required fields. ");
    {
   
    }
    }
    }
    
    
    insert_RoomReservationActivity($new_referral);
    
    
?>
  
         
       
<?php     
include (ROOT_DIR.'/footer.php');  //include the footer file, this contains the proper </body> and </html> ending tag.
?>

