<?php

/*
* Copyright 2011 by Linda Shek and Bonnie MacKellar.
* This program is part of RMH-RoomReservationMaker, which is free software,
* inspired by the RMH Homeroom Project.
* It comes with absolutely no warranty.  You can redistribute and/or
* modify it under the terms of the GNU Public License as published
* by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

/**
 * Functions to create, retrieve, update, and delete information from the
 * roomreservationactivity table in the database. This table is used with the reservation class.  
 * @version April 23, 2012
 * @author Linda Shek 
 */

include_once (ROOT_DIR.'/domain/Reservation.php');
include_once (ROOT_DIR.'/database/dbinfo.php');
/**
 * Creates a roomreservationactivity table with the following fields:
 * RoomReservationActivityID: primary key of the roomreservationactivity table.
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
    //Connect to the server
    connect();
    //Check if the table exists already
    mysql_query("DROP TABLE IF EXISTS roomreservationactivity");
    //Create the table and store the result
    $result=mysql_query("CREATE TABLE roomreservationactivity (
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
    //Check if the creation was successful
    if(!$result) {
                //Print an error
                echo mysql_error(). ">>>Error creating roomreservationactivity table. <br>";
                mysql_close();
                return false;
    }
    mysql_close();
    return true;
}*/

// these are constants used in the retrieve functions
define ('SELECT_RES_CLAUSE', "SELECT RR.RoomReservationKey, RR.RoomReservationActivityID AS RoomReservationActivityID, RR.RoomReservationRequestID,
            RR.SW_DateStatusSubmitted, 
            RR.RMH_DateStatusSubmitted, 
            RR.ActivityType, RR.Status, RR.BeginDate, RR.EndDate, 
            F.FamilyProfileID, F.ParentLastName, 
            F.ParentFirstName, S.SocialWorkerProfileID, S.LastName AS SW_LastName, S.FirstName AS SW_FirstName, 
            RR.RMHStaffProfileID, 
            R.LastName AS RMH_Staff_LastName, R.FirstName AS RMH_Staff_FirstName,
             RR.SW_DateStatusSubmitted, 
           RR.PatientDiagnosis, 
            RR.Notes ");

// this SELECT clause returns the highest activity id for each request id
// this is used in most of the retrieve queries to join with the full request table so that
// we always return the most recent record for a request
define ('MAX_ACTIVITY_ID_TABLE',"(SELECT RR.RoomReservationRequestID, MAX(RR.RoomReservationActivityID) as maxid
            FROM roomreservationactivity RR
            GROUP BY RR.RoomReservationRequestID)");
/*
 * Retrieves the highest RoomReservationRequestID, or RoomReservationActivityID, depending on the status of the request, Apply (a new reservation) 
 * or Modify/Cancel (an existing reservation), and increments it providing the insert function with the most current 
 * copy of the record, while preserving a history of changes made.
 * If this is a new request, the activityType should be "Apply", the request ID is incremented, and the activityID is set to 1. 
 * If it is a modification to an existing request, the activityType should be "Modify", the request ID remains the same, and the activityID will be incremented. 
 * @param $reservation = the reservation being modified.
 * @author Chris Giglio
 */

function generateNextRoomReservationID($reservation){ //this will be used for generating BOTH the appropriate activityID, and requestID
    
    connect();
    $status = $reservation->get_activityType();
     //if ActivityType is set to Apply (there fore it is a new reservation)
    if($status == "Apply"){ 
        //Select the highest RoomReservationRequestID and increment it
            $query = "SELECT MAX(RoomReservationRequestID) FROM roomreservationactivity";
            $result = mysql_query($query);
           
            while($result_row=  mysql_fetch_array($result)){
                
                $reservationReqID=$result_row['MAX(RoomReservationRequestID)'];
                $reservationReqID++;
            }
            //Request ID receives new value, Activity ID is set to 1, as this is a new request. 
                $reservation->set_RoomReservationRequestID($reservationReqID);
                $reservation->set_RoomReservationActivityID(1);
    
     }
       
     //if ActivityType is set to Modify or Cancel (therefore it is an existing reservation) a record is saved recording the change
    else { 
        $ActivityID=$reservation->get_roomReservationActivityID();
        $query = "SELECT MAX(RoomReservationRequestID) FROM roomreservationactivity WHERE RoomReservationActivityID = ".
            $ActivityID;
        $result= mysql_query($query);
    
    while($result_row=mysql_fetch_array($result)){
        $RequestID=$result_row['MAX(RoomReservationRequestID)'];
        }
        //request id remains the same for an existing reservation.
        $reservation->set_roomReservationRequestID($RequestID);
    
        //Since this is an existing request, the activity ID is increased by 1, and the request ID remains the same
        $query = "SELECT MAX(RoomReservationActivityID) FROM roomreservationactivity WHERE RoomReservationRequestID = ".
            $RequestID; //select the highest request id for the record with the matching activity id.
    $result= mysql_query($query);
    
    while($result_row=mysql_fetch_array($result)){
        
        $reservationActID=$result_row['MAX(RoomReservationActivityID)'];
        $reservationActID++;
        }
        //increment the activity id
        $reservation->set_roomReservationActivityID($reservationActID);
             
    } 
    
      
        mysql_close();
    
}

/**
 * Inserts a new Room Reservation Request into the roomreservationactivity table. This function
 * will be utilized by the social worker. 
 * @param $reservation = the reservation to insert
 */

 function insert_RoomReservationActivity ($reservation){
    //Check if the reservation was actually a reservation
     if (! $reservation instanceof Reservation) {
                //Print an error
                echo ("Invalid argument for insert_RoomReservationActivity function call");
                return -1;
        }
        
        
        
     generateNextRoomReservationID($reservation);
     
     connect();
     //Now add it to the database
     $query="INSERT INTO roomreservationactivity (RoomReservationActivityID, RoomReservationRequestID, FamilyProfileID, SocialWorkerProfileID, 
         SW_DateStatusSubmitted, ActivityType, BeginDate, EndDate, PatientDiagnosis, Notes) VALUES(".
                $reservation->get_roomReservationActivityID().",".
                $reservation->get_roomReservationRequestID().",".
                $reservation->get_familyProfileId().",".     
                $reservation->get_socialWorkerProfileId().",'".
                $reservation->get_swDateStatusSubmitted()."','".
                $reservation->get_activityType()."','".
                $reservation->get_beginDate()."','".
                $reservation->get_endDate()."','".
                $reservation->get_patientDiagnosis()."','".
                $reservation->get_roomnote()."')";

     $result = mysql_query($query);
     $roomReservationKey= mysql_insert_id();

    //Check if successful
        if (!$result) {
                //print the error
                echo mysql_error()." >>>Unable to insert into Room Reservation Activity table. <br>";
                mysql_close();   
                //return -1 if false;
                return -1;
    }
    //Success
    mysql_close();
    //return room reservation key if true;
    return $roomReservationKey;
}
    
/**
 * Retrieves a Room Reservation from the roomreservationactivity table by Request Id
 * NOTE: In the table, a room reservation may consist of multiple records, each
 * record representing a state change (from pending to accepted, for example)
 * This function always returns the most recent record for a room reservation.
 * This function returns FALSE if no room reservation record is found
 * @param $roomReservationRequestId 
 * @return the Room Reservation corresponding to roomReservationRequestId, or false if not in the table.
 */

function retrieve_RoomReservationActivity_byRequestId($roomReservationRequestId){
        //Connects to the the database
        connect();
        //Retrieve the entry
        $query = SELECT_RES_CLAUSE.
        "FROM ".MAX_ACTIVITY_ID_TABLE.
           "as result INNER JOIN roomreservationactivity RR ON result.RoomReservationRequestID = RR.RoomReservationRequestID 
                AND result.maxid = RR.RoomReservationActivityID
             INNER JOIN socialworkerprofile S ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID
            INNER JOIN familyprofile F ON RR.FamilyProfileID = F.FamilyProfileID
           LEFT OUTER  JOIN rmhstaffprofile R ON RR.RMHStaffProfileID = R.RMHStaffProfileID
           WHERE RR.RoomReservationRequestID=".$roomReservationRequestId;                        
        $result = mysql_query($query) or die(mysql_error());
        error_log("num rows retrieved =  ".mysql_num_rows($result));
        if (mysql_num_rows($result)!==1) {
                mysql_close();
                return false;
        }
        $theReservations = array();
         while ($result_row = mysql_fetch_assoc($result)) {
         $theReservation = build_reservation($result_row);
         $theReservations[] = $theReservation;
         }
         mysql_close();
         return $theReservations; 
}

/**
 * Retrieves Room Reservation from the roomreservationactivity table by Status ('Unconfirmed', 'Confirm', 'Deny')
 *  NOTE: In the table, a room reservation may consist of multiple records, each
 * record representing a state change (from pending to accepted, for example)
 * This function always returns the most recent record for a given room reservation.
 * It returns FALSE if no record was retrieved
 * @param $status
 * @return the Room Reservation corresponding to status, or false if not in the table.
 */
      
function retrieve_RoomReservationActivity_byStatus($status){
    
        connect();
        
        $query = SELECT_RES_CLAUSE.   "FROM ".MAX_ACTIVITY_ID_TABLE.
           "as result   INNER JOIN roomreservationactivity RR ON result.RoomReservationRequestID = RR.RoomReservationRequestID AND result.maxid = RR.RoomReservationActivityID
            INNER JOIN socialworkerprofile S ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID
            INNER JOIN familyprofile F ON RR.FamilyProfileID = F.FamilyProfileID
          LEFT OUTER  JOIN rmhstaffprofile R ON RR.RMHStaffProfileID = R.RMHStaffProfileID
      WHERE RR.Status ='".$status."'";
       
        
         $result = mysql_query($query) or die(mysql_error());
                if(mysql_num_rows($result)< 1)
                {
                 mysql_close();
                 return false;
                }
         $theReservations = array();
         while ($result_row = mysql_fetch_assoc($result)) {
         $theReservation = build_reservation($result_row);
         $theReservations[] = $theReservation;
         }
         mysql_close();
         return $theReservations;
      }
    
/**
 * Retrieves Room Reservation from the roomreservationactivity table for a specific Family
 *  NOTE: In the table, a room reservation may consist of multiple records, each
 * record representing a state change (from pending to accepted, for example)
 * This function always returns the most recent record for a room reservation.
 * It returns FALSE if no record was retrieved
 * @param $parentLastName
 * @return the Room Reservation corresponding to the Parent's Last Name, or false if not in the table.
 */
    
function retrieve_FamilyLastName_RoomReservationActivity($parentLastName){
    
       connect();
        $query = SELECT_RES_CLAUSE.   "FROM ".MAX_ACTIVITY_ID_TABLE.
           "as result   INNER JOIN roomreservationactivity RR ON result.RoomReservationRequestID = RR.RoomReservationRequestID 
               AND result.maxid = RR.RoomReservationActivityID
            INNER JOIN socialworkerprofile S ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID
            INNER JOIN familyprofile F ON RR.FamilyProfileID = F.FamilyProfileID
          LEFT OUTER  JOIN rmhstaffprofile R ON RR.RMHStaffProfileID = R.RMHStaffProfileID
      WHERE F.ParentLastName ='".$parentLastName."'";
  
        
        $result = mysql_query($query)or die(mysql_error());
                if(mysql_num_rows($result)< 1)
                {
                 mysql_close();
                 return false;
                }
         $theReservations = array();
         while ($result_row = mysql_fetch_assoc($result)) {
         $theReservation = build_reservation($result_row);
         $theReservations[] = $theReservation;
         }
         mysql_close();
         return $theReservations;
      }
    
/**
 * Retrieves Room Reservation from the roomreservationactivity table by Social Worker's Last Name
 *   NOTE: In the table, a room reservation may consist of multiple records, each
 * record representing a state change (from pending to accepted, for example)
 * This function always returns the most recent record for a room reservation.
 * It returns FALSE if no record was retrieved
 * @param $socialWorkerLastName
 * @return the Room Reservation corresponding to Social Worker's Last Name, or false if not in the table.
 */

function retrieve_SocialWorkerLastName_RoomReservationActivity($socialWorkerLastName){
    
       connect();
        $query = SELECT_RES_CLAUSE.   "FROM ".MAX_ACTIVITY_ID_TABLE.
           "as result   INNER JOIN roomreservationactivity RR ON result.RoomReservationRequestID = RR.RoomReservationRequestID AND result.maxid = RR.RoomReservationActivityID
            INNER JOIN socialworkerprofile S ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID
            INNER JOIN familyprofile F ON RR.FamilyProfileID = F.FamilyProfileID
          LEFT OUTER  JOIN rmhstaffprofile R ON RR.RMHStaffProfileID = R.RMHStaffProfileID
      WHERE S.LastName ='".$socialWorkerLastName."'";
 
        
        $result = mysql_query($query)or die(mysql_error());
                if(mysql_num_rows($result)< 1)
                {
                 mysql_close();
                 return false;
                }
         $theReservations = array();
         while ($result_row = mysql_fetch_assoc($result)) {
         $theReservation = build_reservation($result_row);
         $theReservations[] = $theReservation;
         }
         mysql_close();
         return $theReservations;
      }
    
/**
 * Retrieves Room Reservation from the roomreservationactivity table by an RMH Staff Approver's Last Name
 *  NOTE: In the table, a room reservation may consist of multiple records, each
 * record representing a state change (from pending to accepted, for example)
 * This function always returns the most recent record for a room reservation.
 * It returns FALSE if no record was retrieved
 * @param $rmhStaffLastName
 * @return the Room Reservation corresponding to and RMH Staff's Last Name, or false if not in the table.
 */
      
function retrieve_RMHStaffLastName_RoomReservationActivity($rmhStaffLastName){
    
       connect();
        $query = SELECT_RES_CLAUSE.   "FROM ".MAX_ACTIVITY_ID_TABLE.
           "as result   INNER JOIN roomreservationactivity RR ON result.RoomReservationRequestID = RR.RoomReservationRequestID AND result.maxid = RR.RoomReservationActivityID
            INNER JOIN socialworkerprofile S ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID
            INNER JOIN familyprofile F ON RR.FamilyProfileID = F.FamilyProfileID
          LEFT OUTER  JOIN rmhstaffprofile R ON RR.RMHStaffProfileID = R.RMHStaffProfileID
      WHERE R.LastName ='".$rmhStaffLastName."'";
  
        
        $result = mysql_query($query) or die(mysql_error());
                if(mysql_num_rows($result)< 1)
                {
                 mysql_close();
                 return false;
                }
         $theReservations = array();
         while ($result_row = mysql_fetch_assoc($result)) {
         $theReservation = build_reservation($result_row);
         $theReservations[] = $theReservation;
         }
         mysql_close();
         return $theReservations;
      }
    
 /*
  * Retrieves for a selected Hospital Affiliation, and all Room Reservations that were made between Begin Date and End Date, inclusive 
  * It will return the record whether unconfirmed or confirmed
  *  NOTE: In the table, a room reservation may consist of multiple records, each
 * record representing a state change (from pending to accepted, for example)
 * This function always returns the most recent record for a room reservation.
  * It returns FALSE if no record is retrieved
  * @param $hospitalAffiliation, $beginDate, $endDate
  * @return the Room Reservation corresponding to Hospital Affiliation, Begin Date, End Date, or false if not in the table. 
  */
      
function retrieve_all_RoomReservationActivity_byHospitalAndDate($hospitalAffiliation, $beginDate, $endDate){
    
        connect();
         $query = SELECT_RES_CLAUSE.   "FROM ".MAX_ACTIVITY_ID_TABLE.
           "as result   INNER JOIN roomreservationactivity RR ON result.RoomReservationRequestID = RR.RoomReservationRequestID AND result.maxid = RR.RoomReservationActivityID
            INNER JOIN socialworkerprofile S ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID
            INNER JOIN familyprofile F ON RR.FamilyProfileID = F.FamilyProfileID
          LEFT OUTER  JOIN rmhstaffprofile R ON RR.RMHStaffProfileID = R.RMHStaffProfileID
      WHERE S.HospitalAffiliation = '".$hospitalAffiliation."' AND RR.BeginDate >= '".$beginDate."' AND RR.EndDate <= '".$endDate."' 
             ORDER BY RR.SW_DateStatusSubmitted";

      
        $result = mysql_query($query)or die(mysql_error());
                if(mysql_num_rows($result)< 1)
                {
                 mysql_close();
                 return false;
                }
         $theReservations = array();
         while ($result_row = mysql_fetch_assoc($result)) {
         $theReservation = build_reservation($result_row);
         $theReservations[] = $theReservation;
         }
         mysql_close();
         return $theReservations;
      }

/*
 * Retrieves all Room Reservations that were made between $begindate and $enddate, inclusive
 * It will return the record whether unconfirmed or confirmed
 *  NOTE: In the table, a room reservation may consist of multiple records, each
 * record representing a state change (from pending to accepted, for example)
 * This function always returns the most recent record for a room reservation.
 * It returns FALSE if no record is retrieved
 * @param $beginDate, $endDate
 * @return the Room Reservation corresponding to Begin Date and End Date, or false if not in the table. 
 */
      
function retrieve_all_RoomReservationActivity_byDate ($beginDate, $endDate) {
    
        connect();
        $query = SELECT_RES_CLAUSE.   "FROM ".MAX_ACTIVITY_ID_TABLE.
           "as result   INNER JOIN roomreservationactivity RR ON result.RoomReservationRequestID = RR.RoomReservationRequestID AND result.maxid = RR.RoomReservationActivityID
            INNER JOIN socialworkerprofile S ON RR.SocialWorkerProfileID = S.SocialWorkerProfileID
            INNER JOIN familyprofile F ON RR.FamilyProfileID = F.FamilyProfileID
          LEFT OUTER  JOIN rmhstaffprofile R ON RR.RMHStaffProfileID = R.RMHStaffProfileID
         WHERE  RR.BeginDate >= '".$beginDate."' AND RR.EndDate <= '".$endDate."' 
            ORDER BY RR.SW_DateStatusSubmitted";
   
 
      $result = mysql_query($query)or die(mysql_error());
          if(mysql_num_rows($result)< 1)
          {
           mysql_close();
           return false;
          }  
        $theReservations = array();
        while ($result_row = mysql_fetch_assoc($result)) {
            $theReservation = build_reservation($result_row);
            $theReservations[] = $theReservation;
        }
        mysql_close();
        return $theReservations;
}

/*
 * auxiliary function to build a Room Reservation Request from a row in the roomreservationactivity table
 */

function build_reservation($result_row) {
    $theReservations = new reservation($result_row['RoomReservationKey'], $result_row['RoomReservationActivityID'], $result_row['RoomReservationRequestID'], $result_row['FamilyProfileID'],$result_row['ParentLastName'],
    $result_row['ParentFirstName'], $result_row['SocialWorkerProfileID'],$result_row['SW_LastName'], $result_row['SW_FirstName'],$result_row['RMHStaffProfileID'], $result_row['RMH_Staff_LastName'], $result_row['RMH_Staff_FirstName'],
    $result_row['SW_DateStatusSubmitted'], $result_row['RMH_DateStatusSubmitted'], $result_row['ActivityType'], $result_row['Status'], 
    $result_row['BeginDate'], $result_row['EndDate'], $result_row['PatientDiagnosis'], $result_row['Notes']);
                        
    return $theReservations;
}

/**
 * Updates the status, rmhStaffProfileId, and RMH_DateStatusSubmitted of a Reservation in the roomreservationactivity table.
 * This function is utilized by the RMH Staff who confirms or denies a room request that is made by the social worker. 
 * @param $reservation the roomreservationactivity to update
 */

function update_status_RoomReservationActivity($reservation){
    
 connect();
 
 $query="UPDATE roomreservationactivity SET RMHStaffProfileID = ".$reservation->get_rmhStaffProfileId().",". 
         "RMH_DateStatusSubmitted ='".$reservation->get_rmhDateStatusSubmitted()."',  
         Status ='".$reservation->get_status()."' WHERE RoomReservationRequestID =".$reservation->get_roomReservationRequestId();

 $result = mysql_query($query);
        
    if(!$result) {
                echo mysql_error()." >>>Unable to update from Room Reservation Activity table. <br>";
            mysql_close();
            return false;
    } 
    mysql_close();
    return true;
}



/**
 * Deletes a Room Reservation Request from the roomreservationactivity table.
 * @param $roomReservationRequestId the id of the roomreservationactivity to delete
 */

function delete_RoomReservationActivity($roomReservationRequestId) {
    /*DO NOT USE THIS FUNCTION FOR CANCELING A REQUEST! 
     * This function should only be used in extreme circumstances when an error is made to a request and it needs to be removed.
     * To cancel an existing reservation request, call insert_RoomReservationActivity with the activityType set to "Cancel". 
     */
 connect();
        
    $query="DELETE FROM roomreservationactivity WHERE RoomReservationRequestID=".$roomReservationRequestId;
         $result = mysql_query($query);
        
        if (!$result) {
                echo mysql_error()." >>>Unable to delete from Room Reservation Activity table: ".$roomReservationRequestId;
                mysql_close();
                return false;
        }
    mysql_close();
    return true;
}

?>