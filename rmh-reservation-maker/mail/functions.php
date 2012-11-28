<?php

/*

 * Copyright 2012 by Alisa Modeste, Yamiris Pascual, Stefan Pavon and Bonnie MacKellar.

 * This program is part of RMH-RoomReservationMaker, which is free software,

* inspired by the RMH Homeroom Project.

 * It comes with absolutely no warranty.  You can redistribute and/or

 * modify it under the terms of the GNU Public License as published

 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).

*/


include_once ('../core/config.php');
include_once (ROOT_DIR.'/database/dbUserProfile.php');
include_once (ROOT_DIR.'/database/dbFamilyProfile.php');




    

/*
* email module for RMH-RoomReservationMaker. 
* Allows you to modify settings and check if mail was sent
  @param array/string $add - one or more email recipients
* @author Alisa Modeste
* @version 05/02/12
*/
function email($add, $subject, $message)
{
   
    
   if (is_array($add)):
        foreach ($add as $to):
            $mailed = mail($to, $subject, $message);

            if($mailed):
                echo "<p>The email was sent to $to";
            else:
                echo "<p>The email could not be sent to $to, please try again";
            endif;
        endforeach;
    else:
        $to = $add;
        $mailed = mail($to, $subject, $message);

        if($mailed):
            echo "<p>The email was sent to $to";
        else:
            echo "<p>The email could not be sent to $to, please try again";
        endif;
    endif;

   
}


/*
* ConfirmCancel module for RMH-RoomReservationMaker. 
* Notifies the social worker that the request has been cancelled.
  @param int $SWID - looking for UserProfileID
* @author Alisa Modeste
* @version 05/02/12
*/
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


/*
* ModifyDeny module for RMH-RoomReservationMaker. 
* Notifies the social worker that the modified request couldn't be accommodated.
  @param int $SWID - looking for UserProfileID
* @author Alisa Modeste
* @version 05/02/12
*/
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


/*
* ModifyAccept module for RMH-RoomReservationMaker. 
* Notifies the social worker that the modified request has been accepted.
  @param int $SWID - looking for UserProfileID
* @author Alisa Modeste
* @version 05/02/12
*/
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



/* module for RMH-RoomReservationMaker.  

* Confirm Email tells the SW their request was submitted and they are able to have a copy of the RequestKey

 * @author Yamiris Pascual

 * @version May 2, 2012
*/

function Confirm($RequestKey, $StartDate, $EndDate,$SWID, $familyID)
{
    $SW = retrieve_UserProfile_SW($SWID);   //gets social worker user profile using their ID that is being passed
    
    if($SW[0]->get_email_notification() == 'Yes'):  //if the email_notification on their profile is 'Yes' proceed
        
     $family = retrieve_FamilyProfile($familyID);
    
       $name = $family->get_patientfname() . " " . $family->get_patientlname(); //Sets the patients first and last name to the variable $name
    
   
        $to = $SW[0]->get_userEmail();  //gets the sw email address
    
        $subject = "Your request has been submitted";
        
       $message = "We received your request for a reservation for $StartDate to $EndDate for $name. \r\nYour confirmation number is $RequestKey. Please keep in your records for future use.\r\n\r\n Thank you.";
    
      
        email($to, $subject, $message);
      endif;     
}


/* module for RMH-RoomReservationMaker.  

*This email is sent to the SW to inform them that their request for a reservation has been accepted 

 * @author Yamiris Pascual

 * @version May 2, 2012
*/
function RequestAccept($RequestKey, $StartDate, $EndDate, $SWID, $familyID)
{
     $SW = retrieve_UserProfile_SW($SWID);
    
    if($SW[0]->get_email_notification() == 'Yes'):
        
     $family = retrieve_FamilyProfile($familyID);
    
       $name = $family->get_patientfname() . " " . $family->get_patientlname();
    
   
        $to = $SW[0]->get_userEmail();
        
    
    $subject = "Reservation Request $RequestKey";
    
    $message = "Your reservation request, $RequestKey, for $name for the dates of $StartDate to $EndDate for has been accepted. \r\n\r\nThank You.";
  
    email($to, $subject, $message);
    
    /*$tempURL=randURL($familyID);
    
    FamilyConfirm($familyID,$StartDate,$EndDate,$tempURL);  */
    
    endif;    
}



/* module for RMH-RoomReservationMaker.  

*This email is sent to the SW to inform them that their request for a reservation has been denied

 * @author Yamiris Pascual

 * @version May 2, 2012
*/
function RequestDeny($RequestKey, $StartDate, $EndDate, $SWID, $familyID)
{
   $SW = retrieve_UserProfile_SW($SWID);
    
    if($SW[0]->get_email_notification() == 'Yes'):
        
     $family = retrieve_FamilyProfile($familyID);
    
       $name = $family->get_patientfname() . " " . $family->get_patientlname();
    
   
        $to = $SW[0]->get_userEmail();    
    
    $subject = "Reservation Request $RequestKey";
    
    $message = "Your reservation request, $RequestKey, for $name, for the dates of $StartDate to $EndDate has been denied.\r\n\r\nThank You.";
  
    email($to, $subject, $message);   
   endif;
}


/* module for RMH-RoomReservationMaker.  

*Sends an email to the Social Worker to inform them that their request to modify the familiy profile
has been sent.  It also supplies the social worker with the requestID of their specified request.

 * @author Yamiris Pascual

 * @version May 2, 2012
*/
function FamilyModConfirm($requestID, $familyID, $SWID)
{
     $SW = retrieve_UserProfile_SW($SWID);
    
    if($SW[0]->get_email_notification() == 'Yes'):
        
     $family = retrieve_FamilyProfile($familyID);
    
       $name = $family->get_patientfname() . " " . $family->get_patientlname();
    
   
        $to = $SW[0]->get_userEmail();
    
    $subject = "Family Profile Modification Request $requestID";
    
    $message = "The request to update $name profile has been sent.  Here is the confirmation number for that request, $requestID, please retain for future uses.\r\n\r\nThank You.";
  
    email($to, $subject, $message); 
    endif;
}

/* module for RMH-RoomReservationMaker.  

This email is sent to the SW to inform them that the request to Modify the family profile has been accepted

 * @author Yamiris Pascual

 * @version May 2, 2012
*/
function FamilyModAccept($requestID, $familyID, $SWID)
{
    $SW = retrieve_UserProfile_SW($SWID);
    
    if($SW[0]->get_email_notification() == 'Yes'):
        
     $family = retrieve_FamilyProfile($familyID);
    
       $name = $family->get_patientfname() . " " . $family->get_patientlname();
    
   
        $to = $SW[0]->get_userEmail();
    
    $subject = "Family Profile Modification Request $requestID";
    
    $message = "Request $requestID, to update the Family of $name, has been accepted.\r\n\r\nThank you.";
  
    email($to, $subject, $message); 
    endif;
}


/* module for RMH-RoomReservationMaker.  

This email is sent to the SW to inform them that the request to Modify the family profile has been denied.

 * @author Yamiris Pascual

 * @version May 2, 2012
*/
function FamilyModDeny($requestID,$familyID, $SWID)
{
     $SW = retrieve_UserProfile_SW($SWID);
    
    if($SW[0]->get_email_notification() == 'Yes'):
        
     $family = retrieve_FamilyProfile($familyID);
    
       $name = $family->get_patientfname() . " " . $family->get_patientlname();
    
   
        $to = $SW[0]->get_userEmail();
    
    
    $subject = "Family Profile Modification Request $requestID";
    
    $message = "Request $requestID, to update the Family of $name profile, has been denied.\r\n\r\nThank you.";
  
    email($to, $subject, $message); 
   endif;
}

/*
* E-Mail module for RMH-RoomReservationMaker. 

* Sends email to approvers about a new reservation request.

* @author Stefan Pavon

* @version 2012-5-1

*/
function newRequest($RequestKey, $DateSubmitted, $BeginDate, $EndDate)
{
    $subject = "Reservation Request made on $DateSubmitted";
    $message = "A new room reservation request has been made for the timeframe 
                from $BeginDate to $EndDate.\r\n\r\nThe request ID is: $RequestKey";
    $Approver = retrieve_all_UserProfile_byRole('RMH Staff Approver');
    for($i = 0; $i < count($Approver); $i++)
    {
        $to = $Approver[$i]->get_userEmail();
        email($to, $subject, $message);
    };
}


/*
* E-Mail module for RMH-RoomReservationMaker. 

* Sends email to approvers about a modification to an existing room reservation request.

* @author Stefan Pavon

* @version 2012-5-1

*/
function newReservationMod($RequestKey, $DateSubmitted, $FamilyProfileID)
{
    $familyLname = retrieve_FamilyProfile($FamilyProfileID)->get_parentlname();
    $subject = "Modification Request made on $DateSubmitted";
    $message = "A modification request has been made for the $familyLname 
                family.\r\n\r\nThe request ID is: $RequestKey";
    $Approver = retrieve_all_UserProfile_byRole('RMH Staff Approver');
    for($i = 0; $i < count($Approver); $i++)
    {
        $to = $Approver[$i]->get_userEmail();
       email($to, $subject, $message);
    };
}

/*
* E-Mail module for RMH-RoomReservationMaker. 

* Sends email to approvers about the cancellation of an existing room reservation request.

* @author Stefan Pavon

* @version 2012-5-1

*/
function newCancel($RequestKey, $DateSubmitted, $FamilyProfileID)
{
    $familyLname = retrieve_FamilyProfile($FamilyProfileID)->get_parentlname();
    $subject = "Cancellation Request made on $DateSubmitted";
    $message = "A cancellation request has been made for the $familyLname 
                family.\r\n\r\nThe request ID is: $RequestKey";
    $Approver = retrieve_all_UserProfile_byRole('RMH Staff Approver');
    for($i = 0; $i < count($Approver); $i++)
    {
        $to = $Approver[$i]->get_userEmail();
        email($to, $subject, $message);
    };
}


/*
* E-Mail module for RMH-RoomReservationMaker. 

* Sends email to approvers requesting permission to modify a family profile.

* @author Stefan Pavon

* @version 2012-5-1

*/
function newFamilyMod($RequestKey, $DateSubmitted, $FamilyProfileID)
{
    $familyLname = retrieve_FamilyProfile($FamilyProfileID)->get_parentlname();
    $subject = "Family Profile Modification Request made on $DateSubmitted";
    $message = "A family profile modification request has been made for the 
                $familyLname family.\r\n\r\nThe request ID is: $RequestKey";
    $Approver = retrieve_all_UserProfile_byRole('RMH Staff Approver');
    for($i = 0; $i < count($Approver); $i++)
    {
        $to = $Approver[$i]->get_userEmail();
        email($to, $subject, $message);
    };
}


/*
* PasswordReset module for RMH-RoomReservationMaker. 
* Sends an email to the user with a link to reset their password
  @param mixed $activation - generated activation code
* @author Alisa Modeste
* @version 05/02/12
*/
function PasswordReset($activation, $username, $userEmail)
{
    $to = $userEmail;
    
    $subject = "Request for Password Reset";
    $message = "Please click the link to reset your password: (URL)?user=$username&activation=$activation";
    
    email($to, $subject, $message);
}


/*
* NewFamilyProfile module for RMH-RoomReservationMaker. 
* Sends the approvers notice of the need to create a new family profile
* @author Alisa Modeste
* @version 05/02/12
*/
function NewFamilyProfile($profileID)

{
    $approvers = retrieve_all_UserProfile_byRole('RMH Staff Approver');
    
    foreach($approvers as $user):
    
        $to[] = $user->get_userEmail();
    endforeach;
 $to = implode(",",$to);//changes $to into a string
    
    $subject = "There is a Request for a New Family Profile";
    $message = "There is a request for a new family profile. Its Profile Activity ID is $profileID.";

    email($to, $subject, $message);
}



  

//function NewFamilyDeny


function randURL($familyID)
{
    /*This piece of code should generate the random string to append to the URL link
    * that will go in the email. 
    * The contents of the email should contain webaddress.com/blah(append(.))rng url
    * along with a message regarding the family reservation being made.
    */ 
    $length=12; //need to set a length for the URL, currently at 12
    $characters='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //the set of characters that can be chosen, should be 52.
    $randString='';
    for ($i = 0; $i < $length; $i++) {
    //chooses one character from the entire set of available characters in characters
    //this continues until it fills up the length.
       $randString .= $characters[mt_rand(0, strlen($characters))];
    }
    urlToText($randString,$familyID);
    return $randString;
}

function urlToText($randURL,$familyID)
{
    //stores the URL with the family ID in a text file
    //the text file is in the wamp folder
    $URLFile='../mail/URLs.txt';
    $fh = fopen($URLFile, 'a') or die("can't open file");
    $stringData=$randURL . " " . $familyID . " ";
    fwrite($fh,$stringData);
    fclose($fh);
}

function getFamilyIDFromURL($randURL)
{
    //gets the family ID associated with a specific URL
    $URLFile='../mail/URLs.txt';
    $fileContents=file_get_contents($URLFile);
    $URLArray=explode(" ",$fileContents);
    foreach ($URLArray as $URLs)
    {
        if($URLs==$randURL)
        {
            return $URLArray[key($URLArray)];
        }
    }
    return -1;
}

function clearContents()
{
    //clears the entire file, eventually will end up clearing 1 entry. Probably.
    $URLFile="URLs.txt";
    $fh = fopen($URLFile, 'w') or die("can't open file");
    fclose($fh);
}
?>