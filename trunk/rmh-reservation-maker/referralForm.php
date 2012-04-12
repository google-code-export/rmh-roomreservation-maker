<?php
/**
 * Author:Gregorie Sylvester
 */

session_start();
session_cache_expire(30);

$title = "Referral Form"; 

include('header.php');
include_once (ROOT_DIR . '/domain/Reservation.php');
include_once (ROOT_DIR . '/domain/ProfileChange.php');
include_once (ROOT_DIR . '/domain/Family.php');
include_once (ROOT_DIR . '/database/dbReservation.php');
include_once (ROOT_DIR . '/database/ProfileChange.php');


/*
 * Submitted Form Actions if a token is set, and $_POST['submit'] == "submit"
 */
    if( isset( $_POST['form_token'] ) && validateTokenField( $_POST ) )
    {
        if( $_POST['submit'] == "submit" )//test the submission of a room Referral
        {
            if( isset( $_POST["BeginDate"] ) )
                $newBeginDate = $sanitize( $_POST['BeginDate'] );
            
            if( isset( $_POST["EndDate"] ) )
                $newEndDate = $sanitize( $_POST["EndDate"] );            
            
            if( isset( $_POST["PatientDiagnosis"] ) )
                $newPatientDiagnosis = $sanitize( $_POST["PatientDiagnosis"] );
            
            if( isset( $_POST["Notes"] ) )
                $newNotes = $sanitize( $_POST["Notes"] );
            
            if( isset( $_POST["ParentLastName"] ) )
                $newParentLastName = $sanitize( $_POST["ParentLastName"] );
            
            if( isset( $_POST["ParentFirstName"] ) )
                $newParentFirstName = $sanitize( $_POST["ParentFirstName"] );
            
            $new_referral = new Requests( );
            insert_RoomReservationActivity( $new_referral );
            
        } //end if( $_POST['submit'] == "submit" )
       
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
           <h3> fill in the all the fields for a New Referral Form </h3><br /><br />
           
           Begin Date:  <input type="text" name="BeginDate" value="" size="6" /><br />
           End Date:    <input type="text" name="EndDate"   value="" size="6" /><br />
           Patient Diagnosis: <input type="text" name="PatientDiagnosis" value="" size="11" /><br />
           Notes: <input type="text" name="Notes" value="" size="30" /><br />
           Parent Last Name:   <input type="text" name="ParentLastName" value="" size="11" /><br />
           Parent First Name: <input type="text" name="ParentFirstName" value="" size="11" /><br />
           
          <input type="submit" name="submit" value="Submit" />
           
          </form>
            
            
      </div>
</div>               
       
<?php     
include (ROOT_DIR.'/footer.php');
?>