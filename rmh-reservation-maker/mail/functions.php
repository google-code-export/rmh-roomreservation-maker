<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function ConfirmCancel($RequestKey, $SWID, $familyLname, $DateToAndFrom)
{
    $to = "admin@example.net";//dbFunction to find SW's email address
    $subject = "Confirmation of Cancelled Request";
    
    $message = "The cancellation for the $familyLname for dates $DateToAndFrom has been processed.\n\nThe request can be viewed at (URL)/$RequestKey";
    
    mail($to, $subject, $message);
}

function ModifyDeny($RequestKey, $SWID, $familyLname, $DateToAndFrom, $note)
{
    $to = "admin@example.net";//dbFunction to find SW's email address
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
    $to = "admin@example.net";//dbFunction to find SW's email address
    $subject = "Modified Request has been Accepted";
    
    $message = "The request for the $familyLname for dates $DateToAndFrom has been accepted.\n\nThe request can be viewed at (URL)/$RequestKey";
    
    
    mail($to, $subject, $message);
}

?>
