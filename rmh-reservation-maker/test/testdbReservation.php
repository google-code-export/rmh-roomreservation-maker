<?php

include('../core/config.php');
include_once (ROOT_DIR.'/database/dbReservation.php');

echo ">>>DIRECTORY: ".ROOT_DIR.'/database/dbReservation.php <br><br>';
//retrieve_all_RoomReservationActivity_byHospitalAndDate($hospitalAffiliation, $beginDate, $endDate)
echo "////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////"."</br>";
echo ">>>TESTING: retrieve_all_dbRoomReservationActivity_byHospitalAndDate, expect one Reservation to be found.". "</br>";
test_retrieve_all_dbRoomReservationActivity_byHospitalAndDate("Memorial Sloan-Kettering Cancer Center", "2012-04-15", "2012-04-17");

echo ">>>TESTING: retrieve_all_dbRoomReservationActivity_byHospitalAndDate, expect no Reservation to be found.". "</br>";
test_retrieve_all_dbRoomReservationActivity_byHospitalAndDate("New York Hospital Queens", "2012-04-15", "2012-04-17");

function test_retrieve_all_dbRoomReservationActivity_byHospitalAndDate($hospitalAffiliation, $beginDate, $endDate)
{
    $reservations = retrieve_all_RoomReservationActivity_byHospitalAndDate($hospitalAffiliation, $beginDate, $endDate);

if ($reservations == false)
    echo "</br>". "No Reservations were Found.". "</br>";
else
{
    
    echo  "</br>". "Records Found:".  "</br>";
    
    foreach ($reservations as $reservation)
    {
         display_reservation($reservation);
    }
}
}

function display_reservation($reservation)
{
    echo " Room Reservation Key is: " . $reservation->get_roomReservationKey() . "</br>";
    echo " Room Reservation Activity ID is: " . $reservation->get_roomReservationActivityID() .  "</br>";
    echo " Room Reservation Request ID is: " . $reservation->get_roomReservationRequestID().  "</br>";
    echo " Family Profile ID is: " . $reservation->get_familyProfileId().  "</br>";
    echo " Parent Last Name is: " . $reservation->get_parentLastName() . "</br>";
    echo " Parent First Name is: " . $reservation->get_parentFirstName() .  "</br>";
    echo " Social Worker Profile ID is: " . $reservation->get_socialWorkerProfileId().  "</br>";
    echo " Social Worker Last Name is: " . $reservation->get_swLastName().  "</br>";
    echo " Social Worker First Name is: " . $reservation->get_swFirstName() . "</br>";
    echo " RMH Staff Profile ID is: " . $reservation->get_rmhStaffProfileId() . "</br>";
    echo " RMH Staff Last Name is: " . $reservation->get_rmhStaffLastName() . "</br>";
    echo " RMH Staff First Name is: " . $reservation->get_rmhStaffFirstName() . "</br>";
    echo " Social Worker Date Status Submitted is: " . $reservation->get_swDateStatusSubmitted() . "</br>";
    echo " RMH Date Status Submitted is: " . $reservation->get_rmhDateStatusSubmitted() . "</br>";
    echo " Activity Type is: " . $reservation->get_activityType() . "</br>";
    echo " Status is: " . $reservation->get_status() . "</br>";
    echo " Begin Date is: " . $reservation->get_beginDate() . "</br>";
    echo " End Date is: " . $reservation->get_endDate() . "</br>";
    echo " Patient Diagnosis is: " . $reservation->get_patientDiagnosis() . "</br>";
    echo " Room Note is: " . $reservation->get_roomnote() . "</br>";
    echo "////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////"."</br></br>";
    
}
echo "////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////"."</br></br>";
echo ">>>TESTING: retrieve_all_dbRoomReservationActivity_byDate, expect five Reservations to be found.". "</br>";
test_retrieve_all_dbRoomReservationActivity_byDate("2012-03-01", "2012-05-01");

echo ">>>TESTING: retrieve_all_dbRoomReservationActivity_byDate, expect no Reservations to be found.". "</br>";
test_retrieve_all_dbRoomReservationActivity_byDate("2012-06-01", "2012-07-01");

function test_retrieve_all_dbRoomReservationActivity_byDate($beginDate, $endDate)
{
    $reservations = retrieve_all_RoomReservationActivity_byDate($beginDate, $endDate);

if ($reservations == false)
    echo "</br>". "No Reservations were Found.". "</br></br></br>";
  
else
{
    
    echo  "</br>". "Records Found:".  "</br>";
   
    foreach ($reservations as $reservation)
    {
         display_reservation($reservation);
    }
}
}


echo"////////////////////////////////////////////////////////////////////////////////////////////////////"."</br>";
echo ">>>TESTING: insert_RoomReservationActivity, expect success"."</br>";

$reservation = new Reservation(1, 1, 1, 4, "Jones", "John", 1, "Tove", "Mary", 1, "Shen", "Tian", 
        "2012-11-27 18:22:43", "2012-01-12 17:22:43", "Apply", "Confirmed", "2012-11-27 16:22:12", 
        "2012-11-30 12:00:00", "Leukemia", "Allergic to Pollen" );
test_insert_RoomReservationActivity($reservation);

$reservation = new Reservation(1, 1, 1, 4, "Jones", "John", 1, "Tove", "Mary", 1, "Shen", "Tian", 
        "2012-11-27 18:22:43", "2012-01-12 17:22:43", "Modify", "Confirmed", "2012-11-26 16:22:12", 
        "2012-11-30 12:00:00", "Leukemia", "Allergic to Pollen" );
test_insert_RoomReservationActivity($reservation);

$reservation = new Reservation(1, 1, 1, 4, "Jones", "John", 1, "Tove", "Mary", 1, "Shen", "Tian", 
        "2012-11-27 18:22:43", "2012-01-12 17:22:43", "Modify", "Confirmed", "2012-11-27 16:22:12", 
        "2012-11-30 12:00:00", "Leukemia", "Allergic to Cats" );
test_insert_RoomReservationActivity($reservation);





function test_insert_RoomReservationActivity($reservation){
    
    $ActivityType = $reservation->get_ActivityType();
    $retVal=insert_RoomReservationActivity($reservation);
    if ($retVal == true)
        echo "</br> Insert succeeded </br>";
    else
        echo "</br> Insert failed </br>";
    if ($ActivityType == "Apply"){
        echo "Apply"."</br>";
        echo "RoomReservationActivityID: ".$reservation->get_roomReservationActivityID()."</br>";
        echo "RoomReservationRequestID: ".$reservation->get_roomReservationRequestID()."</br>";
    }
    else {
        echo "Modify or Cancel"."</br>";
        echo "RoomReservationActivityID: <b>".$reservation->get_roomReservationActivityID()."</br></b>";
        echo "RoomReservationRequestID: <b>".$reservation->get_roomReservationRequestID()."</br></b>";
    }
    }






/*
echo ">>>TESTING: insert_ReservationChange, ". "</br>";
test_insert_ReservationChange(4);

function test_insert_ReservationChange($roomReservationRequestID){
    
}
*/
?>