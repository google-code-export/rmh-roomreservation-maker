<?php

/**
 * @author Prayas Bhattarai
 * This file includes the navigation based on user permission level
 * This file should only be included on a page whose permission level is greater 
 * than that for the world.
 */
$userAccess = getUserAccessLevel();
?>
<ul style="position: absolute; left: 10px; background:none rgba(255,255,255,0.8); list-style: none; padding: 10px; width: 150px; min-height: 200px;">
   
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
    <li><a href="<?php echo BASE_DIR.'/reportForm.php';?>">Report</a></li> 
<?php  
}
else if($userAccess === 2)
{
    //Navigation for RMH reservation managers
 ?>
    <li><a href="<?php echo BASE_DIR.'/index.php';?>">Manager Nav1</a></li>
    <li><a href="<?php echo BASE_DIR.'/index.php';?>">Manager Nav2</a></li>
    
<?php  
}
else if($userAccess === 3)
{
    //Navigation for admins
 ?>
    <li><a href="<?php echo BASE_DIR.'/index.php';?>">Admin Nav1</a></li>
    <li><a href="<?php echo BASE_DIR.'/index.php';?>">Admin Nav2</a></li>
    
<?php  
}
?>
   <li style="position:absolute; bottom: 10px;"><a href="<?php echo BASE_DIR.'/logout.php';?>">Logout</a></li> 
</ul>