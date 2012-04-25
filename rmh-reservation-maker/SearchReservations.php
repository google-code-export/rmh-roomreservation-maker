<?php

session_start();
session_cache_expire(30);

$title = "Search Reservations";

include('header.php');
include(ROOT_DIR.'/database/dbReservation.php');
//include(ROOT_DIR.'/navigation.php');

    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        $foundReservations = searchForReservations();       
    }
    
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
      
        echo('The request could not be completed: security check failed!');

    }
    else
    {
       
    }
     
    
    function searchForReservations()
    {
        $type = ($_POST['searchType']);
        
        if ($type=="Select Search Type")
        {
            echo ("Please choose what you're searching for from the drop down menu below.");
        }
        
        else if ($type=="Request ID")
        {                       
            $roomReservationRequestId = ($_POST["searchParam"]);
            $Reservations = retrieve_RoomReservationActivity_byRequestId($roomReservationRequestId);
            return $Reservations;
            
            if (!$Reservations)
            {
                echo ("No reservations found! Try entering your search again.");
            }
        }
        
        else if ($type=="Social Worker (Last Name)")
        {
            $socialWorkerLastName = ($_POST["searchParam"]);
            $Reservations = (retrieve_SocialWorkerLastName_RoomReservationActivity($socialWorkerLastName));
            return $Reservations;
            
            if (!$Reservations)
            {
                echo ("No reservations found! Try entering your search again.");
            }
        }
        
        else if ($type=="Staff Approver (Last Name)")
        {
            $rmhStaffLastName = ($_POST["searchParam"]);
            $Reservations = (retrieve_RMHStaffLastName_RoomReservationActivity($rmhStaffLastName));
            return $Reservations;
            
            if (!$Reservations)
            {
                echo ("No reservations found! Try entering your search again.");
            }
        }
        
        else if ($type=="Family (Last Name)")
        {
            $parentLastName = ($_POST["searchParam"]);
            $Reservations = (retrieve_FamilyLastName_RoomReservationActivity($parentLastName));
            return $Reservations;
            
            if (!$Reservations)
            {
                echo ("No reservations found! Try entering your search again.");
            }
        }
        
        else if ($type=="Status")
        {
            $status = ($_POST["searchParam"]);
            $Reservations = (retrieve_RoomReservationActivity_byStatus($status));
            return $Reservations;
            
            if (!$Reservations)
            {
                echo ("No reservations found! Try entering your search again.");
            }
        }
        
    }

?>

<div id="container">

    <div id="content">
        
       <form name="SearchReservations" method="post" action="SearchReservations.php">
            <?php echo generateTokenField(); ?>
           
           <select name="searchType">
               <option value = "Select Search Type">Select Search Type</option>
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
include ('footer.php');
?>

