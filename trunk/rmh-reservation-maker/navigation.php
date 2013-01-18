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

//Navigation items are set automatically based on the page name. It can be overriden by assigning the page name to $navItem
//So for pages that are linked from the navigation menu, their $navItem is set automatically. But pages that are child pages of
//a menu item, which doesn't have a direct link from the navigation, their $navItem has to be set to one of the pages in the left menu
//this is done to highlight the current selected page
if(!isset($navItem)){
	$navItem = basename($_SERVER['PHP_SELF']);
}

?>
<nav class="navpane">
	<ul>
   
		<!--navigation links available to all members -->
		<li data-href="<?php echo BASE_DIR.'/index.php';?>" <?php echo ($navItem == "index.php") ? 'class="selected"' : '';?>>Home</li>
	<?php
	if($userAccess === 0)
	{
	   //Navigation for family members
	 ?>
	    <li data-href="<?php echo BASE_DIR.'/index.php';?>" <?php echo ($navItem == "index.php") ? 'class="selected"' : '';?>>Family Nav1</li>
	    <li data-href="<?php echo BASE_DIR.'/index.php';?>" <?php echo ($navItem == "index.php") ? 'class="selected"' : '';?>>Family Nav2</li>
	    <li data-href="<?php echo BASE_DIR. '/logout.php';?>">Log Out</li>
	<?php  
	}
	else if($userAccess === 1)
	{
	    //Navigation for social workers
	 ?>
	    <li data-href="<?php echo BASE_DIR.'/family/FamilyProfileMenu.php';?>" <?php echo ($navItem == "FamilyProfileMenu.php") ? 'class="selected"' : '';?>>Family Profile</li>
	    <li data-href="<?php echo BASE_DIR.'/report.php';?>" <?php echo ($navItem == "report.php") ? 'class="selected"' : '';?>>Report</li> 
	    <li data-href="<?php echo BASE_DIR.'/reservation/SearchReservations.php';?>" <?php echo ($navItem == "SearchReservations.php") ? 'class="selected"' : '';?>>Search Reservations</li>
	<?php  
	}
	else if($userAccess === 2)
	{
	    //Navigation for RMH reservation managers
	 ?>
	    <li data-href="<?php echo BASE_DIR.'/reservation/SearchReservations.php';?>" <?php echo ($navItem == "SearchReservations.php") ? 'class="selected"' : '';?>>Search Reservations</li>
	    <li data-href="<?php echo BASE_DIR.'/searchProfileActivity.php';?>" <?php echo ($navItem == "searchProfileActivity.php") ? 'class="selected"' : '';?>>Approve Family Profile Changes</li>
	    
	<?php  
	}
	else if($userAccess === 3)
	{
	    //Navigation for admins
	 ?>
	    <li data-href="<?php echo BASE_DIR.'/admin/listUsers.php';?>" <?php echo ($navItem == "listUsers.php") ? 'class="selected"' : '';?>>View Users</li>
	    <li data-href="<?php echo BASE_DIR.'/admin/addUser.php';?>" <?php echo ($navItem == "addUser.php") ? 'class="selected"' : '';?>>Add New User</li>
	
	<?php  
	}
	//Navigation that appears for everyone (excluding family members)
	if($userAccess > 0)
	{
	?>
	    <li data-href="<?php echo BASE_DIR.'/changeAccountSettings.php';?>" <?php echo ($navItem == "changeAccountSettings.php") ? 'class="selected"' : '';?>>Manage Account</li>
	    <li data-href="<?php echo BASE_DIR. '/logout.php';?>">Log Out</li>
	    
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