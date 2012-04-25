<?php
/**
 * @author Prayas Bhattarai
 * This file includes the navigation based on user permission level
 * This file should only be included on a page whose permission level is greater 
 * than that for the world.
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
    <li><a href="<?php echo BASE_DIR.'/referralForm.php?id=new';?>">New Referral</a></li>
    <li><a href="<?php echo BASE_DIR.'/family/profileDetail.php';?>">Request Room</a></li>
    <li><a href="<?php echo BASE_DIR.'/report.php';?>">Report</a></li> 
    <li><a href="<?php echo BASE_DIR.'/SearchReservations.php';?>">Search Reservations</a></li>
<?php  
}
else if($userAccess === 2)
{
    //Navigation for RMH reservation managers
 ?>
    <li><a href="<?php echo BASE_DIR.'/index.php';?>">Manager Nav1</a></li>
    <li><a href="<?php echo BASE_DIR.'/index.php';?>">Manager Nav2</a></li>
    <li><a href="<?php echo BASE_DIR.'/SearchReservations.php';?>">Search Reservations</a></li>
    
<?php  
}
else if($userAccess === 3)
{
    //Navigation for admins
 ?>
    <li><a href="<?php echo BASE_DIR.'/admin/listUsers.php';?>">View Users</a></li>
    <li><a href="<?php echo BASE_DIR.'/index.php';?>">Admin Nav2</a></li>
    
<?php  
}
?>
    
</ul><div class="topRightButton"><div id=" id="ios-arrow-left"><a href="<?php echo BASE_DIR.'/logout.php';?>">Logout</a></div></div>
<?php include (ROOT_DIR. '/inc/back.php'); ?>