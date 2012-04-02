<!-- the header file should have includes, link tags, scripts, and anything that would be included in 
<head> normally. it should be placed in the very beginning and should hold everything from the opening
html tag, to the closing head tag/opening body tag -->


<html DOCTYPE="">
    <head>
        <title><?php echo $title . ' | RMH Room Reservation Maker'; ?> </title>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body class="<?php // $_ENV['/**browser **/'] ?>"
<div id="header">
    <h1>Welcome to RMH Homeroom!</h1>
</div>
         
<div id="container">

<?php
	//Log-in security
	//If they aren't logged in, display our log-in form.
	if(!isset($_SESSION['logged_in'])){
           // echo( "Trying to load login_form.php! ");
            include('login_form.php');            
            die();
	}
	else if($_SESSION['logged_in']){

		/**
		 * Set our permission array for families, social workers, room reservation managers, and 
                 * administrators. If a page is not specified in the permission array, anyone logged into 
                 * the system can view it. If someone logged into the system attempts to access a page above their
		 * permission level, they will be sent back to the home page.
		 */
		//pages families can view
		$permission_array['index.php']=0;
		//more pages
              
		//additional pages social workers can view
		$permission_array['referralForm.php']=1;
		//more pages
                           
                //additional pages room reservation managers can view
		$permission_array['roomLog.php']=2;
		//more pages
         
		//additional pages administrators can view
		$permission_array['log.php']=3;
		//more pages

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