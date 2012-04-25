<?php
/*
  * @author Paul Kubler
  * 
  * Approve Request New
  * 
  */
include_once("..\mail\functions.php");
//Append "-confirmed" to status
get_status()+='-confirmed';
//Submit Changes to database
//Generate Key ID
RequestAccept($RequestKey, $SWName, $familyLname, $DateToAndFrom);
?>
