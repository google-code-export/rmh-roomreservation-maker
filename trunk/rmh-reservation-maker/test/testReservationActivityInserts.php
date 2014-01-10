<?php
include('../core/config.php');
include_once (ROOT_DIR.'/database/dbReservation.php');

echo ">>>DIRECTORY: ".ROOT_DIR.'/database/dbReservation.php <br><br>';
//retrieve_all_RoomReservationActivity_byHospitalAndDate($hospitalAffiliation, $beginDate, $endDate)
echo "////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////"."</br>";

echo ">>>TESTING: insert_RoomReservationActivity, expect success"."</br>";

$reservation = new Reservation(1, 1, 1, 4, "Jones", "John", "Jones", "Jimmy",1, "Tove", "Mary", 1, "Shen", "Tian", 
        "2012-11-27 18:22:43", "2012-01-12 17:22:43", "Apply", "Confirmed", "2012-11-27 16:22:12", 
        "2012-11-30 12:00:00", "Leukemia", "Allergic to Pollen" );
test_insert_RoomReservationActivity($reservation);

$reservation = new Reservation(1, 1, 1, 4, "Jones", "John", "Jones","Jimmy",1, "Tove", "Mary", 1, "Shen", "Tian", 
        "2012-11-27 18:22:43", "2012-01-12 17:22:43", "Modify", "Confirmed", "2012-11-26 16:22:12", 
        "2012-11-29 12:00:00", "Leukemia", "Allergic to Pollen" );
test_insert_RoomReservationActivity($reservation);

$reservation = new Reservation(1, 1, 1, 4, "Jones", "John", "Jones", "Jimmy",1, "Tove", "Mary", 1, "Shen", "Tian", 
        "2012-11-27 18:22:43", "2012-01-12 17:22:43", "Modify", "Confirmed", "2012-11-27 16:22:12", 
        "2012-11-30 12:00:00", "Leukemia", "Allergic to Cats" );
test_insert_RoomReservationActivity($reservation);


function test_insert_RoomReservationActivity($reservation){
    
    $ActivityType = $reservation->get_ActivityType();
    $retVal=insert_RoomReservationActivity($reservation);
    if ($retVal > 0)
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
    
 function display_reservation($reservation)
{
    echo " Room Reservation Key is: " . $reservation->get_roomReservationKey() . "</br>";
    echo " Room Reservation Activity ID is: " . $reservation->get_roomReservationActivityID() .  "</br>";
    echo " Room Reservation Request ID is: " . $reservation->get_roomReservationRequestID().  "</br>";
    echo " Family Profile ID is: " . $reservation->get_familyProfileId().  "</br>";
    echo " Parent Last Name is: " . $reservation->get_parentLastName() . "</br>";
    echo " Parent First Name is: " . $reservation->get_parentFirstName() .  "</br>";
    echo " Patient Last Name is: " . $reservation->get_patientLastName() . "</br>";
    echo " Patient First Name is: " . $reservation->get_patientFirstName() .  "</br>";
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
?>
