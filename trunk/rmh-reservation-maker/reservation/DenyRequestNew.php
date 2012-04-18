<?php
/*
  * @author Paul Kubler
  * 
  * Deny Request New
  * 
  */
//Append "-denied" to status
get_status()+='-denied';
//Submit Changes to database
//Generate Key ID
//Send automatic email to SW
RequestDeny($RequestKey, $SWName, $familyLname, $DateToAndFrom);
?>
