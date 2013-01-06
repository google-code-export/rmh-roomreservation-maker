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
<nav class="navpane">
	<ul>
   
		<!--navigation links available to all members -->
		<li data-href="<?php echo BASE_DIR.'/index.php';?>">Home</li>
	<?php
	if($userAccess === 0)
	{
	   //Navigation for family members
	 ?>
	    <li data-href="<?php echo BASE_DIR.'/index.php';?>">Family Nav1</li>
	    <li data-href="<?php echo BASE_DIR.'/index.php';?>">Family Nav2</li>
	    <li data-href="<?php echo BASE_DIR. '/logout.php';?>">Log Out</li>
	    
	
	    
	<?php  
	}
	else if($userAccess === 1)
	{
	    //Navigation for social workers
	 ?>
	    <li data-href="<?php echo BASE_DIR.'/family/FamilyProfileMenu.php';?>">Family Profile</li>
	    <li data-href="<?php echo BASE_DIR.'/report.php';?>">Report</li> 
	    <li data-href="<?php echo BASE_DIR.'/reservation/SearchReservations.php';?>">Search Reservations</li>
	<?php  
	}
	else if($userAccess === 2)
	{
	    //Navigation for RMH reservation managers
	 ?>
	    <li data-href="<?php echo BASE_DIR.'/reservation/SearchReservations.php';?>">Search Reservations</li>
	    <li data-href="<?php echo BASE_DIR.'/searchProfileActivity.php';?>">Approve Family Profile Changes</li>
	    
	<?php  
	}
	else if($userAccess === 3)
	{
	    //Navigation for admins
	 ?>
	    <li data-href="<?php echo BASE_DIR.'/admin/listUsers.php';?>">View Users</li>
	    <li data-href="<?php echo BASE_DIR.'/admin/addUser.php';?>">Add New User</li>
	
	<?php  
	}
	//Navigation that appears for everyone (excluding family members)
	if($userAccess > 0)
	{
	?>
	    <li data-href="<?php echo BASE_DIR.'/changeAccountSettings.php';?>">Manage Account</li>
	    <li data-href="<?php echo BASE_DIR. '/logout.php';?>" onClick="return confirm('Are you sure you want to logout?');">Log Out</li>
	    
	<?php
	} 
	?>
	</ul>
	<div class="leftArrow"></div>
</nav>
<?php 
//TODO: Is the following include necessary??? Other alternatives? Or remove this, most probably.
/*include (ROOT_DIR. '/inc/back.php');
*/
?>