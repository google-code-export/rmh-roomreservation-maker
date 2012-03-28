<?php
/*
 * Copyright 2011 by Alex Lucyk, Jesus Navarro, and Allen Tucker.
 * This program is part of RMH Homeroom, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
session_start();
session_cache_expire(30);
include_once(dirname(__FILE__)."/database/dbBookings.php");
include_once(dirname(__FILE__)."/database/dbRooms.php");
include_once(dirname(__FILE__)."/database/dbPersons.php");
include_once(dirname(__FILE__)."/domain/Room.php");
include_once(dirname(__FILE__)."/domain/Booking.php");
include_once(dirname(__FILE__)."/domain/OccupancyData.php");
?>
<html>
<head>
<title>Room occupancy data</title>
<!--  Choose a style sheet -->
<link rel="stylesheet" href="styles.css" type="text/css" />
<link rel="stylesheet" href="calendar.css" type="text/css" />
</head>
<!-- Body portion starts here -->
<body>
	<div id="container">
		<!--  the header usually goes here -->
		<?php include_once("header.php");?>
		<div id="content">
			<!-- content goes here -->
			<?php 
			// Get start and end dates for reporting
			// Filter the date for any nasty characters that will break SQL or html
			//$enddate = trim(str_replace('\\\'','',htmlentities(str_replace('&','and',$_GET['date']))));
			// Check if a custom date was submitted
			if($_POST['submit'] == "Submit"){
			    $endDay = $_POST['endday'];
				$endMonth = $_POST['endmonth'];
				$endYear = $_POST['endyear'];
				
				if($endDay && $endMonth && $endYear){
					// construct a date string
					$enddate = $endYear."-".$endMonth."-".$endDay;
					//sanitize it again just in case
					$enddate = trim(str_replace('\\\'','',htmlentities(str_replace('&','and',$enddate))));
				}
				else $enddate = $_GET['enddate'];
				$dateDay = $_POST['day'];
				$dateMonth = $_POST['month'];
				$dateYear = $_POST['year'];
				
				if($dateDay && $dateMonth && $dateYear){
					// construct a date string
					$date = $dateYear."-".$dateMonth."-".$dateDay;
					//sanitize it again just in case
					$date = trim(str_replace('\\\'','',htmlentities(str_replace('&','and',$date))));
				}
				else $date = $_GET['date'];   
			}
			else{
				// no date submitted, so set $date and $enddate to today
				$date = $_GET['date'];
				$enddate = $_GET['enddate'];
			}		
			$od = new OccupancyData($date, $enddate);
			$formattedDate = date("m-d-y",strtotime($date));
			$formattedEndDate = date("m-d-y",strtotime($enddate));
			    
			// String of this date, including the weekday and such
			if ($od instanceof OccupancyData){
				include_once("dataView.inc");
			}else{
				echo ("<h3>Occupancy Data for ".
					$formattedDate." to ".$formattedEndDate." not found</h3><br>");
			}
			export_data($od, $date, $enddate, $formattedDate, $formattedEndDate);	
			// options to export data or select a different date range
			show_options();	
			?>
			<!--  the footer goes here now -->
			<?php include_once("footer.inc");?>
		</div>
	</div>
</body>
</html>

<?php 
function export_data ($od, $date, $enddate, $formattedDate, $formattedEndDate) {
	// download the data to the desktop
	$filename = "dataexport.csv";
	$handle = fopen($filename, "w");
	$myArray = array("Occupancy ", "Data for ",$formattedDate." to ", $formattedEndDate);
	fputcsv($handle, $myArray);
				
	$bc = $od->get_booking_counts();
	$gc = $od->get_guest_counts();
	$myArray = array("Room #", "Bookings", "Nights", "Guests");
	fputcsv($handle, $myArray);
	foreach ($od->get_room_counts() as $room_no=>$count){
		$myArray = array($room_no, $bc[$room_no], $count, $gc[$room_no]);
		fputcsv($handle, $myArray);
	}
	$gc = $od->get_address_guest_counts();
	$myArray = array("State/County", "Bookings", "Guests");
	fputcsv($handle, $myArray);
	foreach ($od->get_address_counts() as $zip=>$count){
		$myArray = array($zip, $count, $gc[$zip]);
		fputcsv($handle, $myArray);
	}
	$gc = $od->get_age_guest_counts();
	$myArray = array("Patient Age", "Bookings", "Guests");
	fputcsv($handle, $myArray);
	foreach ($od->get_age_counts() as $age=>$count){
		$myArray = array($age, $count, $gc[$age]);
		fputcsv($handle, $myArray);
	}
	$gc = $od->get_hospital_guest_counts();
	$myArray = array("Hospital", "Bookings", "Guests");
	fputcsv($handle, $myArray);
	foreach ($od->get_hospital_counts() as $hospital=>$count){
		$myArray = array($hospital, $count, $gc[$hospital]);
		fputcsv($handle, $myArray);
	}
	fclose($handle);
	echo ("<br />"); // new line break
	echo("These data have been exported to the file <strong>".$filename."</strong><br> Browse to this file to download it.");
}
// Function that displays date range for statistics
function show_options(){
	echo ("<br />"); // new line break
	echo ("<form name=\"chooseDate\" method=\"post\">");
	echo ("<p style=\"text-align:left\">");
	echo ("For more data, choose a different<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;start date ");
	echo ("M: <select name=\"month\">");
	echo ("<option value=''></option>");
	for($i = 1; $i<=12; $i++){
		echo ("<option value=\"");
		if($i < 10){
			echo ("0".$i."\">".$i."</option>");
		}else{
			echo($i."\">".$i."</option>");
		}
	}
	echo ("</select>");
	
	echo (" D: <select name=\"day\">");
	echo ("<option value=''></option>");
	for($i = 1; $i<=31; $i++){
		echo ("<option value=\"");
		if($i < 10){
			echo ("0".$i."\">".$i."</option>");
		}else{
			echo($i."\">".$i."</option>");
		}
	}
	echo ("</select>");
	echo (" Y: <input type=\"text\" size=\"3\" maxLength=\"2\" name=\"year\"/>");
	
	echo ("<br>and/or end date ");
	echo ("M: <select name=\"endmonth\">");
	echo ("<option value=''></option>");
	for($i = 1; $i<=12; $i++){
		echo ("<option value=\"");
		if($i < 10){
			echo ("0".$i."\">".$i."</option>");
		}else{
			echo($i."\">".$i."</option>");
		}
	}
	echo ("</select>");
	
	echo (" D: <select name=\"endday\">");
	echo ("<option value=''></option>");
	for($i = 1; $i<=31; $i++){
		echo ("<option value=\"");
		if($i < 10){
			echo ("0".$i."\">".$i."</option>");
		}else{
			echo($i."\">".$i."</option>");
		}
	}
	echo ("</select>");
	echo (" Y: <input type=\"text\" size=\"3\" maxLength=\"2\" name=\"endyear\"/>");
	
	echo ("<br>and hit ");
	echo ("<input type=\"submit\" name=\"submit\" value=\"Submit\"/>");
	echo ("</form>");
}
?>
