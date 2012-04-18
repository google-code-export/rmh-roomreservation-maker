<?php
/*
  * @author Paul Kubler
  * 
  * Approver Form View
  * 
  */
//Append "-denied" to status
get_status()+='-denied';
//Submit Changes to database
//Generate Key ID
//Send automatic email to SW
ModifyDeny($RequestKey, $SWName, $familyLname, $DateToAndFrom);
RequestDeny($RequestKey, $SWName, $familyLname, $DateToAndFrom);
?>