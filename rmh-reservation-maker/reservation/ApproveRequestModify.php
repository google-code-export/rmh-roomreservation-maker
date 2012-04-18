<?php
/*
  * @author Paul Kubler
  * 
  * Approve Request Modify
  * 
  */
//Append "-confirmed" to status
get_status()+='-confirmed';
//Submit Changes to database
//Generate Key ID
ModifyAccept($RequestKey, $SWName, $familyLname, $DateToAndFrom);
?>
