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
* Header script for RMH-RoomReservationMaker. 
* This script is included in most pages that require user interaction (except for handlers).
* This page contains the html tags and global includes that are required by each page.
* @author Prayas Bhattarai
* @version May 1, 2012
*/
 
/*  Direct access of include files needs to prevented. In order to do that, the following constant defines PARENT.
    Any include page that has header included before, will have this constant defined. If the page is directly accessed,
    PARENT will not be defined. So we can perform this check on the include pages.
 */
    define('PARENT','rmhresmaker');

    include('core/config.php');
    include('core/globalFunctions.php');
    include('core/sessionManagement.php');
    
    include('permission.php');
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo (isset($title) ? $title : 'Welcome') . ' | RMH Room Reservation Maker'; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="<?php echo CSS_DIR;?>/normalize.css">
        <link rel="stylesheet" href="<?php echo CSS_DIR;?>/style.css">
        <!-- Custom fonts go here, linked directly from google fonts -->
        <link href='http://fonts.googleapis.com/css?family=Advent+Pro:400,200|Cuprum:400,700' rel='stylesheet' type='text/css'>
        <script src="<?php echo JS_DIR;?>/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
     <header class="topbar">
        	<h1>RMH Room Reservation Maker</h1>
        	<?php 
        	//Show the menu toggle button only if the user is logged in
        	if(isset($_SESSION['logged_in'])){
        	?>
        	<?php 
        		if(isset($helpPage)){
			?>
        			<a class="helpbutton" href="<?php echo BASE_DIR."/help/".$helpPage;?>">?</a>
        		<?php
        			}
        		?>
        		<div class="navbutton">
        		<a class="btn btn-navbar" data-toggle="expand">
        	        <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
    	        </a>
            </div>
            <?php 
            }
            ?>
    </header>
<?php
if(isset($_SESSION['logged_in'])){
	include_once(ROOT_DIR.'/navigation.php');
}
?>