<?php
/*
  * @author Paul Kubler
  * 
  * Approve Request Modify
  * 
  */
include_once("..\mail\functions.php");
//Append "-confirmed" to status
get_status()+='-confirmed';
//Submit Changes to database
//Generate Key ID
ModifyAccept($RequestKey, $SWName, $familyLname, $DateToAndFrom);
?>
