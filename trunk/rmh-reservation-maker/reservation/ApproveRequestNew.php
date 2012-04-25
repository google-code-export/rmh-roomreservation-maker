<?php
/*
  * @author Paul Kubler
  * 
  * Approve Request New
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
$RequestKeyNumber=$reservation->get_roomReservationRequestID();
$BeginDate= $reservation->get_beginDate(); 
$EndDate=$reservation->get_endDate();
$familyProfileId=$reservation->get_familyProfileId(); 
$SWID=$reservation->get_socialWorkerProfileId();

RRequestAccept($RequestKeyNumber, $BeginDate, $EndDate, $familyProfileId,$SWID);
?>
