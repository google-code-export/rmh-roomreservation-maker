<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once ('..\core\config.php');
include_once (ROOT_DIR.'\database\dbUserProfile.php');


//allows you to modify settings and check if mail was sent
//To do:
//rewrite to allow for sending to multiple addresses
//edit from
function email($to, $subject, $message)
{
    $from = 'alisa.modeste08@stjohns.edu'; //this SHOULD be a VALID email address

    ini_set("SMTP","mailhubout.stjohns.edu");
    ini_set('sendmail_from', $from);
    ini_set("smtp_port","25");


    $mailed = mail($to, $subject, $message);

    if($mailed):
        echo 'The email was sent';
    else:
        echo 'The email could not be sent, please try again';
    endif;

}


//ConfirmCancel notifies the SW that the request has been cancelled.
function ConfirmCancel($RequestKey, $SWID, $familyLname, $DateToAndFrom)
{
    $SW = retrieve_UserProfile_SW($SWID);
   
 //   if ($SW[0]->get_email_notification() == 'yes'):
        $to = $SW[0]->get_email();
        
        $subject = "Confirmation of Cancelled Request";

        $message = "The cancellation for the $familyLname family for dates $DateToAndFrom has been processed.\r\n\r\nThe request can be viewed at (URL)/$RequestKey";

        email($to, $subject, $message);
    
  //  endif;
    
}


//ModifyDeny notifies the SW that the modified request couldn't be accommodated.
function ModifyDeny($RequestKey, $SWID, $familyLname, $DateToAndFrom, $note = "")
{
    $SW = retrieve_UserProfile_SW($SWID);
   
   // if ($SW[0]->get_email_notification() == 'yes'):
        $to = $SW[0]->get_email();
    
        $subject = "Cannot Accommodate Modified Request";
        
        if ($note != ""):
            $message = "The request for the $familyLname family for dates $DateToAndFrom cannot be accommodated.\r\nNote: $note\r\n\r\nThe request can be viewed at (URL)/$RequestKey";
        else:
            $message = "The request for the $familyLname family for dates $DateToAndFrom cannot be accommodated.\r\n\r\nThe request can be viewed at (URL)/$RequestKey";
        endif;

        email($to, $subject, $message);
   // endif;
    
    
}

//ModifyAccept notifies the SW that the modified request has been accepted.
function ModifyAccept($RequestKey, $SWID, $familyLname, $DateToAndFrom)
{
    $SW = retrieve_UserProfile_SW($SWID);
   
 //  if ($SW[0]->get_email_notification() == 'Yes'):
        $to = $SW[0]->get_email();
        
        $subject = "Modified Request has been Accepted";

        $message = "The request for the $familyLname family for dates $DateToAndFrom has been accepted.\r\nThe request can be viewed at (URL)/$RequestKey";


        email($to, $subject, $message);
 // endif;
    
}

?>
