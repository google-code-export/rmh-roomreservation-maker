<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function ConfirmCancel($RequestKey, $SWID, $familyLname, $DateToAndFrom)
{
    $SW = retrieve_UserProfile_SW($SWId);
    $to = $SW['UserEmail'];
    
    $subject = "Confirmation of Cancelled Request";
    
    $message = "The cancellation for the $familyLname for dates $DateToAndFrom has been processed.\n\nThe request can be viewed at (URL)/$RequestKey";
    
    mail($to, $subject, $message);
}

function ModifyDeny($RequestKey, $SWID, $familyLname, $DateToAndFrom, $note)
{
    $SW = retrieve_UserProfile_SW($SWId);
    $to = $SW['UserEmail'];
    
    $subject = "Cannot Accommodate Modified Request";
    
    if ($note != ""):
        $message = "The request for the $familyLname for dates $DateToAndFrom cannot be accommodated.\nNote: $note\n\nThe request can be viewed at (URL)/$RequestKey";
    else:
        $message = "The request for the $familyLname for dates $DateToAndFrom cannot be accommodated.\n\nThe request can be viewed at (URL)/$RequestKey";
    endif;
    
    mail($to, $subject, $message);
}

function ModifyAccept($RequestKey, $SWID, $familyLname, $DateToAndFrom)
{
    $SW = retrieve_UserProfile_SW($SWId);
    $to = $SW['UserEmail'];
    
    $subject = "Modified Request has been Accepted";
    
    $message = "The request for the $familyLname for dates $DateToAndFrom has been accepted.\n\nThe request can be viewed at (URL)/$RequestKey";
    
    
    mail($to, $subject, $message);
}

?>
