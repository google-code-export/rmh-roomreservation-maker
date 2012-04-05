<?php

/*
 * This file contains the connection information for the database.
 * It may be modified for every installation of the software.
 * @author Linda Shek
 * @version 4/03/12
 */

function connect() {
    $host = "localhost";
	$database = "rmhreservationdb";
	$user = "rmhreservationdb";
	$password = "rmhreservationdb";

 	$connected = mysql_connect($host,$user,$password);
 	if (!$connected) return mysql_error();
    $selected = mysql_select_db($database, $connected);
    if (!$selected) return mysql_error();
    else return true;
 }

?>
