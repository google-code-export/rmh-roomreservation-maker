<?php
/*
  * @author Paul Kubler
  * 
  * Deny Request Modify
  * 
  */
include_once("../domain/Reservation.php");
include_once("../mail/functions.php");
//Append "-confirmed" to status
$stat=get_status();
$stat()+='-denied';
set_status($stat);
//Submit Changes to database
//Generate Key ID
//->rmhStaffProfileId = $rmhStaffProfileId;
//$this->rmhDateStatusSubmitted = $rmhDateStatusSubmitted;

//Send automatic email to SW
$RequestKeyNumber=$reservation->get_roomReservationRequestID();
$DateToAndFrom= $reservation->get_beginDate()."-".$reservation->get_endDate(); 
$familyLname=$family->get_parentlname(); 
$SWID=$reservation->get_socialWorkerProfileId(); 

ModifyDeny($RequestKey, $SWID, $familyLname, $DateToAndFrom, $note = "");
?>
