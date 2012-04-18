<?php
/*
  * @author Paul Kubler
  * 
  * Approver Form View
  * 
  */
//Append "-confirmed" to status
get_status()+='-confirmed';
//Submit Changes to database
//Generate Key ID
RequestAccept($RequestKey, $SWName, $familyLname, $DateToAndFrom);

ModifyAccept($RequestKey, $SWName, $familyLname, $DateToAndFrom);

?>