<?php

/*
* Copyright 2011 by Linda Shek and Bonnie MacKellar.
* This program is part of RMH-RoomReservationMaker, which is free software,
* inspired by the RMH Homeroom Project.
* It comes with absolutely no warranty.  You can redistribute and/or
* modify it under the terms of the GNU Public License as published
* by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

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
