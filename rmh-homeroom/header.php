<!--
/*
 * Copyright 2011 by Alex Lucyk, Jesus Navarro, and Allen Tucker.
 * This program is part of RMH Homeroom, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
-->

<style type="text/css">
h1 {padding-left: 0px; padding-right:165px;}
</style>
<div id="header">
<!--<br><br><img src="images/rmhHeader.gif" align="center"><br>
<h1><br><br>RMH Homebase <br></h1>-->

</div>

<div align="center" id="navigationLinks">

<?PHP
	//Log-in security
	//If they aren't logged in, display our log-in form.
	if(!isset($_SESSION['logged_in'])){
		include('login_form.php');
		die();
	}
	else if($_SESSION['logged_in']){

		/**
		 * Set our permission array for guests, volunteers, social workers, and managers.
		 * If a page is not specified in the permission array, anyone logged into the system
		 * can view it. If someone logged into the system attempts to access a page above their
		 * permission level, they will be sent back to the home page.
		 */
		//pages clients can view
		$permission_array['index.php']=0;
		$permission_array['about.php']=0;
		$permission_array['request.php']=0;
		//pages volunteers can view
		$permission_array['roomLog.php']=1;
		$permission_array['room.php']=1;
		//additional pages social workers can view
		$permission_array['referralForm.php']=2;
		$permission_array['people.php']=2;
		//additional pages managers can view
		$permission_array['log.php']=3;
		$permission_array['data.php']=3;

		//Check if they're at a valid page for their access level.
		$current_page = substr($_SERVER['PHP_SELF'],1);
		if($permission_array[$current_page]>$_SESSION['access_level']){
			//in this case, the user doesn't have permission to view this page.
			//we redirect them to the index page.
			echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
			//note: if javascript is disabled for a user's browser, it would still show the page.
			//so we die().
			die();
		}

		//This line gives us the path to the html pages in question, useful if the server isn't installed @ root.
		$path = strrev(substr(strrev($_SERVER['SCRIPT_NAME']),strpos(strrev($_SERVER['SCRIPT_NAME']),'/')));

		//they're logged in and session variables are set.
		echo('<a href="'.$path.'index.php">home</a> | ');
		echo('<a href="'.$path.'about.php">about</a>');
		if ($_SESSION['access_level']==0) // clients
		    echo('<a href="referralForm.php?id=new'.'"> | room request</a>');
		
		if($_SESSION['access_level']>=1) // social workers and managers 
		{	
		    echo(' | <strong>bookings and referrals:</strong> <a href="'.$path.'viewBookings.php?id=pending">view,</a> <a href="'.$path.'searchBookings.php">search</a>' . 
			                                    '<a href="referralForm.php?id=new'.'">, new referral</a>');
		    echo('<br> <strong>people :</strong> <a href="'.$path.'view.php">view,</a> <a href="'.$path.'searchPeople.php">search</a>');
	    	echo('<a href="personEdit.php?id='.'new'.'">, add</a> ');
		}
	    if($_SESSION['access_level']==3) { // managers
	        echo ('| <a href="'.$path.'log.php">log</a> | <a href="'.$path.'data.php?date=11-01-01&enddate='.date('y-m-d').'">data</a>');
	    }
		if($_SESSION['access_level']>=1) { // volunteers, social workers, and managers
		    echo('<br><a href="roomLog.php?date=today">room logs</a>');
			echo(' | <a href="'.$path.'help.php?helpPage='.$current_page.'" target="_BLANK">help</a>');
		}
		echo(		' | <a href="'.$path.'logout.php">logout</a> <br>');
	}
?>
</div>
<!-- End Header -->