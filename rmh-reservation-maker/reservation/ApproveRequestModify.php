<?php
/*
  * @author Paul Kubler
  * 
  * Approve Request Modify
  * 
  */
include_once("../domain/Reservation.php");
include_once("../mail/functions.php");
//Append "-confirmed" to status
$stat=get_status();
$stat()+='-confirmed';
set_status($stat);
//Submit Changes to database
//Generate Key ID
//->rmhStaffProfileId = $rmhStaffProfileId;
//$this->rmhDateStatusSubmitted = $rmhDateStatusSubmitted;
$RequestKey=$reservation->get_roomReservationRequestID();
$DateToAndFrom= $reservation->get_beginDate()."-".$reservation->get_endDate();
$familyLname=$family->get_parentlname(); 
$SWID=$reservation->get_socialWorkerProfileId();

ModifyAccept($RequestKey, $SWID, $familyLname, $DateToAndFrom);
?>
