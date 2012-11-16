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
 * Functions to create, insert, retrieve, update, and delete information from the
 * ProfileActivity table in the database. This table is used with the ProfileActivity class and the Family class.  
 * @version April 23, 2012
 * @author Linda Shek 
 */

include_once(ROOT_DIR.'/domain/ProfileActivity.php');
include_once(ROOT_DIR.'/domain/Family.php');
include_once(ROOT_DIR.'/database/dbFamilyProfile.php');
include_once(ROOT_DIR.'/database/dbinfo.php');

/**
 * Creates a ProfileActivity table with the following fields:
 * ProfileActivityID: primary key of the ProfileActivity table. 
 * ProfileActivityRequestID: request key number for the profile activity
 * FamilyProfileID: id of the family
 * SocialWorkerProfileID: id of the social worker
 * RMHStaffProfileID: id of the rmh staff
 * SW_DateStatusSubmitted: date status submitted by the social worker
 * RMH_DateStatusSubmitted: date status submitted by the rmh staff
 * ActivityType: utilized by the social worker for the room request: 'Apply','Modify','Cancel'
 * Status: utilized by the rmh staff for the room request: 'Unconfirmed','Confirm','Deny'
 * ParentFirstName: displays the first name of the parent
 * ParentLastName: displays the last name of the parent
 * Email: email address of the parent
 * Phone1: primary phone number of the parent 
 * Phone2: secondary phone number of the parent
 * Address: displays parent address
 * City: displays parent city
 * State: displays parent state
 * ZipCode: displays parent zipcode
 * Country: displays parent country
 * PatientFirstName: displays first name of the patient
 * PatientLastName: displays last name of the patient
 * PatientRelation: displays the relationship with the patient
 * PatientDateOfBirth: displays the Patient's date of birth
 * FormPDF: displays the URL of the family's pdf form
 * FamilyNotes; (optional) notes from the the rmh staff/social worker regarding the family
 * ProfileActivityNotes: (optional) notes from the rmh staff/social worker regarding the profile activity
 */

//DO NOT CALL THE FUNCTION Create_ProfileActivity() if TABLE ALREADY EXISTS. 
/*function create_ProfileActivity(){
        //Connect to the server
        connect();
        // Check if the table exists already
        mysql_query("DROP TABLE IF EXISTS ProfileActivity");
        // Create the table and store the result
        $result = mysql_query("CREATE TABLE ProfileActivity (
            ProfileActivityID int NOT NULL AUTO_INCREMENT,
            ProfileActivityRequestID int NOT NULL,
            FamilyProfileID int NOT NULL,
            SocialWorkerProfileID int NOT NULL,
            RMHStaffProfileID int DEFAULT NULL,
            SW_DateStatusSubmitted datetime DEFAULT NULL,
            RMH_DateStatusSubmitted datetime DEFAULT NULL,
            ActivityType enum('Create','Edit') NOT NULL,
            Status enum('Unconfirmed','Confirm','Deny') NOT NULL,   
            ParentFirstName varchar(50) NOT NULL,
            ParentLastName varchar(50) NOT NULL,
            Email varchar(255) DEFAULT NULL,
            Phone1 varchar(20) NOT NULL,
            Phone2 varchar(20) DEFAULT NULL,
            Address varchar(100) DEFAULT NULL,
            City varchar(50) DEFAULT NULL,
            State varchar(10) DEFAULT NULL,
            ZipCode varchar(12) DEFAULT NULL,
            Country varchar(50) DEFAULT NULL,
            PatientFirstName varchar(50) NOT NULL,
            PatientLastName varchar(50) NOT NULL,
            PatientRelation varchar(50) DEFAULT NULL,
            PatientDateOfBirth datetime DEFAULT NULL,
            FormPDF varchar(255) DEFAULT NULL,
            FamilyNotes text,
            ProfileActivityNotes text,
            PRIMARY KEY (`ProfileActivityID`),
            KEY RMHStaffProfileID (RMHStaffProfileID),
            KEY SocialWorkerProfileID (SocialWorkerProfileID),
            KEY FamilyProfileID (FamilyProfileID))");
        // Check if the creation was successful
        if(!$result){
                // Print an error
                echo mysql_error(). ">>>Error creating ProfileActivity table <br>";
                mysql_close();
                return false;
        }
        mysql_close();
        return true;
}*/


/**
 * Inserts a new Profile Activity Request into the ProfileActivity table. This function
 * will be utilized by the social worker. 
 * @param $profileActivity = the profile activity to insert
 */

function insert_ProfileActivity($profileActivity){
        // Check if the profileActivity was actually a profile activity
        if(!$profileActivity instanceof ProfileActivity){
                // Print an error
                echo ("Invalid argument from insert_ProfileActivity function\n");
                return false;
        }
        
        connect();
        // Calls the store procedure 'GetRequestKeyNumber' to get the next highest request id
        $query = "CALL GetRequestKeyNumber('ProfileActivityRequestID')";
        $result = mysql_query ($query);
        if (mysql_num_rows($result)!=0) {
            
                $result_row = mysql_fetch_assoc($result); //gets the first row
                //Sets the request id to the next highest request id 
                $profileActivity->set_profileActivityRequestId($result_row['@ID := ProfileActivityRequestID']);
    }   
        
     mysql_close(); 
     connect();
        // Now add it to the database
        if($profileActivity->get_rmhStaffProfileId()!=0) {  
            //if it is a current record, an RMHStaffProfileID is inserted into database
            
            $query="INSERT INTO profileactivity (ProfileActivityRequestID, FamilyProfileID, SocialWorkerProfileID, 
                RMHStaffProfileID, SW_DateStatusSubmitted, ActivityType, Status, ParentFirstName, ParentLastName, Email, 
                Phone1, Phone2, Address, City, State, ZipCode, Country, PatientFirstName, 
                PatientLastName, PatientRelation, PatientDateOfBirth, FormPDF, FamilyNotes, ProfileActivityNotes) VALUES(".
                        $profileActivity->get_profileActivityRequestId().",".
                        $profileActivity->get_familyProfileId().",". 
                        $profileActivity->get_socialWorkerProfileId().",".  
                        $profileActivity->get_rmhStaffProfileId().",'".
                        $profileActivity->get_swDateStatusSubm()."','".                           
                        $profileActivity->get_activityType()."','".
                        $profileActivity->get_profileActivityStatus()."','".                        
                        $profileActivity->get_parentFirstName()."','".
                        $profileActivity->get_parentLastName()."','".
                        $profileActivity->get_parentEmail()."','".
                        $profileActivity->get_parentPhone1()."','".
                        $profileActivity->get_parentPhone2()."','".
                        $profileActivity->get_parentAddress()."','".
                        $profileActivity->get_parentCity()."','".
                        $profileActivity->get_parentState()."','".
                        $profileActivity->get_parentZip()."','".
                        $profileActivity->get_parentCountry()."','".
                        $profileActivity->get_patientFirstName()."','".
                        $profileActivity->get_patientLastName()."','".
                        $profileActivity->get_patientRelation()."','".
                        $profileActivity->get_patientDOB()."','".
                        $profileActivity->get_formPdf()."','".
                        $profileActivity->get_familyNotes()."','".               
                        $profileActivity->get_profileActivityNotes()."')";
        }
        else {  //new record, has no RMH Staff Member is associated to record, RMHStaffProfileID set to NULL
            $query="INSERT INTO profileactivity (ProfileActivityRequestID, FamilyProfileID, SocialWorkerProfileID, 
                SW_DateStatusSubmitted, ActivityType, Status, ParentFirstName, ParentLastName, Email, 
                Phone1, Phone2, Address, City, State, ZipCode, Country, PatientFirstName, 
                PatientLastName, PatientRelation, PatientDateOfBirth, FormPDF, FamilyNotes, ProfileActivityNotes) VALUES(".
                        $profileActivity->get_profileActivityRequestId().",".
                        $profileActivity->get_familyProfileId().",". 
                        $profileActivity->get_socialWorkerProfileId().",'".
                        $profileActivity->get_swDateStatusSubm()."','".                           
                        $profileActivity->get_activityType()."','".
                        $profileActivity->get_profileActivityStatus()."','".                        
                        $profileActivity->get_parentFirstName()."','".
                        $profileActivity->get_parentLastName()."','".
                        $profileActivity->get_parentEmail()."','".
                        $profileActivity->get_parentPhone1()."','".
                        $profileActivity->get_parentPhone2()."','".
                        $profileActivity->get_parentAddress()."','".
                        $profileActivity->get_parentCity()."','".
                        $profileActivity->get_parentState()."','".
                        $profileActivity->get_parentZip()."','".
                        $profileActivity->get_parentCountry()."','".
                        $profileActivity->get_patientFirstName()."','".
                        $profileActivity->get_patientLastName()."','".
                        $profileActivity->get_patientRelation()."','".
                        $profileActivity->get_patientDOB()."','".
                        $profileActivity->get_formPdf()."','".
                        $profileActivity->get_familyNotes()."','".               
                        $profileActivity->get_profileActivityNotes()."')";
        }
            
                        
        $result=mysql_query($query);
        // Check if successful
        if(!$result) {
                //print the error
                echo mysql_error()." >>>Unable to insert into Profile Activity table. <br>";
                mysql_close();
                return false;
        }
        // Success. 
        mysql_close();
        return true;
}

/**
 * Retrieves a Profile Activity from the ProfileActivity table by Request Id
 * @param $profileActivityRequestId 
 * @return the Profile Activity corresponding to profileActivityRequestId, or false if not in the table.
 */

function retrieve_ProfileActivity_byRequestId($profileActivityRequestId){
    
    connect();
    
    $query = "SELECT P.ProfileActivityID, P.ProfileActivityRequestID, F.FamilyProfileID, S.SocialWorkerProfileID, S.LastName AS SW_LastName, 
       S.FirstName AS SW_FirstName, R.RMHStaffProfileID, R.LastName AS RMH_Staff_LastName, R.FirstName AS RMH_Staff_FirstName,
       P.SW_DateStatusSubmitted, P.RMH_DateStatusSubmitted, P.ActivityType, P.Status, P.ParentFirstName, P.ParentLastName, 
       P.Email, P.Phone1, P.Phone2, P.Address, P.City, P.State, P.ZipCode, P.Country, P.PatientFirstName,P.PatientLastName, 
       P.PatientRelation, P.PatientDateOfBirth, P.FormPDF, P.FamilyNotes, P.ProfileActivityNotes 
       FROM rmhstaffprofile R RIGHT OUTER JOIN 
       profileactivity P ON R.RMHStaffProfileID = P.RMHStaffProfileID
       INNER JOIN socialworkerprofile S ON P.SocialWorkerProfileID = S.SocialWorkerProfileID
       INNER JOIN familyprofile F ON P.FamilyProfileID = F.FamilyProfileID
       WHERE P.ProfileActivityRequestID =".$profileActivityRequestId;
    
       $result = mysql_query($query);
                if(mysql_num_rows($result)!==1)
                {
                 echo mysql_error()." >>>Unable to retrieve from Profile Activity table. <br>";
                 mysql_close();
                 return false;
                }
        $result_row = mysql_fetch_assoc($result);
        $theProfileActivities = build_profileActivity($result_row);
        mysql_close();
        return $theProfileActivities;  
}

/**
 * Retrieves Profile Activity from the ProfileActivity table by Status ('Unconfirmed', 'Confirm', 'Deny')
 * @param $profileActivityStatus
 * @return the Profile Activity corresponding to the profile activity status, or false if not in the table.
 */

function retrieve_ProfileActivity_byStatus($profileActivityStatus){
    
    connect();

    $query = "SELECT P.ProfileActivityID, P.ProfileActivityRequestID, F.FamilyProfileID, S.SocialWorkerProfileID, S.LastName AS SW_LastName, 
        S.FirstName AS SW_FirstName, R.RMHStaffProfileID, R.LastName AS RMH_Staff_LastName, R.FirstName AS RMH_Staff_FirstName,
        P.SW_DateStatusSubmitted, P.RMH_DateStatusSubmitted, P.ActivityType, P.Status, P.ParentFirstName, P.ParentLastName, 
        P.Email, P.Phone1, P.Phone2, P.Address, P.City, P.State, P.ZipCode, P.Country, P.PatientFirstName, P.PatientLastName, 
        P.PatientRelation, P.PatientDateOfBirth, P.FormPDF, P.FamilyNotes, P.ProfileActivityNotes 
        FROM rmhstaffprofile R RIGHT OUTER JOIN profileactivity P ON R.RMHStaffProfileID = P.RMHStaffProfileID
        INNER JOIN socialworkerprofile S ON P.SocialWorkerProfileID = S.SocialWorkerProfileID
        INNER JOIN familyprofile F ON P.FamilyProfileID = F.FamilyProfileID
        WHERE P.Status = '".$profileActivityStatus."'";
    
        $result = mysql_query($query);
                if(mysql_num_rows($result)< 1)
                {
                 echo mysql_error(). " >>>Unable to retrieve from Profile Activity table. <br>";
                    mysql_close();
                    return false;
                }
        $theProfileActivities = array();    
        while($result_row = mysql_fetch_assoc($result)){
        $theProfileActivity = build_profileActivity($result_row);
        $theProfileActivities[] = $theProfileActivity;
        }
        mysql_close();
        return $theProfileActivities;  
}

/**
 * Retrieves Profile Activity from the ProfileActivity table for a specific Family
 * @param $parentLastName
 * @return the Profile Activity corresponding to the Parent's Last Name, or false if not in the table.
 */

function retrieve_FamilyLastName_ProfileActivity($parentLastName){
    
  connect();
          
  $query = "SELECT P.ProfileActivityID, P.ProfileActivityRequestID, F.FamilyProfileID, S.SocialWorkerProfileID, S.LastName AS SW_LastName, 
    S.FirstName AS SW_FirstName, R.RMHStaffProfileID, R.LastName AS RMH_Staff_LastName, R.FirstName AS RMH_Staff_FirstName,
    P.SW_DateStatusSubmitted, P.RMH_DateStatusSubmitted, P.ActivityType, P.Status, P.ParentFirstName, P.ParentLastName, 
    P.Email, P.Phone1, P.Phone2, P.Address, P.City, P.State, P.ZipCode, P.Country, P.PatientFirstName,P.PatientLastName, 
    P.PatientRelation, P.PatientDateOfBirth, P.FormPDF, P.FamilyNotes, P.ProfileActivityNotes 
    FROM rmhstaffprofile R RIGHT OUTER JOIN 
    profileactivity P ON R.RMHStaffProfileID = P.RMHStaffProfileID
    INNER JOIN socialworkerprofile S ON P.SocialWorkerProfileID = S.SocialWorkerProfileID
    INNER JOIN familyprofile F ON P.FamilyProfileID = F.FamilyProfileID 
    WHERE F.ParentLastName ='".$parentLastName."'"; 
        
        $result = mysql_query($query);
                if(mysql_num_rows($result)< 1)
                {
                 echo mysql_error(). " >>>Unable to retrieve from Profile Activity table. <br>";
                 mysql_close();
                 return false;
                }
        $theProfileActivities = array();    
        while($result_row = mysql_fetch_assoc($result)){
        $theProfileActivity = build_profileActivity($result_row);
        $theProfileActivities[] = $theProfileActivity;
        }
        mysql_close();
        return $theProfileActivities;  
}
    
/**
 * Retrieves Profile Activity from the ProfileActivity table by Social Worker's Last Name
 * @param $socialWorkerLastName
 * @return the Profile Activity corresponding to Social Worker's Last Name, or false if not in the table.
 */
   
function retrieve_SocialWorkerLastName_ProfileActivity($socialWorkerLastName){
    
  connect();
       
  $query = "SELECT P.ProfileActivityID, P.ProfileActivityRequestID, F.FamilyProfileID, S.SocialWorkerProfileID, S.LastName AS SW_LastName, 
    S.FirstName AS SW_FirstName, R.RMHStaffProfileID, R.LastName AS RMH_Staff_LastName, R.FirstName AS RMH_Staff_FirstName,
    P.SW_DateStatusSubmitted, P.RMH_DateStatusSubmitted, P.ActivityType, P.Status, P.ParentFirstName, P.ParentLastName, 
    P.Email, P.Phone1, P.Phone2, P.Address, P.City, P.State, P.ZipCode, P.Country, P.PatientFirstName,P.PatientLastName, 
    P.PatientRelation, P.PatientDateOfBirth, P.FormPDF, P.FamilyNotes, P.ProfileActivityNotes 
    FROM rmhstaffprofile R RIGHT OUTER JOIN 
    profileactivity P ON R.RMHStaffProfileID = P.RMHStaffProfileID
    INNER JOIN socialworkerprofile S ON P.SocialWorkerProfileID = S.SocialWorkerProfileID
    INNER JOIN familyprofile F ON P.FamilyProfileID = F.FamilyProfileID
    WHERE S.LastName ='".$socialWorkerLastName."'";
  
        $result = mysql_query($query);
                if(mysql_num_rows($result)< 1)
                {
                 echo mysql_error(). " >>>Unable to retrieve from Profile Activity. <br>";
                 mysql_close();
                 return false;
                }
        $theProfileActivities = array();    
        while($result_row = mysql_fetch_assoc($result)){
        $theProfileActivity = build_profileActivity($result_row);
        $theProfileActivities[] = $theProfileActivity;
        }
        mysql_close();
        return $theProfileActivities;  
}   
    
/**
 * Retrieves Profile Activity from the ProfileActivity table by RMH Staff Approver's Last Name
 * @param $rmhStaffLastName
 * @return the Room Reservation corresponding to rmhStaffLastName, or false if not in the table.
 */
    
function retrieve_RMHStaffLastName_ProfileActivity($rmhStaffLastName){
    
      connect();
       
      $query = "SELECT P.ProfileActivityID, P.ProfileActivityRequestID, F.FamilyProfileID, S.SocialWorkerProfileID, S.LastName AS SW_LastName, 
        S.FirstName AS SW_FirstName, R.RMHStaffProfileID, R.LastName AS RMH_Staff_LastName, R.FirstName AS RMH_Staff_FirstName,
        P.SW_DateStatusSubmitted, P.RMH_DateStatusSubmitted, P.ActivityType, P.Status, P.ParentFirstName, P.ParentLastName, 
        P.Email, P.Phone1, P.Phone2, P.Address, P.City, P.State, P.ZipCode, P.Country, P.PatientFirstName,P.PatientLastName, 
        P.PatientRelation, P.PatientDateOfBirth, P.FormPDF, P.FamilyNotes, P.ProfileActivityNotes 
        FROM rmhstaffprofile R RIGHT OUTER JOIN 
        profileactivity P ON R.RMHStaffProfileID = P.RMHStaffProfileID
        INNER JOIN socialworkerprofile S ON P.SocialWorkerProfileID = S.SocialWorkerProfileID
        INNER JOIN familyprofile F ON P.FamilyProfileID = F.FamilyProfileID
        WHERE R.LastName ='".$rmhStaffLastName."'";
     
        $result = mysql_query($query);
                if(mysql_num_rows($result)< 1)
                {
                 echo mysql_error(). " >>>Unable to retrieve from Profile Activity table. <br>";
                 mysql_close();
                 return false;
                }
        $theProfileActivities = array();    
        while($result_row = mysql_fetch_assoc($result)){
        $theProfileActivity = build_profileActivity($result_row);
        $theProfileActivities[] = $theProfileActivity;
        }
        mysql_close();
        return $theProfileActivities;  
}

/* 
 * auxiliary function to build a Profile Activity Request from a row in the ProfileActivity table
 */
    
function build_profileActivity($result_row) {
    $theProfileActivities = new ProfileActivity($result_row['ProfileActivityID'], $result_row['ProfileActivityRequestID'],
        $result_row['FamilyProfileID'], $result_row['SocialWorkerProfileID'], $result_row['SW_LastName'], $result_row['SW_FirstName'], 
        $result_row['RMHStaffProfileID'], $result_row['RMH_Staff_LastName'], $result_row['RMH_Staff_FirstName'],
        $result_row['SW_DateStatusSubmitted'], $result_row['RMH_DateStatusSubmitted'], $result_row['ActivityType'],
        $result_row['Status'], $result_row['ParentFirstName'], $result_row['ParentLastName'], $result_row['Email'], 
        $result_row['Phone1'], $result_row['Phone2'], $result_row['Address'],$result_row['City'], 
        $result_row['State'], $result_row['ZipCode'],$result_row['Country'], $result_row['PatientFirstName'],
        $result_row['PatientLastName'], $result_row['PatientRelation'], $result_row['PatientDateOfBirth'], 
        $result_row['FormPDF'], $result_row['FamilyNotes'], $result_row['ProfileActivityNotes']);
   
        return $theProfileActivities;
}

/**
 * Updates the status, rmhStaffProfileId, and RMH_DateStatusSubmitted of a Profile Activity in the ProfileActivity table.
 * This function is utilized by the RMH Staff who confirms or denies a profile activity request that is made by the social worker. 
 * @param $profileActivity the ProfileActivity to update
 */

function update_status_ProfileActivity($profileActivity){
    
 connect();
 
 $query="UPDATE profileactivity SET RMHStaffProfileID = ".$profileActivity->get_rmhStaffProfileId().",". 
         "RMH_DateStatusSubmitted ='".$profileActivity->get_rmhDateStatusSubm()."',  
         Status ='".$profileActivity->get_profileActivityStatus()."' WHERE ProfileActivityRequestID =".$profileActivity->get_profileActivityRequestId();
 

 $result=mysql_query($query);
        
    if(!$result) {
                echo mysql_error() . " >>>Unable to update from Profile Activity table. <br>";
            mysql_close();
            return false;
    }  
    mysql_close();
    return true;
}

/**
 * Function to update the family profile after the temporary family profile in the ProfileActivity table has been confirmed by an RMH Staff Approver.
 * Checks if the Profile Activity object has an Activity Type of 'Edit' and a Status of 'Confirm'. Then, updates the 'FamilyProfile' table accordingly. 
 * @param $profileActivity
 */
  //New family creation activity approval still needs to be resolved
  
function update_FamilyProfile_On_ProfileActivity($profileActivity){
        //Checks if the profileActivity was actually a profile activity
        if(!$profileActivity instanceof ProfileActivity){
                // Print an error
                echo ("Invalid argument from update_FamilyProfile_On_ProfileActivity function\n");
                return false;
        }  
        connect();
        //Checks if the temporary family profile has an Activity Type of 'Edit' and a Status of 'Confirm'
        if($profileActivity->get_activityType() == 'Edit' && $profileActivity->get_profileActivityStatus() == 'Confirm')
            {
            
            $query = "SELECT FamilyProfileID, ParentFirstName, ParentLastName, Email, Phone1, Phone2, Address, City, State, ZipCode, Country,
            PatientFirstName, PatientLastName, PatientRelation, PatientDateOfBirth, FormPDF, FamilyNotes
            FROM profileactivity WHERE ProfileActivityRequestID = ".$profileActivity->get_profileActivityRequestId()." AND ActivityType = 'Edit' AND Status = 'Confirm'";

            $result = mysql_query ($query);

            //If the Profile Activity Request has been Confirmed, then update the FamilyProfile table
            if(mysql_num_rows($result)==1)
            {
                 //gets results from the object
                /*Prepare data for updating the Family Profile table*/     
                $family = new Family($profileActivity->get_familyProfileId(),
                         $profileActivity->get_familyProfileStatus(),
                         $profileActivity->get_parentFirstName(), 
                         $profileActivity->get_parentLastName(), 
                         $profileActivity->get_parentEmail(),
                         $profileActivity->get_parentPhone1(), 
                         $profileActivity->get_parentPhone2(), 
                         $profileActivity->get_parentAddress(), 
                         $profileActivity->get_parentCity(),
                         $profileActivity->get_parentState(), 
                         $profileActivity->get_parentZip(), 
                         $profileActivity->get_parentCountry(), 
                         $profileActivity->get_patientFirstName(),
                         $profileActivity->get_patientLastName(), 
                         $profileActivity->get_patientRelation(), 
                         $profileActivity->get_patientDOB(),
                         $profileActivity->get_formPdf(), 
                         $profileActivity->get_familyNotes());

                            return update_FamilyProfile($family);
        }
    }
        else
            {
            //Prints an error message if Profile Activity Edit was not Confirmed
            echo mysql_error()." >>>Temporary Family Profile Edit has not been Confirmed."; 
            mysql_close();
            return false;
            }
}

/**
 * Deletes a Profile Activity Request from the ProfileActivity table.
 * @param $profileActivityRequestId the id of the ProfileActivity to delete
 */

function delete_ProfileActivity($profileActivityRequestId) {
    
    connect();
        
    $query="DELETE FROM profileactivity WHERE ProfileActivityRequestID=".$profileActivityRequestId;
        $result=mysql_query($query);
        
        if (!$result) {
                echo mysql_error()." >>>Unable to delete from Profile Activity table: ".$profileActivityRequestId;
                mysql_close();
                return false;
        }
    mysql_close();
    return true;
}
?>