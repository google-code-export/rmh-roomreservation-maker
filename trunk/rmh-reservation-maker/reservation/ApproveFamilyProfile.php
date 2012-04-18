<?php
/*
  * @author Paul Kubler
  * 
  * Approve Family Profile Change
  * 
  */
//Append "-confirmed" to status
get_status()+='-confirmed';
//Submit Changes to database
//Generate Key ID
RequestAccept($RequestKey, $SWName, $familyLname, $DateToAndFrom);

ModifyAccept($RequestKey, $SWName, $familyLname, $DateToAndFrom);

?>