<?php
/*

* Copyright 2011 by Michael Pagliuca, Yue Li and Bonnie MacKellar.

* This program is part of RMH-RoomReservation-Maker, which is free software,

* inspired by the RMH Homeroom Project.

* It comes with absolutely no warranty.  You can redistribute and/or

* modify it under the terms of the GNU Public License as published

* by the Free Software Foundation (see <http://www.gnu.org/licenses/).

*/

 

/*

* SearchReservations module for RMH-RoomReservationMaker. 

* Searches through Reservations table for specified terms and displays
* them in a table format

* @author Michael Pagliuca, Yue Li

* @version May 2, 2012

*/

session_start();
session_cache_expire(30);

$title = "Search Reservations";

include('../header.php');
include(ROOT_DIR.'/database/dbReservation.php');

$showReservation = false;

    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        $showReservation = true;
   
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
            $Reservations = array();
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
            $Reservations = array();
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
            $Reservations = array();
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
            $Reservations = array();
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

           <select class="formt formtop"name="searchType">
               <option value = "Select Search Type">Select Search Type</option>
               <option value = "Social Worker (Last Name)">Social Worker (Last Name)</option>
               <option Value = "Staff Approver (Last Name)">Staff Approver (Last Name)</option>
               <option value = "Family (Last Name)">Family (Last Name)</option>
               <option value = "Status">Status</option>
           </select>
           
           <input class="formt formbottom"  onfocus="if(this.value == '') { this.value = ''; }"type="text" name="searchParam" value="" size="10" />
           
           
           <br>
           <br>
           
           <input class="formsubmit"type="submit" value="Search" name="enterSearch" />
           
       </form>
        <?php
        if ($showReservation == true)
        {
            $type = $_POST['searchType'];
            $foundReservations = searchForReservations();
            
            if(empty($foundReservations))
            {
                echo "<br>No data matches your selections ";
            
            }
            else
            {
       
        echo '<br>';
        
        echo '<br><br>
            <table border = "2" cellspacing = "10" cellpadding = "10">';       
        echo '<thead>
            <tr>
            <th>Request ID</th>
            <th>Social Worker  Name</th>
            <th>Staff  Name</th>
            <th>Parent  Name</th>
           <th>Reservation creation date </th>
           <th>Begin Date</th>
           <th>End Date</th>
           <th>Status</th>
           <th>Modify</th>
           
            </thead>
            <tbody>';
        
        if($type=="Request ID")
        {
        $rmhRequestID= $foundReservations->get_roomReservationRequestID();
        $rmhSocialWorkerName = $foundReservations->get_swLastName().", ".$foundReservations->get_swFirstName();
       $rmhStaffName = $foundReservations->get_rmhStaffLastName().", ".$foundReservations->get_rmhStaffFirstName();
        $rmhparentName= $foundReservations->get_parentLastName().", ".$foundReservations->get_parentFirstName();
       $rmhDatasubmit = $foundReservations->get_rmhDateStatusSubmitted();
       $rmhbeginDate=$foundReservations->get_beginDate();
       $rmhEndDate=$foundReservations->get_endDate();
       $rmhStatus = $foundReservations->get_status();
       
       echo '<tr>';
       echo '<td>'.$rmhRequestID.'</td>';
       echo '<td>'.$rmhSocialWorkerName.'</td>';
       echo '<td>'.$rmhStaffName.'</td>';
       echo '<td>'.$rmhparentName.'</td>';
       echo '<td>'.$rmhDatasubmit.'</td>';
       echo '<td>'.$rmhbeginDate.'</td>';
       echo '<td>'.$rmhEndDate.'</td>';
       echo '<td>'.$rmhStatus.'</td>';
       if(getUserAccessLevel() > 1)
       {
           //if the user is an approver, let the user modify the status
           $link = '<a href="'.BASE_DIR.'/reservation/activity.php?type=reservation&request='.$rmhRequestID.'">'."Change Status".'</a>';
           
           echo '<td>'.$link.'</td>';
       }
       else
           echo '<td>'.$rmhStatus.'</td>';
       
     
      
       echo '</tr>';
       
        }
        else
        {

       foreach($foundReservations as $reservation)
       {
           
        $rmhRequestID= $reservation->get_roomReservationRequestID();
        $rmhSocialWorkerName = $reservation->get_swLastName().", ".$reservation->get_swFirstName();
        $rmhStaffName = $reservation->get_rmhStaffLastName().", ".$reservation->get_rmhStaffFirstName();
        $rmhparentName= $reservation->get_parentLastName().", ".$reservation->get_parentFirstName();
        $rmhDatasubmit=$reservation->get_rmhDateStatusSubmitted();
        $rmhbeginDate=$reservation->get_beginDate();
        $rmhEndDate=$reservation->get_endDate();
        $rmhStatus = $reservation->get_status();
      
       
       echo '<tr>';
       echo '<td>'.$rmhRequestID.'</td>';
       echo '<td>'.$rmhSocialWorkerName.'</td>';
       echo '<td>'.$rmhStaffName.'</td>';
       echo '<td>'.$rmhparentName.'</td>';
       echo '<td>'.$rmhDatasubmit.'</td>';
       echo '<td>'.$rmhbeginDate.'</td>';
       echo '<td>'.$rmhEndDate.'</td>';
       
       if(getUserAccessLevel() > 1)
       {
           //if the user is an approver, let the user modify the status
           $link = '<a href="'.BASE_DIR.'/reservation/activity.php?type=reservation&request='.$rmhRequestID.'">'.$rmhStatus.'</a>';
           
           echo '<td>'.$link.'</td>';
       }
       else
           echo '<td>'.$rmhStatus.'</td>';
      
       
      
       echo '</tr>';
       
       
       
        }
        
        echo '</table>';
        }
           
           echo "<div size=18><br>Which one do you want to modify? (Choose by Request ID): <input  
                       type='text' 
                       name='ID' 
                       placeholder='Request ID'
                      /></div><br>";
            
          
               if(isset($_POST['ID']))
               {
                    if(($_POST['ID'] == "")) echo "There is no reservation with this request ID";
                    $ReqID = $_POST['ID'];
                $found=0;
                foreach($foundReservations as $reservation)
                {
                    $ID= $reservation->get_roomReservationRequestID();
                    if ($ID == $ReqID) $found = 1;
                }
                if($found ==1) 
                    $_SESSION['ReqID'] = $ReqID;
                else echo "There is no reservation with this request ID";
               }
            $buttonEdit = "<a href='../reservation/EditReservation.php' style='color: white' <input type='submit' name='edit' class='formsubmit' '/> Edit </a>";
            $buttonDelete = " <input class='formsubmit' id='php_button' type='submit' value='Delete' >";
    
                    echo $buttonEdit;
                    echo $buttonDelete;
              
        }

        }
        
        ?>
       
<?php 
include (ROOT_DIR .'/footer.php');
?>
