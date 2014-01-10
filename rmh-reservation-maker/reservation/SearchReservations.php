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

 * @author Kristen Gentle, Bruno Constantino

 * @version December 12, 2012

 */

session_start();
session_cache_expire(30);

$title = "Search Reservations";

include('../header.php');
include(ROOT_DIR . '/database/dbReservation.php');

$showReservation = false;

// the user has filled out the first form and hit submit
// need to search for matching reservations and display
// as long as the token is valid (security check)
if (isset($_POST['form_token']) && validateTokenField($_POST)) {
    error_log("form token is set and valid");
//    $showReservation = true;

   // $type = $_POST['searchType'];
    $foundReservations = searchForReservations();

   if (empty($foundReservations)) {     
         displayErrorMsg('No data matches your selections');
    } 
    // display matching reservations
    else {
        echo '<section class="content">';
        echo '<div>';
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
           <th>Latest Activity</th>
           <th>Status</th>';
           if (getUserAccessLevel() > 1)
               echo '<th>Modify</th>';
           
            '</thead>
            <tbody>';

   

            foreach ($foundReservations as $reservation) {

                $rmhRequestID = $reservation->get_roomReservationRequestID();
                $rmhSocialWorkerName = $reservation->get_swLastName() . ", " . $reservation->get_swFirstName();
                $rmhStaffName = $reservation->get_rmhStaffLastName() . ", " . $reservation->get_rmhStaffFirstName();
                $rmhparentName = $reservation->get_parentLastName() . ", " . $reservation->get_parentFirstName();
                $rmhDatasubmit = $reservation->get_rmhDateStatusSubmitted();
                $rmhbeginDate = $reservation->get_beginDate();
                $rmhEndDate = $reservation->get_endDate();
                $rmhActivity = $reservation->get_activityType();
                $rmhStatus = $reservation->get_status();


                echo '<tr>';
                echo '<td>' . $rmhRequestID . '</td>';
                echo '<td>' . $rmhSocialWorkerName . '</td>';
                echo '<td>' . $rmhStaffName . '</td>';
                echo '<td>' . $rmhparentName . '</td>';
                echo '<td>' . $rmhDatasubmit . '</td>';
                echo '<td>' . $rmhbeginDate . '</td>';
                echo '<td>' . $rmhEndDate . '</td>';
                echo '<td>'.$rmhActivity. '</td>';
                if (getUserAccessLevel() > 1) {
                    //if the user is an approver, let the user modify the status
                    $link = '<a href="' . BASE_DIR . '/reservation/activity.php?type=reservation&request=' . $rmhRequestID . '">' . $rmhStatus . '</a>';

                    echo '<td>' . $link . '</td>';
                }
                else
                    echo '<td>' . $rmhStatus . '</td>';


                echo '</tr>';
            }

            echo '</table>';
            echo '</div>';
            
            displayChooseRequestIDDropDown($foundReservations);
        }
     


} else if (isset($_POST['form_token']) && !validateTokenField($_POST)) {

    displayErrorMsg('The request could not be completed: security check failed!');
} 
else {
    // only display the search form if the reservations are not being displayed

    error_log("this is the empty else branch");
    ?>

<section class="content">
    <div>

        <form class="generic" name="SearchReservations" method="post" action="SearchReservations.php">
		<?php echo generateTokenField(); ?>
			<div class="formRow">
			<label for="searchType">Search Type</label>
            <select id="searchType" name="searchType">
                <option value = "Select Search Type">Select Search Type</option>
                <option value = "Request ID">Request ID</option>
                <option value = "Social Worker (Last Name)">Social Worker (Last Name)</option>
                <option Value = "Staff Approver (Last Name)">Staff Approver (Last Name)</option>
                <option value = "Family (Last Name)">Family (Last Name)</option>
                <option value = "Status">Status</option>
                <option value=  "Last Activity">Last Activity For Record</option>
            </select>
			</div>
			
			<div class="formRow">
			<label for="searchParam">Search Parameter</label>
            <input id="searchParam" type="text" name="searchParam" value="" size="10" />
			</div>

			<div class="formRow">
            	<input class="btn" type="submit" value="Search" name="enterSearch" />
			</div>
        </form>
        
        

	</div>
</section>


<?php
} // end main else

// this lets the user choose a particular reservation and an action to take on the reservation
// hitting submit takes us to a different script
function displayChooseRequestIDDropDown($foundReservations)
{
    ?>
<section class="content">
<div>
  <br><br>Choose an Request ID that you desire to modify or delete: <br>
  <form class="generic" name="ChooseReservation" method="post" action="ProcessEditOrCancel.php">
<div class="formRow">
  <select name="Request">
               <option value = "Request ID">Request ID</option>
               
  <?php 
    

        $requestIDArray = array();
        foreach ($foundReservations as $reservation) {
        $requestIDArray[] = $reservation->get_roomReservationRequestID();}

        $rmhRequestID= array_values(array_unique($requestIDArray));
        
        foreach ($rmhRequestID as $reservation){
            echo '    <option value = "'.$reservation.'">'.$reservation.'</option>';
        }
        echo' </select>   
            <br>
            <input type="radio" name="actionChoice" value="edit" /> Edit Reservation
            <br>
            <input type="radio" name="actionChoice" value="cancel" /> Cancel Reservation
            <br>
            <input class="btn" type="submit" value= "Submit" name="chooseRequestID" />
            </form>
            <br><br> </div> </section>';
}

// this routine returns an array of reservation activity records
// or FALSE if something goes wrong
function searchForReservations() {
    $type = ($_POST['searchType']);
  
    if ($type == "Select Search Type") {
        echo ("Please choose what you're searching for from the drop down menu below.");
    } else if ($type == "Request ID") {
        
        $roomReservationRequestId = ($_POST["searchParam"]);
        error_log("searching  by request id = ".$roomReservationRequestId);
        $Reservation = retrieve_RoomReservationActivity_byRequestId($roomReservationRequestId);
        // retrieval routine returns just one reservation, so return an array consisting of one record
         if (!$Reservation)
         {       
             error_log("retrieve_RoomReservationActivity_byRequestID returned false");
             $Reservations = false;
         }
         else
         {
          $Reservations = array();
          $Reservations[] = $Reservation;
         }
        return $Reservations;

     /*   if (!$Reservations) {
            echo ("No reservations found! Try entering your search again.");
        } */
    } else if ($type == "Social Worker (Last Name)") {
        $socialWorkerLastName = ($_POST["searchParam"]);
      //  $Reservations = array();
        $Reservations = (retrieve_SocialWorkerLastName_RoomReservationActivity($socialWorkerLastName));
        return $Reservations;

     /*   if (!$Reservations) {
            echo ("No reservations found! Try entering your search again.");
        } */
    } else if ($type == "Staff Approver (Last Name)") {
        $rmhStaffLastName = ($_POST["searchParam"]);
     //   $Reservations = array();
        $Reservations = (retrieve_RMHStaffLastName_RoomReservationActivity($rmhStaffLastName));
        return $Reservations;

     /*   if (!$Reservations) {
            echo ("No reservations found! Try entering your search again.");
        } */
    } else if ($type == "Family (Last Name)") {
        $parentLastName = ($_POST["searchParam"]);
    
        $Reservations = (retrieve_FamilyLastName_RoomReservationActivity($parentLastName));
        return $Reservations;
    } else if ($type == "Status") {
        $status = ($_POST["searchParam"]);
        $Reservations = (retrieve_RoomReservationActivity_byStatus($status));
        return $Reservations;
    } else if ($type == "Last Activity") {
        $activity = ($_POST["searchParam"]);
         $Reservations = (retrieve_RoomReservationActivity_byLastActivity($activity));
        return $Reservations;
    }
}

function displayErrorMsg($error)
{
         echo '<section class="content">';
        echo '<div>';
        echo $error;
        echo '</div>';
        echo '</section>';
}


include (ROOT_DIR . '/footer.php');
?>