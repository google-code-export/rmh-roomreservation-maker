<?php
/**
 * Author:Gregorie Sylvester
 */

session_start();
session_cache_expire(30);

$title = "Referral Form"; 

include('header.php');
include_once (ROOT_DIR . '/domain/Reservation.php');
include_once (ROOT_DIR . '/domain/Family.php');
include_once (ROOT_DIR . '/database/dbReservation.php');
include_once (ROOT_DIR . '/database/ProfileActivity.php');
include_once (ROOT_DIR . '/database/dbFamilyProfile.php');



/*
 * Submitted Form Actions if a token is set, and $_POST['submit'] == "submit"
 */
    if( isset( $_POST['form_token'] ) && validateTokenField( $_POST ) )
    {
        if( $_POST['submit'] == "submit" )//test the submission of a room Referral
        {
            if( isset( $_POST["BeginDate"] ) )
                $newBeginDate = $sanitize( $_POST['BeginDate'] );
                $newBeginDate = $new_referral;
                

            if( isset( $_POST["EndDate"] ) )
                $newEndDate = $sanitize( $_POST["EndDate"] ); 
                $newEndDate = $new_referral;
                
            
            if( isset( $_POST["PatientDiagnosis"] ) )
                $newPatientDiagnosis = $sanitize( $_POST["PatientDiagnosis"] );
                $newPatientDiagnosis = $new_referral;
            
            if( isset( $_POST["Notes"] ) )
                $newNotes = $sanitize( $_POST["Notes"] );
                $newNotes = $new_referral;
            
            if( isset( $_POST["ParentLastName"] ) )
                $newParentLastName = $sanitize( $_POST["ParentLastName"] );
                $newParentLastName = $new_referral;
            
            if( isset( $_POST["ParentFirstName"] ) )
                $newParentFirstName = $sanitize( $_POST["ParentFirstName"] );
                $newParentFirstName = $new_referral;
            
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
        
        <?php
    if($showReport==true)
    {
        echo "<br>";
        echo "Report Requested By: ".$userId."<br>";
        echo "Start Date: ".$beginDate."<br>";
        echo "End Date: ".$endDate."<br>";
        echo "Hospital: ".$hospital."<br>";
        
        if($hospital == '')
        {
           
        }
        
        else 
        {
            
        }
    }
    else
    {
    echo "Security check failed: Go back to the form and resubmit your selections<br>";
    }
?>
        <br>
        
        

    </div>
</div>

<?php     
include (ROOT_DIR.'/footer.php');
?>

