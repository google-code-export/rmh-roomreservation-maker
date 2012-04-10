<?php
    include('core/config.php');
    include('core/globalFunctions.php');
    include('core/sessionManagement.php');

 /**
  * generateTokenField function that generates a token field for the form and stores it in the session for validating it later
  * 
  * @return string a unique token that can be used in the form
  * @author Prayas Bhattarai
  */  
  function generateTokenField()
  {
      $token = generateRandomString();
      $_SESSION['_token'] = $token;
      return '<input type="hidden" id="form_token" name="form_token" value="'.$token.'" />';
  }
  
  /**
   * validateTokenField function that will check the validity of the form data that was submitted depending on the form token
   * 
   * @return boolean true if validates, false if it does not. 
   */
  function validateTokenField($postData)
  {
      if(array_key_exists('form_token', $postData))
      {
          if(isset($_SESSION['_token']) && ($_SESSION['_token'] == $postData['form_token']))
          {
              unset($_SESSION['_token']); //remove the token once it's been used, making it invalid for reuse
              return true;
          }
          else
          {
              return false;
          }
      }
      else
      {
          return false;
      }
  }
    
  /**
		 * Set our permission array for families, social workers, room reservation managers, and 
                 * administrators. If a page is not specified in the permission array, anyone logged into 
                 * the system can view it. If someone logged into the system attempts to access a page above their
		 * permission level, they will be sent back to the home page.
		 */
                $permission_array = array();
		//pages families can view
		$permission_array['index.php']=1;
                
                $permission_array['login.php']=0; //login page is viewable by everyone
              
		//additional pages social workers can view
                
		$permission_array['referralForm.php']=1;
                $permission_array['profileChangeForm.php']=1;
                $permission_array['ProfileChange.php']=1;
                $permission_array['SearchReservations.php']=1;
		//more pages
                           
                //additional pages room reservation managers can view
		$permission_array['roomLog.php']=2;
		//more pages
         
		//additional pages administrators can view
		$permission_array['log.php']=3;
		//more pages
                
                //password reset page (available to everyone)
                $permission_array['reset.php']=0;
                
                //logout page
		$permission_array['logout.php']=1;
                
                //reporting page
                $permission_array['reportForm.php']=1;

		//Check if they're at a valid page for their access level.
		$current_page = getCurrentPage();
  
    $header_content = ''; //This variable stores all the content that needs to be displayed on the browser.
	//Log-in security
	//If they aren't logged in, display our log-in form.
	if(!isset($_SESSION['logged_in']) && $permission_array[$current_page] != 0){
           //Redirect to the login page only if the current page is NOT viewable by the world AND the logged in session variable is not set
            
            header('Location: login.php'); 
            exit();
	}
        else if(isset($_SESSION['logged_in']) && ($current_page == 'login.php' || $current_page == 'reset.php'))
        {
            //if the current page is login.php || reset.php && the user is logged in, then redirect to the index.php page
            header('Location: index.php');
            exit();
        }
	else if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
             //if user is logged in start the permission check
		if(!isset($permission_array[$current_page]) || $permission_array[$current_page]>$_SESSION['access_level']){
			//in this case, the user doesn't have permission to view this page.
			//we redirect them to the index page.
                        header('Location: index.php');
			//echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
			//note: if javascript is disabled for a user's browser, it would still show the page.
			//so we die().
			die();
		}

		//This line gives us the path to the html pages in question, useful if the server isn't installed @ root.
		$path = strrev(substr(strrev($_SERVER['SCRIPT_NAME']),strpos(strrev($_SERVER['SCRIPT_NAME']),'/')));

		//they're logged in and session variables are set.
		$header_content = '<a href="'.$path.'index.php">home</a> | ';
		$header_content .= '<a href="'.$path.'about.php">about</a>';
		if ($_SESSION['access_level']==0) // clients
		    $header_content .= '<a href="referralForm.php?id=new'.'"> | room request</a>';
		
		if($_SESSION['access_level']>=1) // social workers and managers 
		{	
		    $header_content .= '| <strong>bookings and referrals:</strong> <a href="'.$path.'viewBookings.php?id=pending">view,</a> <a href="'.BASE_DIR.'/SearchReservations.php">search</a>' . 
			                                    '<a href="referralForm.php?id=new'.'">, new referral</a>';
		    $header_content .= '<br> <strong>people :</strong> <a href="'.$path.'view.php">view,</a> <a href="'.$path.'searchPeople.php">search</a>';
                    $header_content .= '<a href="personEdit.php?id='.'new'.'">, add</a> ';
		}
	    if($_SESSION['access_level']==3) { // managers
	        $header_content .= '| <a href="'.$path.'log.php">log</a> | <a href="'.$path.'data.php?date=11-01-01&enddate='.date('y-m-d').'">data</a>';
	    }
		if($_SESSION['access_level']>=1) { // volunteers, social workers, and managers
		    $header_content .= '<br><a href="roomLog.php?date=today">room logs</a>';
                    $header_content .=' | <a href="'.$path.'help.php?helpPage='.$current_page.'" target="_BLANK">help</a>';
		}
		$header_content .= ' | <a href="'.$path.'logout.php">logout</a> <br>';
	}
        

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo (isset($title) ? $title : 'Welcome') . ' | RMH Room Reservation Maker'; ?> </title>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="<?php echo CSS_DIR;?>/style.css">
    </head>
<body class="<?php // $_ENV['/**browser **/'] ?>">

<div id="header">
    <h1>Welcome to RMH Reservation Maker!</h1>
    <?php echo $header_content; ?>
</div>