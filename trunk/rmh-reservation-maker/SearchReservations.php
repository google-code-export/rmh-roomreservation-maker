<?php

//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Search Reservations"; //This should be the title for the page, included in the <title></title>

include('header.php'); //including this will further include (globalFunctions.php and config.php)
include(ROOT_DIR.'/database/dbReservation.php');
//include(ROOT_DIR.'/navigation.php');

    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        $type = ($_POST['searchType']);
        
        if ($type="Request ID")
        {                       
            $roomReservationRequestId = ($_POST["searchParam"]);
            echo (retrieve_RoomReservationActivity_byRequestId($roomReservationRequestId));  
            
        }
        
        else if ($type=="Social Worker (Last Name)")
        {
            $socialWorkerLastName = ($_POST["searchParam"]);
            echo (retrieve_SocialWorkerLastName_RoomReservationActivity($socialWorkerLastName));
            
        }
        
        else if ($type=="Staff Approver (Last Name)")
        {
            $rmhStaffLastName = ($_POST["searchParam"]);
            echo (retrieve_RMHStaffLastName_RoomReservationActivity($rmhStaffLastName));
            
        }
        
        else if ($type=="Family (Last Name)")
        {
            $parentLastName = ($_POST["searchParam"]);
            echo (retrieve_FamilyLastName_RoomReservationActivity($parentLastName));
            
        }
        
        else if ($type=="Status")
        {
            $status = ($_POST["searchParam"]);
            echo (retrieve_RoomReservationActivity_byStatus($status));
                   
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
        
       <form name="SearchReservations" method="post" action="SearchReservations.php">
            <?php echo generateTokenField(); ?>
           
           <select name="searchType">
               <option value = "Request ID">Request ID</option>
               <option value = "Social Worker (Last Name)">Social Worker (Last Name)</option>
               <option Value = "Staff Approver (Last Name)">Staff Approver (Last Name)</option>
               <option value = "Family (Last Name)">Family (Last Name)</option>
               <option value = "Status">Status</option>
           </select>
           
           <input type="text" name="searchParam" value="" size="10" />
           
           <br>
           <br>
           
           <input type="submit" value="Search" name="enterSearch" />
           
       </form>

    </div>
</div>
<?php 
include ('footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
?>

