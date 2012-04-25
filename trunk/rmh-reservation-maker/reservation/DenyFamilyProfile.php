<?php
/*
  * @author Paul Kubler
  * 
  * Deny Family Profile Change
  * 
  */
include_once("..\mail\functions.php");
//Append "-denied" to status
get_status()+='-denied';
//Submit Changes to database
//Generate Key ID
//Send automatic email to SW

?>