<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * 
 * To do:
 * URL
 * 
 */

include_once ('../core/config.php');
include_once (ROOT_DIR.'/database/dbUserProfile.php');
include_once (ROOT_DIR.'/database/dbFamilyProfile.php');
include_once (ROOT_DIR.'/domain/Family.php');


//email allows you to modify settings and check if mail was sent
//@param array/string $add - one or more email recipients
//@author Alisa Modeste
function email($add, $subject, $message)
{
    /*
     * Not needed on Go Daddy
     */ $from = 'alisa.modeste08@stjohns.edu'; //this SHOULD be a VALID email address

    ini_set("SMTP","mailhubout.stjohns.edu");
    ini_set('sendmail_from', $from);
    ini_set("smtp_port","25");
     
    //For testing purposes
    if (is_array($add)):
        foreach ($add as $to):
            echo "This is what was passed in an array: $to <p>";
        endforeach;
        
    else:
        echo "This is what was passed in a string: $add";
    endif; 
    //Until here
    
    if (is_array($add)):
        foreach ($add as $to):
            $mailed = mail($to, $subject, $message);

            if($mailed):
                echo 'The email was sent';
            else:
                echo 'The email could not be sent, please try again';
            endif;
        endforeach;
    else:
        $to = $add;
        $mailed = mail($to, $subject, $message);

        if($mailed):
            echo 'The email was sent';
        else:
            echo 'The email could not be sent, please try again';
        endif;
    endif;

   
}


//ConfirmCancel notifies the SW that the request has been cancelled.
//@param int $SWID - UserProfileID
//@author Alisa Modeste
function ConfirmCancel($RequestKey, $SWID, $familyID, $StartDate, $EndDate)
{
    $SW = retrieve_UserProfile_SW($SWID);
    
    if ($SW[0]->get_email_notification() == 'Yes'):
        
        $family = retrieve_FamilyProfile($familyID);

        $name = $family->get_patientfname() . " " . $family->get_patientlname();
   
        $to = $SW[0]->get_userEmail();
        
        $subject = "Confirmation of Canceled Request";

        $message = "The cancellation for $name's family for dates $StartDate - $EndDate has been processed.\r\n\r\nThe request can be viewed at (URL)/$RequestKey";

        email($to, $subject, $message);
    
    endif;
    
}


//ModifyDeny notifies the SW that the modified request couldn't be accommodated.
//@param int $SWID - UserProfileID
//@author Alisa Modeste
function ModifyDeny($RequestKey, $SWID, $familyID, $StartDate, $EndDate, $note = "")
{
    $SW = retrieve_UserProfile_SW($SWID);
    
    if ($SW[0]->get_email_notification() == 'Yes'):
    
        $family = retrieve_FamilyProfile($familyID);
    
        $name = $family->get_patientfname() . " " . $family->get_patientlname();
   

        $to = $SW[0]->get_userEmail();
    
        $subject = "Cannot Accommodate Modified Request";
        
        if ($note != ""):
            $message = "The request for $name's family for dates $StartDate - $EndDate cannot be accommodated.\r\nNote: $note\r\n\r\nThe request can be viewed at (URL)/$RequestKey";
        else:
            $message = "The request for $name's family for dates $StartDate - $EndDate cannot be accommodated.\r\n\r\nThe request can be viewed at (URL)/$RequestKey";
        endif;

        email($to, $subject, $message);
    endif;
    
    
}

//ModifyAccept notifies the SW that the modified request has been accepted.
//@param int $SWID - UserProfileID
//@author Alisa Modeste
function ModifyAccept($RequestKey, $SWID, $familyID, $StartDate, $EndDate)
{
    $SW = retrieve_UserProfile_SW($SWID);
    
    if ($SW[0]->get_email_notification() == 'Yes'):
        
        $family = retrieve_FamilyProfile($familyID);
    
        $name = $family->get_patientfname() . " " . $family->get_patientlname();
    
        $to = $SW[0]->get_userEmail();
        
        $subject = "Modified Request has been Accepted";

        $message = "The request for $name's family for dates $StartDate - $EndDate has been accepted.\r\n\r\nThe request can be viewed at (URL)/$RequestKey";


        email($to, $subject, $message);
    endif;
    
}


//Confirm Email tells the SW their request was submitted and 

function Confirm($RequestKeyNumber, $BeginDate, $EndDate,$SWID)
{
    $SW = retrieve_UserProfile_SW($SWID);
   
        $to = $SW[0]->get_email();
    
        $subject = "Your request has been submitted";
        
       $message = "We received your request for a reservation for $BeginDate to $EndDate. \r\nYour confirmation number is $RequestKeyNumber. Please keep in your records for future use.\r\n\r\n Thank you.";
    
      
        email($to, $subject, $message);
           
}

//This email is sent to the SW to inform them that their request for a reservation has been accepted         
function RequestAccept($RequestKeyNumber, $BeginDate, $EndDate, $familyProfileId,$SWID)
{
    $SW = retrieve_UserProfile_SW($SWID);
    
    $to = $SW[0]->get_email();
    
    $subject = "Reservation Request $RequestKeyNumber";
    
    $message = "Your reservation request, $RequestKeyNumber for $BeginDate to $EndDate for user $familyProfileId has been accepted. \r\n Please click on the link [URL] to confirm.\r\n\r\nThank You.";
  
    email($to, $subject, $message);
}

//This email is sent to the SW to inform them that their request for a reservation has been denied
function RequestDeny($RequestKeyNumber, $BeginDate, $EndDate, $familyProfileId, $SWID)
{
 $SW = retrieve_UserProfile_SW($SWID);
    
    $to = $SW[0]->get_email();
    
    $subject = "Reservation Request $RequestKeyNumber";
    
    $message = "Your reservation request, $RequestKeyNumber for $BeginDate to $EndDate for user $familyProfileId has been denied.\r\n\r\nThank You.";
  
    email($to, $subject, $message);   
}

//This email is sent to the SW to inform them that the request to Modify the family profile has been accepted
function FamilyModAccept($familyProfileId, $SWID)
{
  $SW = retrieve_UserProfile_SW($SWID);
    
    $to = $SW[0]->get_email();
    
    $subject = "Family Profile Modification Request";
    
    $message = "The request to update the Family user,$familyProfileId, has been accepted.\r\n\r\nThank you.";
  
    email($to, $subject, $message);    
}

//This email is sent to the SW to inform them that the request to Modify the family profile has been denied.
function FamilyModDeny($familyProfileId, $SWID)
{
    $SW = retrieve_UserProfile_SW($SWID);
    
    $to = $SW[0]->get_userEmail();
    
    $subject = "Family Profile Modification Request";
    
    $message = "The request to update the Family user, $familyProfileId profile, has been denied.\r\n\r\nThank you.";
  
    email($to, $subject, $message);  
}


//Sends email to approvers about a new reservation request.
//@author Stefan Pavon
function newRequest($RequestKey, $DateSubmitted, $BeginDate, $EndDate)
{
    $subject = "Reservation Request made on $DateSubmitted";
    $message = "A new room reservation request has been made for the timeframe 
                from $BeginDate to $EndDate.\r\n\r\nThe request can be viewed 
                at (URL)/$RequestKey";
    $Approver = retrieve_all_UserProfile_byRole('RMH Staff Approver');
    for($i = 0; $i < count($Approver); $i++)
    {
        $to = $Approver[$i]->get_userEmail();
        email($to, $subject, $message);
    };
}

//Sends email to approvers about a modification to an existing room reservation 
//request.
//@author Stefan Pavon
function newReservationMod($RequestKey, $DateSubmitted, $FamilyProfileID)
{
    $familyLname = retrieve_FamilyProfile($FamilyProfileID)->get_parentlname();
    $subject = "Modification Request made on $DateSubmitted";
    $message = "A modification request has been made for the $familyLname 
                family.\r\n\r\nThe request can be viewed at (URL)/$RequestKey";
    $Approver = retrieve_all_UserProfile_byRole('RMH Staff Approver');
    for($i = 0; $i < count($Approver); $i++)
    {
        $to = $Approver[$i]->get_userEmail();
        email($to, $subject, $message);
    };
}

//Sends email to approvers about the cancellation of an existing room
//reservation request.
//@author Stefan Pavon
function newCancel($RequestKey, $DateSubmitted, $FamilyProfileID)
{
    $familyLname = retrieve_FamilyProfile($FamilyProfileID)->get_parentlname();
    $subject = "Cancellation Request made on $DateSubmitted";
    $message = "A cancellation request has been made for the $familyLname 
                family.\r\n\r\nThe request can be viewed at (URL)/$RequestKey";
    $Approver = retrieve_all_UserProfile_byRole('RMH Staff Approver');
    for($i = 0; $i < count($Approver); $i++)
    {
        $to = $Approver[$i]->get_userEmail();
        email($to, $subject, $message);
    };
}

//Sends email to approvers requesting permission to modify a family profile.
//@author Stefan Pavon
function newFamilyMod($FamilyProfileID, $DateSubmitted)
{
    $familyLname = retrieve_FamilyProfile($FamilyProfileID)->get_parentlname();
    $subject = "Family Profile Modification Request made on $DateSubmitted";
    $message = "A family profile modification request has been made for the 
                $familyLname family.\r\n\r\nThe request can be viewed at (URL)/
                $FamilyProfileID";
    $Approver = retrieve_all_UserProfile_byRole('RMH Staff Approver');
    for($i = 0; $i < count($Approver); $i++)
    {
        $to = $Approver[$i]->get_userEmail();
        email($to, $subject, $message);
    };
}

//PasswordReset sends an email to the user with a link to reset their password
//@author Alisa Modeste
function PasswordReset($activation, $username, $userEmail)
{
    $to = $userEmail;
    
    $subject = "Request for Password Reset";
    $message = "Please click the link to reset your password: (URL)?user=$username&activation=$activation";
    
    email($to, $subject, $message);
}

?>
