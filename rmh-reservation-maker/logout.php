<?php
/*
* Copyright 2012 by Prayas Bhattarai and Bonnie MacKellar.
* This program is part of RMH-RoomReservationMaker, which is free software,
* inspired by the RMH Homeroom Project.
* It comes with absolutely no warranty.  You can redistribute and/or
* modify it under the terms of the GNU Public License as published
* by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
 
/**
* Logout script for RMH-RoomReservationMaker. 
* Includes code to correctly end the session when the user clicks logout. Redirects to login.php once logout is complete.
* @author Prayas Bhattarai
* @version May 1, 2012
*/
include_once('core/config.php');
    session_start();
    session_cache_expire(30);
    session_unset();
    session_destroy();
    session_write_close();
    header('Location: '.BASE_DIR.DS.'login.php');
?>