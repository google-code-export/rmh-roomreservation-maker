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



 $socialWorkerProfileId = $_SESSION['id'];
 


 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 /*
 * Submitted Form Actions if a token is set, and $_POST['submit'] == "submit"
 */
    if( isset( $_POST['form_token'] ) && validateTokenField( $_POST ) )
    {
        if( $_POST['submit'] == "submit" )//test the submission of a room Referral
        {
            $referralform = true;
            
            if( isset( $_POST["BeginDate"] ) ){
                $newBeginDate = $sanitize( $_POST['BeginDate'] );
            }
                
                

            if( isset( $_POST["EndDate"] ) ){
                $newEndDate = $sanitize( $_POST["EndDate"] ); 
            }
                
                
            
            if( isset( $_POST["PatientDiagnosis"] ) ){
                $newPatientDiagnosis = $sanitize( $_POST["PatientDiagnosis"] );
            }
            
            if( isset( $_POST["Notes"] ) ){
                $newNotes = $sanitize( $_POST["Notes"] );
            }
                
            
            if( isset( $_POST["ParentLastName"] ) ){
                $newParentLastName = $sanitize( $_POST["ParentLastName"] );
            }
                
            
            if( isset( $_POST["ParentFirstName"] ) ){
                $newParentFirstName = $sanitize( $_POST["ParentFirstName"] );
            }
                
            
            $myReservation = new Reservation($roomReservationActivityID, $roomReservationRequestID, $socialWorkerProfileId, $rmhStaffProfileId,
            $familyProfileId,$activityType, $status, $swDateStatusSubmitted, $rmhDateStatusSubmitted, $beginDate, $endDate, 
            $patientDiagnosis, $roomnote);
            $myReservation = insert_RoomReservationActivity( );
            
        } //end if( $_POST['submit'] == "submit" )
       
    }
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        $referralform = false; //if the security validation failed. display/store the error:
                          //'The request could not be completed: security check failed!'

    }
    else
    {
        $referralform = false; //there was no POST DATA
    }
    
       $errorMessage = "";
         //check that the fields are not blank and tell the user to fill them in

       if ( empty ($newBeginDate) ){

           $errorMessage .= " Please enter a BeginDate. ";

       }

       
       if ( empty ($newEndDate)  ){

           $errorMessage .= " Please enter a EndDate. ";

       } 
       
       if ( empty ($newPatientDiagnosis) ){
           
           $errorMessage .= " Please enter the Patient's Diagnosis. ";
       }
       
       if ( empty ($newParentLastName) ){
           
           $errorMessage .= " Please enter the Parent's Last Name. ";
       }
       
       if ( empty ($newParentFirstName) ){
           
           $errorMessage .= " Please enter the Parent's First Name. ";
       }
               

    
    
    
   $new_referral->beginDate = $newBeginDate;
   $new_referral->endDate = $newEndDate;
   $new_referral->patientDiagnosis = $newPatientDiagnosis;
   $new_referral->roomnote = $newNotes; 
   $new_referral->RoomReservationRequestID = $RoomReservationRequestID;
   $new_referral->ActivityType = $ActivityType;
   
   
   $RoomReservationRequestID = "Unconfirmed";
   $ActivityType ="Apply";

   
    //confirming to the social worker that the form went through
    echo "<br>";
    echo "Room Request made by: ".$socialWorkerProfileId."<br>";
    echo "Begin Date: ".$newBeginDate."<br>";
    echo "End Date: ".$newEndDate."<br>";
    
    
    mail("approvers email address goes here", $RoomReservationRequestID, "This is a pending request")//email the approver the request key, not sure if it should look like this though.
    
    
    
 
    
    
    
    
    

?>

    <?php     
include (ROOT_DIR.'/footer.php');
?>

