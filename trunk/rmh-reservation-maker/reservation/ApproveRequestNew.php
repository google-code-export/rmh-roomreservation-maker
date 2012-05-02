<?php
/*
* Copyright 2011 by Paul Kubler and Bonnie MacKellar.
* This program is part of RMH-RoomReservationMaker, which is free software,
* inspired by the RMH Homeroom Project.
* It comes with absolutely no warranty.  You can redistribute and/or
* modify it under the terms of the GNU Public License as published
* by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
 
/*
* Approve New Request module for RMH-RoomReservationMaker. 
* Brief description of module (see Homeroom for examples)
* @author Paul Kubler
* @version 5/1/12
*/
include_once("../domain/Reservation.php");
include_once("../mail/functions.php");
//Append "-confirmed" to status
$stat=get_status();
$stat()+='-confirmed';
set_status($stat);
$reservation = retrieve_RoomReservationActivity_byRequestId($requestId);
$RequestKeyNumber=$reservation->get_roomReservationRequestID();
$BeginDate= $reservation->get_beginDate(); 
$EndDate=$reservation->get_endDate();
$familyProfileId=$reservation->get_familyProfileId(); 
$SWID=$reservation->get_socialWorkerProfileId();

RRequestAccept($RequestKeyNumber, $BeginDate, $EndDate, $familyProfileId,$SWID);
?>
