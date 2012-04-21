<?php
/**
 * Functions to create, retrieve, update, and delete information from the
 * RoomReservationActivity table in the database. This table is used with the reservation class.  
 * @version April 20, 2012
 * @author Linda Shek and Gergana Stoykova
 */

include_once(ROOT_DIR.'/domain/Reservation.php');
include_once(ROOT_DIR.'/database/dbinfo.php');

/**
 * Creates a RoomReservationActivity table with the following fields:
 * RoomReservationActivityID: primary key of the RoomReservationActivity table.
 * RoomReservationRequestID: request key number for the room reservation activity
 * FamilyProfileID: id of the family
 * SocialWorkerProfileID: id of the social worker 
 * RMHStaffProfileID: id of the rmh staff
 * SW_DateStatusSubmitted: date status submitted by the social worker
 * RMH_DateStatusSubmitted: date status submitted by the rmh staff
 * ActivityType: utilized by the social worker for the room request: 'Apply','Modify','Cancel'
 * Status: utilized by the rmh staff for the room request: 'Unconfirmed','Confirm','Deny'
 * BeginDate: begin date of the room reservation for the family
 * EndDate: estimate end date of the room reservation for the family
 * PatientDiagnosis: (optional) comments on patient diagnosis
 * Notes: (optional) notes from the rmh staff/social worker
 */

//DO NOT CALL THE FUNCTION Create_RoomReservationActivity() if TABLE ALREADY EXISTS. 
/*function create_RoomReservationActivity() {
    connect();
    mysql_query("DROP TABLE IF EXISTS RoomReservationActivity");
    $result=mysql_query("CREATE TABLE RoomReservationActivity (
        RoomReservationActivityID` int NOT NULL AUTO_INCREMENT,
        RoomReservationRequestID` int NOT NULL,
        FamilyProfileID int NOT NULL,
        SocialWorkerProfileID int NOT NULL,
        RMHStaffProfileID int DEFAULT NULL,
        SW_DateStatusSubmitted datetime DEFAULT NULL,
        RMH_DateStatusSubmitted datetime DEFAULT NULL,
        ActivityType enum('Apply','Modify','Cancel') NOT NULL,
        Status enum('Unconfirmed','Confirm','Deny') NOT NULL,
        BeginDate datetime NOT NULL,
        EndDate datetime NOT NULL,
        PatientDiagnosis text,
        Notes text,
        PRIMARY KEY (RoomReservationActivityID),
        KEY SocialWorkerProfileID (SocialWorkerProfileID),
        KEY RMHStaffProfileID (RMHStaffProfileID),
        KEY FamilyProfileID (`FamilyProfileID`))");
    mysql_close();	
    if(!$result) {
		echo mysql_error() . ">>>Error creating RoomReservationActivity table. <br>";
	    return false;
    }
    return true;
}*/

/**
 * Inserts a new Room Reservation Request into the RoomReservationActivity table. This function
 * will be utilized by the social worker. 
 * @param $reservation = the reservation to insert
 */

function insert_RoomReservationActivity ($reservation){
     if (! $reservation instanceof Reservation) {
		echo ("Invalid argument for insert_RoomReservationActivity function call");
		return false;
	}
        connect();
        
        $query = "CALL GetRequestKeyNumber('RoomReservationRequestID')";
    $result = mysql_query ($query);
        if (mysql_num_rows($result)!=0) {
            
		$result_row = mysql_fetch_assoc($result); //gets the first row
                $reservation->set_roomReservationRequestID($result_row['@ID := RoomReservationRequestID']);	
    }	
        
     mysql_close();  
     
     $query="INSERT INTO RoomReservationActivity (RoomReservationRequestID, FamilyProfileID, SocialWorkerProfileID, 
         SW_DateStatusSubmitted, ActivityType, BeginDate, EndDate, PatientDiagnosis, Notes) VALUES(".
                $reservation->get_roomReservationRequestID().",".
                $reservation->get_familyProfileId().",".     
                $reservation->get_socialWorkerProfileId().",'".
                $reservation->get_swDateStatusSubmitted()."','".
                $reservation->get_activityType()."','".
                $reservation->get_beginDate()."','".
                $reservation->get_endDate()."','".
                $reservation->get_patientDiagnosis()."','".
                $reservation->get_roomnote()."')";
    $result=mysql_query($query);
        if (!$result) {
            
		echo (mysql_error()."unable to insert into RoomReservationActivity: ".$reservation->get_roomReservationRequestId()."\n");
		mysql_close();   
                return false;
    }
                mysql_close();
                return true;
}
    
/**
 * Retrieves a Room Reservation from the RoomReservationActivity table by Request Id
 * @param $roomReservationRequestId 
 * @return the Room Reservation corresponding to roomReservationRequestId, or false if not in the table.
 */

function retrieve_RoomReservationActivity($roomReservationRequestId){
    
        connect();
   
        $query = "SELECT RR.RoomReservationActivityID, RR.RoomReservationRequestID, F.FamilyProfileID, F.ParentLastName, 
            F.ParentFirstName, S.SocialWorkerProfileID, S.LastName AS SW_LastName, S.FirstName AS SW_FirstName, 
            R.RMHStaffProfileID, R.LastName AS RMH_Staff_LastName, R.FirstName AS RMH_Staff_FirstName, RR.SW_DateStatusSubmitted, 
            RR.RMH_DateStatusSubmitted, RR.ActivityType, RR.Status, RR.BeginDate, RR.EndDate, RR.PatientDiagnosis, 
            RR.Notes FROM RMHStaffProfile R RIGHT OUTER JOIN RoomReservationActivity RR ON R.RMHStaffProfileID = RR.RMHStaffProfileID
            INNER JOIN SocialWorkerProfile S ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID
            INNER JOIN FamilyProfile F ON RR.FamilyProfileID = F.FamilyProfileID
            WHERE RR.RoomReservationRequestID = \"".$roomReservationRequestId."\"";
   
        $result = mysql_query ($query);
        if (mysql_num_rows($result)!==1) {
	    mysql_close();
		return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theReservations = build_reservation($result_row);
	mysql_close();
	return $theReservations;  
}

/**
 * Retrieves Room Reservation from the RoomReservationActivity table for all Unconfirmed Statuses 
 */

function retrieve_Unconfirmed_RoomReservationActivity(){
    
        connect();
        
        $query = "SELECT RR.RoomReservationActivityID, RR.RoomReservationRequestID, F.FamilyProfileID, F.ParentLastName, F.ParentFirstName, 
            S.SocialWorkerProfileID, S.LastName AS SW_LastName, S.FirstName AS SW_FirstName, R.RMHStaffProfileID, 
            R.LastName AS RMH_Staff_LastName, R.FirstName AS RMH_Staff_FirstName, RR.SW_DateStatusSubmitted, RR.RMH_DateStatusSubmitted, 
            RR.ActivityType, RR.Status, RR.BeginDate, RR.EndDate, RR.PatientDiagnosis, RR.Notes FROM RMHStaffProfile R RIGHT OUTER JOIN 
            RoomReservationActivity RR ON R.RMHStaffProfileID = RR.RMHStaffProfileID 
            INNER JOIN SocialWorkerProfile S ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID
            INNER JOIN FamilyProfile F ON RR.FamilyProfileID = F.FamilyProfileID 
            WHERE RR.Status = 'Unconfirmed'";
        
        $result = mysql_query ($query);
        if(mysql_num_rows($result)!==1){
            mysql_close();
                return false;
        }
        $result_row = mysql_fetch_assoc($result);
        $theReservations = build_reservation($result_row);
        mysql_close();
        return $theReservations;
    }
    
/**
 * Retrieves Room Reservation from the RoomReservationActivity table for all Confirmed Statuses
 */
    
function retrieve_Confirm_RoomReservationActivity(){
    
        connect();
        
        $query = "SELECT RR.RoomReservationActivityID, RR.RoomReservationRequestID, F.FamilyProfileID, F.ParentLastName, 
            F.ParentFirstName, S.SocialWorkerProfileID, S.LastName AS SW_LastName, S.FirstName AS SW_FirstName, 
            R.RMHStaffProfileID, R.LastName AS RMH_Staff_LastName, R.FirstName AS RMH_Staff_FirstName, RR.SW_DateStatusSubmitted, 
            RR.RMH_DateStatusSubmitted, RR.ActivityType, RR.Status, RR.BeginDate, RR.EndDate, RR.PatientDiagnosis, 
            RR.Notes FROM RMHStaffProfile R RIGHT OUTER JOIN RoomReservationActivity RR ON R.RMHStaffProfileID = RR.RMHStaffProfileID
            INNER JOIN SocialWorkerProfile S ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID
            INNER JOIN FamilyProfile F ON RR.FamilyProfileID = F.FamilyProfileID WHERE RR.Status = 'Confirm'";
          
        $result = mysql_query ($query);
        if(mysql_num_rows($result)!==1){
            mysql_close();
                return false;
        }
        $result_row = mysql_fetch_assoc($result);
        $theReservations = build_reservation($result_row);
        mysql_close();
        return $theReservations;
    }
    
/**
 * Retrieves Room Reservation from the RoomReservationActivity table for all Denied Statuses
 */
    
function retrieve_Deny_RoomReservationActivity(){
    
        connect();
        
        $query = "SELECT RR.RoomReservationActivityID, RR.RoomReservationRequestID, F.FamilyProfileID, F.ParentLastName, F.ParentFirstName, 
            S.SocialWorkerProfileID, S.LastName AS SW_LastName, S.FirstName AS SW_FirstName, R.RMHStaffProfileID, R.LastName AS RMH_Staff_LastName, 
            R.FirstName AS RMH_Staff_FirstName, RR.SW_DateStatusSubmitted, RR.RMH_DateStatusSubmitted, RR.ActivityType, RR.Status, RR.BeginDate,
            RR.EndDate, RR.PatientDiagnosis, RR.Notes FROM RMHStaffProfile R RIGHT OUTER JOIN RoomReservationActivity RR ON R.RMHStaffProfileID = RR.RMHStaffProfileID
            INNER JOIN SocialWorkerProfile S ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID
            INNER JOIN FamilyProfile F ON RR.FamilyProfileID = F.FamilyProfileID WHERE RR.Status = 'Deny'";
        
        $result = mysql_query ($query);
        if(mysql_num_rows($result)!==1){
            mysql_close();
                return false;
        }
        $result_row = mysql_fetch_assoc($result);
        $theReservations = build_reservation($result_row);
        mysql_close();
        return $theReservations;
    }
    
/**
 * Retrieves Room Reservation from the RoomReservationActivity table for a specific Family
 * @param $parentLastName
 */
    
function retrieve_FamilyLastName_RoomReservationActivity($parentLastName){
    
       connect();
       
        $query = "SELECT RR.RoomReservationActivityID, RR.RoomReservationRequestID,F.FamilyProfileID, F.ParentLastName, 
            F.ParentFirstName,S.SocialWorkerProfileID, S.LastName AS SW_LastName, S.FirstName AS SW_FirstName, R.RMHStaffProfileID, 
            R.LastName AS RMH_Staff_LastName, R.FirstName AS RMH_Staff_FirstName, RR.SW_DateStatusSubmitted, RR.RMH_DateStatusSubmitted, 
            RR.ActivityType, RR.Status, RR.BeginDate, RR.EndDate, RR.PatientDiagnosis, RR.Notes FROM RMHStaffProfile R RIGHT OUTER JOIN 
            RoomReservationActivity RR ON R.RMHStaffProfileID = RR.RMHStaffProfileID INNER JOIN SocialWorkerProfile S 
            ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID INNER JOIN FamilyProfile F ON RR.FamilyProfileID = F.FamilyProfileID
            WHERE F.ParentLastName = \"".$parentLastName."\"";
        
        $result = mysql_query ($query);
        if(mysql_num_rows($result)!==1){
            mysql_close();
                return false;
        }
        $result_row = mysql_fetch_assoc($result);
        $theReservations = build_reservation($result_row);
        mysql_close();
        return $theReservations;
       
    }
    
/**
 * Retrieves Room Reservation from the RoomReservationActivity table by Social Worker's Last Name
 * @param $socialWorkerLastName
 * @return the Room Reservation corresponding to Social Worker's Last Name, or false if not in the table.
 */

function retrieve_SocialWorkerLastName_RoomReservationActivity($socialWorkerLastName){
    
       connect();
       
        $query = "SELECT RR.RoomReservationActivityID, RR.RoomReservationRequestID, F.FamilyProfileID, F.ParentLastName,
            F.ParentFirstName, S.SocialWorkerProfileID, S.LastName AS SW_LastName, S.FirstName AS SW_FirstName, R.RMHStaffProfileID, 
            R.LastName AS RMH_Staff_LastName, R.FirstName AS RMH_Staff_FirstName, RR.SW_DateStatusSubmitted, RR.RMH_DateStatusSubmitted, 
            RR.ActivityType, RR.Status, RR.BeginDate, RR.EndDate, RR.PatientDiagnosis, RR.Notes FROM RMHStaffProfile R RIGHT OUTER JOIN 
            RoomReservationActivity RR ON R.RMHStaffProfileID = RR.RMHStaffProfileID INNER JOIN SocialWorkerProfile S 
            ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID INNER JOIN FamilyProfile F ON RR.FamilyProfileID = F.FamilyProfileID
            WHERE S.LastName = \"".$socialWorkerLastName."\"";
        
        $result = mysql_query ($query);
        if(mysql_num_rows($result)!==1){
            mysql_close();
                return false;
        }
        $result_row = mysql_fetch_assoc($result);
        $theReservations = build_reservation($result_row);
        mysql_close();
        return $theReservations;
       
    }
    
/**
 * Retrieves Room Reservation from the RoomReservationActivity table by RMH Staff Approver's Last Name
 * @param $rmhStaffLastName
 * @return the Room Reservation corresponding to rmhStaffLastName, or false if not in the table.
 */
    
function retrieve_RMHStaffLastName_RoomReservationActivity($rmhStaffLastName){
    
       connect();
       
        $query = "SELECT RR.RoomReservationActivityID, RR.RoomReservationRequestID, F.FamilyProfileID, F.ParentLastName, 
            F.ParentFirstName, S.SocialWorkerProfileID, S.LastName AS SW_LastName, S.FirstName AS SW_FirstName, R.RMHStaffProfileID, 
            R.LastName AS RMH_Staff_LastName, R.FirstName AS RMH_Staff_FirstName, RR.SW_DateStatusSubmitted, RR.RMH_DateStatusSubmitted, 
            RR.ActivityType, RR.Status, RR.BeginDate, RR.EndDate, RR.PatientDiagnosis, RR.Notes FROM RMHStaffProfile R RIGHT OUTER JOIN 
            RoomReservationActivity RR ON R.RMHStaffProfileID = RR.RMHStaffProfileID INNER JOIN SocialWorkerProfile S 
            ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID INNER JOIN FamilyProfile F ON RR.FamilyProfileID = F.FamilyProfileID
            WHERE R.LastName = \"".$rmhStaffLastName."\"";
        
        $result = mysql_query ($query);
        if(mysql_num_rows($result)!==1){
            mysql_close();
                return false;
        }
        $result_row = mysql_fetch_assoc($result);
        $theReservations = build_reservation($result_row);
        mysql_close();
        return $theReservations;   
    }
    
 /*
  * Retrieves for a selected $hospitalAffiliation, all Room Reservations that were made between $begindate and $enddate, inclusive 
  * 
  */
 
function retrieve_all_RoomReservationActivity_byHospitalAndDate($hospitalAffiliation, $beginDate, $endDate){
    
        connect();
        
         $query = "SELECT RR.RoomReservationActivityID, RR.RoomReservationRequestID, F.FamilyProfileID, F.ParentLastName,
             F.ParentFirstName, S.SocialWorkerProfileID, S.LastName AS SW_LastName, S.FirstName AS SW_FirstName, R.RMHStaffProfileID, 
             R.LastName AS RMH_Staff_LastName, R.FirstName AS RMH_Staff_FirstName, RR.SW_DateStatusSubmitted, RR.RMH_DateStatusSubmitted, 
             RR.ActivityType, RR.Status, RR.BeginDate, RR.EndDate, RR.PatientDiagnosis, RR.Notes FROM RMHStaffProfile R RIGHT OUTER JOIN 
             RoomReservationActivity RR ON R.RMHStaffProfileID = RR.RMHStaffProfileID INNER JOIN SocialWorkerProfile S 
             ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID INNER JOIN FamilyProfile F ON RR.FamilyProfileID = F.FamilyProfileID
             WHERE S.HospitalAffiliation = '".$hospitalAffiliation."' AND RR.BeginDate >= '".$beginDate."' AND RR.EndDate <= '".$endDate."' 
             ORDER BY RR.SW_DateStatusSubmitted";

         $result = mysql_query ($query);
         $theReservations = array();
         while ($result_row = mysql_fetch_assoc($result)) {
         $theReservation = build_reservation($result_row);
         $theReservations[] = $theReservation;
         }
         mysql_close();
         return $theReservations;
      }

/*
 * Retrieves all Room Reservations by $status that were made between $begindate and $enddate, inclusive
 * 
 */

function retrieve_all_RoomReservationActivity_byStatusDate ($status, $beginDate, $endDate) {
    
	connect();
    
        $query = "SELECT RR.RoomReservationActivityID, RR.RoomReservationRequestID, F.FamilyProfileID, F.ParentLastName, 
            F.ParentFirstName, S.SocialWorkerProfileID, S.LastName AS SW_LastName, S.FirstName AS SW_FirstName, R.RMHStaffProfileID, 
            R.LastName AS RMH_Staff_LastName, R.FirstName AS RMH_Staff_FirstName, RR.SW_DateStatusSubmitted, RR.RMH_DateStatusSubmitted, 
            RR.ActivityType, RR.Status, RR.BeginDate, RR.EndDate, RR.PatientDiagnosis, RR.Notes FROM RMHStaffProfile R RIGHT OUTER JOIN 
            RoomReservationActivity RR ON R.RMHStaffProfileID = RR.RMHStaffProfileID INNER JOIN SocialWorkerProfile S 
            ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID INNER JOIN FamilyProfile F ON RR.FamilyProfileID = F.FamilyProfileID 
            WHERE RR.Status = '".$status."' AND RR.BeginDate >= '".$beginDate."'AND RR.EndDate <= '".$endDate."' 
            ORDER BY RR.SW_DateStatusSubmitted";
        
        $result = mysql_query ($query);
        $theReservations = array();
	while ($result_row = mysql_fetch_assoc($result)) {
	    $theReservation = build_reservation($result_row);
	    $theReservations[] = $theReservation;
	}
	mysql_close();
	return $theReservations;
}

/* 
 * auxiliary function to build a Room Reservation Request from a row in the RoomReservationActivity table
 */

function build_reservation($result_row) {
    $theReservations = new reservation($result_row['RoomReservationActivityID'], $result_row['RoomReservationRequestID'], $result_row['FamilyProfileID'],$result_row['ParentLastName'],
    $result_row['ParentFirstName'], $result_row['SocialWorkerProfileID'],$result_row['SW_LastName'], $result_row['SW_FirstName'],$result_row['RMHStaffProfileID'], $result_row['RMH_Staff_LastName'], $result_row['RMH_Staff_FirstName'],
    $result_row['SW_DateStatusSubmitted'], $result_row['RMH_DateStatusSubmitted'], $result_row['ActivityType'], $result_row['Status'], 
    $result_row['BeginDate'], $result_row['EndDate'], $result_row['PatientDiagnosis'], $result_row['Notes']);
                        
	return $theReservations;
}

/**
 * Updates the status, rmhStaffProfileId, and RMH_DateStatusSubmitted of a Reservation in the RoomReservationActivity table.
 * This function is utilized by the RMH Staff who confirms or denies a room request that is made by the social worker. 
 * @param $roomReservationRequestId the RoomReservationActivity to update
 */

function update_status_RoomReservationActivity($roomReservationRequestId){
    
 connect();
 
 $query="UPDATE RoomReservationActivity SET RMHStaffProfileID = ".$reservation->get_rmhStaffProfileId().",". 
         "RMH_DateStatusSubmitted =".",".$reservation->get_rmhDateStatusSubmitted().",".  
         "Status ="."'$reservation->get_status()'"."WHERE RoomReservationRequestID =\"".$reservation->$roomReservationRequestId."\"";
 mysql_close();
 $result=mysql_query($query);
   	
    if(!$result) {
		echo mysql_error() . ">>>Error updating RoomReservationActivity table. <br>";
	    return false;
    }  
    return true;
}

/**
 * Deletes a Room Reservation Request from the RoomReservationActivity table.
 * @param $roomReservationRequestId the id of the RoomReservationActivity to delete
 */

function delete_RoomReservationActivity($roomReservationRequestId) {
    
 connect();
        
    $query="DELETE FROM RoomReservationActivity WHERE RoomReservationRequestID=\"".$roomReservationRequestId."\"";
	$result=mysql_query($query);
	mysql_close();
	if (!$result) {
		echo (mysql_error()."unable to delete from RoomReservationActivity: ".$roomReservationRequestId);
		return false;
	}
    return true;
}

?>
