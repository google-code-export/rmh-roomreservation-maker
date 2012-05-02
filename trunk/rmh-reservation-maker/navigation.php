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
* Navigation script for RMH-RoomReservationMaker. 
* This file includes the navigation based on user permission level
* This file is automatically included in the header.php file
* @author Prayas Bhattarai
* @version May 1, 2012
*/

//avoid direct access to the page:
if(!defined('PARENT'))
{
    die('Restricted access');
}

$userAccess = getUserAccessLevel();
?>
<div id="pad"></div>
<ul id="nav">
   
<!--navigation links available to all members -->
<li><a href="<?php echo BASE_DIR.'/index.php';?>">Home</a></li>
<li><a href="<?php echo BASE_DIR.'/help/homepage.php';?>">Help</a></li>
<?php
if($userAccess === 0)
{
   //Navigation for family members
 ?>
    <li><a href="<?php echo BASE_DIR.'/index.php';?>">Family Nav1</a></li>
    <li><a href="<?php echo BASE_DIR.'/index.php';?>">Family Nav2</a></li>
    
<?php  
}
else if($userAccess === 1)
{
    //Navigation for social workers
 ?>
    <li><a href="<?php echo BASE_DIR.'/family/newProfile.php';?>">New Family Profile</a></li>
    <li><a href="<?php echo BASE_DIR.'/family/profileDetail.php';?>">Request Room</a></li>
    <li><a href="<?php echo BASE_DIR.'/report.php';?>">Report</a></li> 
    <li><a href="<?php echo BASE_DIR.'/SearchReservations.php';?>">Search Reservations</a></li>
<?php  
}
else if($userAccess === 2)
{
    //Navigation for RMH reservation managers
 ?>
    <li><a href="<?php echo BASE_DIR.'/SearchReservations.php';?>">Search Reservations</a></li>
    <li><a href="<?php echo BASE_DIR.'/searchProfileActivity.php';?>">Search Profile Activity
    
<?php  
}
else if($userAccess === 3)
{
    //Navigation for admins
 ?>
    <li><a href="<?php echo BASE_DIR.'/admin/listUsers.php';?>">View Users</a></li>
    <li><a href="<?php echo BASE_DIR.'/admin/addUser.php';?>">Add New User</a></li>
    
<?php  
}

//Navigation that appears for everyone (excluding family members)
if($userAccess > 0)
{
?>
    <li><a href="<?php echo BASE_DIR.'/changeAccountSettings.php';?>">Manage Account</a></li>
    
<?php
}
?>
    
</ul><div class="topRightButton"><div id="ios-arrow-left"><a href="<?php echo BASE_DIR.'/logout.php';?>">Logout</a></div></div>
<?php include (ROOT_DIR. '/inc/back.php'); ?>