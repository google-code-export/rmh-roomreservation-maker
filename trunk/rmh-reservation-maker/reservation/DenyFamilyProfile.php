<?php
/*
  * @author Paul Kubler
  * 
  * Deny Family Profile Change
  * 
  */
include_once("..\domain\Reservation.php");
include_once("..\mail\functions.php");
//Append "-confirmed" to status
$stat=get_status();
$stat()+='-denied';
set_status($stat);
//Submit Changes to database
//Generate Key ID
//->rmhStaffProfileId = $rmhStaffProfileId;
//$this->rmhDateStatusSubmitted = $rmhDateStatusSubmitted;
FamilyModDeny($familyProfileId, $SWID);
?>