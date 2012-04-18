<?php

//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Search Bookings"; //This should be the title for the page, included in the <title></title>

include('header.php'); //including this will further include (globalFunctions.php and config.php)
include('database/dbReservation.php');
include('navigation.php');

    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        $type = $_GET("searchType");
        $search = $_GET("searchParam");
        
        if ($type=="Request ID")
        {                       
            retrieve_RoomReservationActivity($search);  
            return $theRequests;
        }
        
        else if ($type=="Social Worker (Last Name)")
        {
            retrieve_SocialWorkerLastName_RoomReservationActivity(search);
            return $theRequests;
        }
        
        else if ($type=="Staff Approver (Last Name)")
        {
            retrieve_RMHStaffLastName_RoomReservationActivity($search);
            return $theRequests;
        }
        
        else if ($type=="Family (Last Name)")
        {
            retrieve_FamilyLastName_RoomReservationActivity($search);
            return $theRequests;
        }
        
        else if ($type=="Status")
        {
            if($search=="unconfirmed")
            {
                retrieve_Unconfirmed_RoomReservationActivity;
                return $theRequests;
            }
            
            else if ($search=="confirmed")
            {
                retrieve_Confirm_RoomReservationActivity;
                return $theRequests;
            }
            
            else if ($search=="denied")
            {
                retrieve_Deny_RoomReservationActivity;
                return $theRequests;
            }
            
            else
            {
                echo("Please enter valid status. (unconfirmed, confirmed, or denied)");
            }
            
        }
        
    }
    
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
      
        echo('The request could not be completed: security check failed!');

    }
    else
    {
       
    }
        

?>

<div id="container">

    <div id="content">
        
       <form name="searchBookings" method="post" action="searchBookings.php">
            <?php echo generateTokenField(); ?>
           
           <select name="searchType">
               <option>Request ID</option>
               <option>Social Worker (Last Name)</option>
               <option>Staff Approver (Last Name)</option>
               <option>Family (Last Name)</option>
               <option>Status</option>
           </select>
           
           <input type="text" name="searchParam" value="Enter Search If Needed" size="10" />
          
       </form>

    </div>
</div>
<?php 
include ('footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
?>

