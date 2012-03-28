<?php 
/*
 * Copyright 2011 by Alex Lucyk, Jesus Navarro, and Allen Tucker.
 * This program is part of RMH Homeroom, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

// Get the array of rooms
$rooms = $roomLog->get_rooms();
?>

<!-- THIS SECTION PRINTS OUT THE 21 ROOMS AND THEIR INFORMATION -->
<?php 
echo ("<table align=\"center\">");

// Use loops to construct each table row and column
for($i = 0; $i < 3; $i++){
	// Three rows
	echo ("<tr>");
	for($j = 0; $j < 7; $j++){
		// Retrieve the current room
		$currentRoomID = substr($rooms[($i*7)+$j],0,3);
		$currentBookingID = substr($rooms[($i*7)+$j],4);
		//echo ($currentRoomID);
		//echo ($currentBookingID);
		$currentRoom = retrieve_dbRooms($currentRoomID);
		$currentBooking = retrieve_dbBookings($currentBookingID);
		
		// This begins a "link" where the link is actually
		// the entire box. It only does this if date is
		// today or later
		if(strcmp($date,date("y-m-d")) >=0){
			echo ("<td id=\"nav\" onclick=\"window.location.href='room.php?room=".$currentRoomID."'\"");
			echo ("style=\"vertical-align:text-top\">");
		}else{
			echo ("<td style=\"vertical-align:text-top\">");
		}

		// The ID of the room and the status
		echo ("<b style=\"float:left\">".$currentRoomID."</b>");
		// Print the status of the room
		$roomStatus = $currentRoom->get_status();
		$statusColor = null;
		// Change the color depending on the status
		if($roomStatus == "clean"){
			$statusColor = "green";
		}else if($roomStatus == "dirty"){
			$statusColor = "brown";
		}else if($roomStatus == "booked"){
			$statusColor = "red";
		}else if($roomStatus == "off-line"){
			$statusColor = "blue";
		}
		echo ("<b style=\"float:right; color:".$statusColor."\">");
		echo ($roomStatus."</b>");
		// echo <br /> is for a new line
		echo ("<br />");

		// Print the capacity of the room
		// echo ("<b>Capacity: </b>".$currentRoom->get_capacity());
		// echo ("<br />");
		
		// Print the beds in the room
		echo("<b>Beds: </b>".$currentRoom->get_beds());
		// Print if there is a private bath
		if($currentRoom->get_bath() == "y"){
			echo (" bath");
		}
		if($currentRoom->get_room_notes() != "")
		    echo "<br /><b>Notes: </b><br>".$currentRoom->get_room_notes();
		// Display info from the booking, such as the guests and loaners
		if($roomStatus=="booked"){
			// Print the guests
			echo ("<br /><b>Guests:</b><br />");
			print_booking_info($currentBooking);
		}
		// End this table item. Finish the link if it was started
		if($date == date("y-m-d")){
			echo ("</a></td>");
		}else{
			echo ("</td>");
		}
	}
	echo ("</tr>");
}
echo ("</table>");

/**
 * These functions help in printing out information
 * about each individual room or recieving information
 * needed to print
 */


// Function that gets the booking from a room
function get_booking($room){
	// Get the booking id
	$bookingID = $room->get_booking();
	// Retrieve the booking from the database
	$newBooking = retrieve_dbBookings($bookingID);
	// return the new booking
	return $newBooking;
}

// Funtion to display the information found in a booking.
function print_booking_info($booking){

	$guests = $booking->get_occupants();
	// Print each occupant
	foreach($guests as $currentGuest){
		echo ($currentGuest."<br />");
	}

	// Print the patient associated with the booking
	$patient = $booking->get_patient();
	echo ("<b>Patient: </b><br />".$patient);

	// print the loaners associated with the booking
//	$loaners = $booking->get_loaners();
//	echo ("<b>Loaners: </b><br />");
//	foreach($loaners as $loaner){
//		echo ($loaner."<br /> ");
//	}
	echo ("<br />");
}
?>
<!-- END OF THE SECTION THAT PRINTS OUT THE 21 ROOMS -->