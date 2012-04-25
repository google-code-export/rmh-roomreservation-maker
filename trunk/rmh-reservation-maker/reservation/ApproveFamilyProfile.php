<?php
/*
  * @author Paul Kubler
  * 
  * Approve Family Profile Change
  * 
  */
include_once("..\mail\functions.php");
//Append "-confirmed" to status
get_status()+='-confirmed';
//Submit Changes to database
//Generate Key ID
RequestAccept($RequestKey, $SWName, $familyLname, $DateToAndFrom);

ModifyAccept($RequestKey, $SWName, $familyLname, $DateToAndFrom);

?>