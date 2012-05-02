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
* Deny Family Change module for RMH-RoomReservationMaker. 
* This function sends emails based on the specific case of the title
* @author Paul Kubler
* @version 5/1/12
*/
include_once("../database/dbReservation.php");
include_once("../domain/Reservation.php");
include_once("../mail/functions.php");

$stat=get_status();
$stat()='Denied';
set_status($stat);

$profile = retrieve_ProfileActivity_byRequestId($profileActivityRequestId);
$familyProfileId=$profile->get_familyProfileId(); 
$SWID=$profile->get_socialWorkerProfileId(); 

FamilyModDeny($familyProfileId, $SWID);
?>