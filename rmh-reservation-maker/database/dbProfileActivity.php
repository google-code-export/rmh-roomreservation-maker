<?php

/**
 * Functions to create, insert, retrieve, update, and delete information from the
 * ProfileActivity table in the database. This table is used with the ProfileActivity class.  
 * @version April 09, 2012
 * @author Linda Shek and Gergana Stoykova
 */

include_once(ROOT_DIR.'/domain/ProfileActivity.php');
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
 * Notes: (optional) notes from the rmh staff/social worker
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
            Notes text,
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
        
        $query = "CALL GetRequestKeyNumber('ProfileActivityRequestID')";
    $result = mysql_query ($query);
        if (mysql_num_rows($result)!=0) {
            
		$result_row = mysql_fetch_assoc($result); //gets the first row
		$profileActivity->get_profileActivityRequestId() = $result_row['@ID := ProfileActivityRequestID'];
    }	
        
     mysql_close(); 
     
	// Now add it to the database
	$query="INSERT INTO ProfileActivity (ProfileActivityRequestID, FamilyProfileID, SocialWorkerProfileID,
                SW_DateStatusSubmitted, ActivityType, Status, Notes) VALUES('".
			$profileActivity->get_profileActivityRequestId()."','".
                        $profileActivity->get_familyProfileId()."','".
                        $profileActivity->get_socialWorkerProfileId()."','".  
                        $profileActivity->get_swDateStatusSubm()."','".                           
                        $profileActivity->get_activityType()."','".
			$profileActivity->get_profileActivityStatus()."','".
                        $profileActivity->get_profileActivityNotes()."')";
			
	$result=mysql_query($query);
	// Check if successful
	if(!$result) {
		//print the error
		echo mysql_error()." Could not insert into ProfileActivity :".$profileActivity->get_profileActivityRequestId()."\n";
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

function retrieve_ProfileActivity($profileActivityRequestId){
    
    connect();
    
    $query = "SELECT P.ProfileActivityRequestID,F.`ParentLastName`,F.`ParentFirstName`,S. LastName AS SW_LastName, 
    S.`FirstName`AS SW_FirstName,R.`LastName` AS RMH_Staff_LastName,R.`FirstName` AS RMH_Staff_FirstName,
    P.SW_DateStatusSubmitted, P.`RMH_DateStatusSubmitted`, P.ActivityType, P.Status, P.Notes 
    FROM RMHStaffProfile R RIGHT OUTER JOIN 
    ProfileActivity P ON R.`RMHStaffProfileID`= P.RMHStaffProfileID
    INNER JOIN SocialWorkerProfile S ON P.SocialWorkerProfileID = S.`SocialWorkerProfileID`
    INNER JOIN FamilyProfile F ON P.FamilyProfileID = F.`FamilyProfileID` 
    WHERE P.ProfileActivityRequestID = \"".$profileActivityRequestId."\"";
   
        $result = mysql_query ($query);
        if (mysql_num_rows($result)!==1) {
	    mysql_close();
		return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theProfileActivity = build_profileActivity($result_row);
	mysql_close();
	return $theProfileActivity;  
}


/**
 * Retrieves Profile Activity from the ProfileActivity table for all Unconfirmed Statuses
 * 
 * 
 */

function retrieve_UnConfirmed_ProfileActivity(){
    connect();
    $query = "SELECT P.ProfileActivityRequestID,F.`ParentLastName`,F.`ParentFirstName`,S. LastName AS SW_LastName, 
    S.`FirstName`AS SW_FirstName,R.`LastName` AS RMH_Staff_LastName,R.`FirstName` AS RMH_Staff_FirstName,
    P.SW_DateStatusSubmitted, P.`RMH_DateStatusSubmitted`, P.ActivityType, P.Status, P.Notes 
    FROM RMHStaffProfile R RIGHT OUTER JOIN 
    ProfileActivity P ON R.`RMHStaffProfileID`= P.RMHStaffProfileID
    INNER JOIN SocialWorkerProfile S ON P.SocialWorkerProfileID = S.`SocialWorkerProfileID`
    INNER JOIN FamilyProfile F ON P.FamilyProfileID = F.`FamilyProfileID` 
    WHERE P.Status = 'Unconfirmed'";  
    
    $result = mysql_query ($query);
        if(mysql_num_rows($result)!==1){
            mysql_close();
                return false;
        }
        $result_row = mysql_fetch_assoc($result);
        $theProfileActivity = build_profileActivity($result_row);
        mysql_close();
        return $theProfileActivity;
}

/**
 * Retrieves Profile Activity from the ProfileActivity table for all Confirmed Statuses
 *
 * 
 */

function retrieve_Confirm_ProfileActivity(){
    connect();
    
    $query = "SELECT P.ProfileActivityRequestID,F.`ParentLastName`,F.`ParentFirstName`,S. LastName AS SW_LastName, 
    S.`FirstName`AS SW_FirstName,R.`LastName` AS RMH_Staff_LastName,R.`FirstName` AS RMH_Staff_FirstName,
    P.SW_DateStatusSubmitted, P.`RMH_DateStatusSubmitted`, P.ActivityType, P.Status, P.Notes 
    FROM RMHStaffProfile R RIGHT OUTER JOIN 
    ProfileActivity P ON R.`RMHStaffProfileID`= P.RMHStaffProfileID
    INNER JOIN SocialWorkerProfile S ON P.SocialWorkerProfileID = S.`SocialWorkerProfileID`
    INNER JOIN FamilyProfile F ON P.FamilyProfileID = F.`FamilyProfileID` 
    WHERE P.Status = 'Confirm'";      
    
    $result = mysql_query ($query);
        if(mysql_num_rows($result)!==1){
            mysql_close();
                return false;
        }
        $result_row = mysql_fetch_assoc($result);
        $theProfileActivity = build_profileActivity($result_row);
        mysql_close();
        return $theProfileActivity;
}


/**
 * Retrieves Profile Activity from the ProfileActivity table for all Denied Statuses
 * 
 */

function retrieve_Deny_ProfileActivity(){
    connect(); 
    
    $query = "SELECT P.ProfileActivityRequestID,F.`ParentLastName`,F.`ParentFirstName`,S. LastName AS SW_LastName, 
    S.`FirstName`AS SW_FirstName,R.`LastName` AS RMH_Staff_LastName,R.`FirstName` AS RMH_Staff_FirstName,
    P.SW_DateStatusSubmitted, P.`RMH_DateStatusSubmitted`, P.ActivityType, P.Status, P.Notes 
    FROM RMHStaffProfile R RIGHT OUTER JOIN 
    ProfileActivity P ON R.`RMHStaffProfileID`= P.RMHStaffProfileID
    INNER JOIN SocialWorkerProfile S ON P.SocialWorkerProfileID = S.`SocialWorkerProfileID`
    INNER JOIN FamilyProfile F ON P.FamilyProfileID = F.`FamilyProfileID` 
    WHERE P.Status = 'Deny'";  
    
        $result = mysql_query ($query);
        if(mysql_num_rows($result)!==1){
            mysql_close();
                return false;
        }
        $result_row = mysql_fetch_assoc($result);
        $theProfileActivity = build_profileActivity($result_row);
        mysql_close();
        return $theProfileActivity;
}

/**
 * Retrieves Profile Activity from the ProfileActivity table for a specific Family
 * @param $parentLastName
 * 
 */

function retrieve_FamilyLastName_ProfileActivity($parentLastName){
       connect();
          
    $query = "SELECT P.ProfileActivityRequestID,F.`ParentLastName`,F.`ParentFirstName`,S. LastName AS SW_LastName, 
    S.`FirstName`AS SW_FirstName,R.`LastName` AS RMH_Staff_LastName,R.`FirstName` AS RMH_Staff_FirstName,
    P.SW_DateStatusSubmitted, P.`RMH_DateStatusSubmitted`, P.ActivityType, P.Status, P.Notes 
    FROM RMHStaffProfile R RIGHT OUTER JOIN 
    ProfileActivity P ON R.`RMHStaffProfileID`= P.RMHStaffProfileID
    INNER JOIN SocialWorkerProfile S ON P.SocialWorkerProfileID = S.`SocialWorkerProfileID`
    INNER JOIN FamilyProfile F ON P.FamilyProfileID = F.`FamilyProfileID` 
    WHERE F.ParentLastName = \"".$parentLastName."\""; 
        
        $result = mysql_query ($query);
        if(mysql_num_rows($result)!==1){
            mysql_close();
                return false;
        }
        $result_row = mysql_fetch_assoc($result);
        $theProfileActivity = build_profileActivity($result_row);
        mysql_close();
        return $theProfileActivity;
       
    }
    
/**
 * Retrieves Profile Activity from the ProfileActivity table by Social Worker's Last Name
 * @param $socialWorkerLastName
 * @return the Profile Activity corresponding to Social Worker's Last Name, or false if not in the table.
 */
    
   function retrieve_SocialWorkerLastName_ProfileActivity($socialWorkerLastName){
       connect();
       
           $query = "SELECT P.ProfileActivityRequestID,F.`ParentLastName`,F.`ParentFirstName`,S. LastName AS SW_LastName, 
    S.`FirstName`AS SW_FirstName,R.`LastName` AS RMH_Staff_LastName,R.`FirstName` AS RMH_Staff_FirstName,
    P.SW_DateStatusSubmitted, P.`RMH_DateStatusSubmitted`, P.ActivityType, P.Status, P.Notes 
    FROM RMHStaffProfile R RIGHT OUTER JOIN 
    ProfileActivity P ON R.`RMHStaffProfileID`= P.RMHStaffProfileID
    INNER JOIN SocialWorkerProfile S ON P.SocialWorkerProfileID = S.`SocialWorkerProfileID`
    INNER JOIN FamilyProfile F ON P.FamilyProfileID = F.`FamilyProfileID` 
    WHERE S.LastName = \"".$socialWorkerLastName."\"";
        
        $result = mysql_query ($query);
        if(mysql_num_rows($result)!==1){
            mysql_close();
                return false;
        }
        $result_row = mysql_fetch_assoc($result);
        $theProfileActivity = build_profileActivity($result_row);
        mysql_close();
        return $theProfileActivity;
       
    }
    
/**
 * Retrieves Profile Activity from the ProfileActivity table by RMH Staff Approver's Last Name
 * @param $rmhStaffLastName
 * @return the Room Reservation corresponding to rmhStaffLastName, or false if not in the table.
 */
    
    function retrieve_RMHStaffLastName_ProfileActivity($rmhStaffLastName){
       connect();
          
    $query = "SELECT P.ProfileActivityRequestID,F.`ParentLastName`,F.`ParentFirstName`,S. LastName AS SW_LastName, 
    S.`FirstName`AS SW_FirstName,R.`LastName` AS RMH_Staff_LastName,R.`FirstName` AS RMH_Staff_FirstName,
    P.SW_DateStatusSubmitted, P.`RMH_DateStatusSubmitted`, P.ActivityType, P.Status, P.Notes 
    FROM RMHStaffProfile R RIGHT OUTER JOIN 
    ProfileActivity P ON R.`RMHStaffProfileID`= P.RMHStaffProfileID
    INNER JOIN SocialWorkerProfile S ON P.SocialWorkerProfileID = S.`SocialWorkerProfileID`
    INNER JOIN FamilyProfile F ON P.FamilyProfileID = F.`FamilyProfileID` 
    WHERE R.LastName = \"".$rmhStaffLastName."\"";
     
        $result = mysql_query ($query);
        if(mysql_num_rows($result)!==1){
            mysql_close();
                return false;
        }
        $result_row = mysql_fetch_assoc($result);
        $theProfileActivity = build_profileActivity($result_row);
        mysql_close();
        return $theProfileActivity;
       
    }

/* 
 * auxiliary function to build a Profile Activity Request from a row in the ProfileActivity table
 */
    
function build_profileActivity($result_row) {
    $theProfileActivity = new ProfileActivity($result_row['ProfileActivityRequestID'], $result_row['ParentLastName'],
        $result_row['ParentFirstName'], $result_row['SW_LastName'], $result_row['SW_FirstName'], 
	$result_row['RMH_Staff_LastName'], $result_row['RMH_Staff_FirstName'],
	$result_row['SW_DateStatusSubmitted'], $result_row['RMH_DateStatusSubmitted'], $result_row['ActivityType'],
	$result_row['Status'], $result_row['Notes']);
   
	return $theProfileActivity;
}

/**
 * Updates the status, rmhStaffProfileId, and RMH_DateStatusSubmitted of a Profile Activity in the ProfileActivity table.
 * This function is utilized by the RMH Staff who confirms or denies a profile activity request that is made by the social worker. 
 * @param $profileChangeRequestId the ProfileActivity to update
 */

function update_status_ProfileActivity($profileActivityRequestId){
 connect();
 $query="UPDATE ProfileActivity SET RMHStaffProfileID = ".$profileActivity->get_rmhStaffProfileId().",". 
         "RMH_DateStatusSubmitted =".",".$profileActivity->get_rmhDateStatusSubmitted().",".  
         "Status ="."'$profileActivity->get_profileActivityStatus()'"."WHERE ProfileActivityRequestID =\"".$profileActivity->$profileActivityRequestId."\"";
 mysql_close();
 $result=mysql_query($query);
   	
    if(!$result) {
		echo mysql_error() . ">>>Error updating ProfileActivity table. <br>";
	    return false;
    }  
    return true;
}

/**
 * Deletes a Profile Activity Request from the ProfileActivity table.
 * @param $profileActivityRequestId the id of the ProfileActivity to delete
 */

function delete_ProfileActivity($profileActivityRequestId) {
	connect();
    $query="DELETE FROM ProfileActivity WHERE ProfileActivityRequestID=\"".$profileActivityRequestId."\"";
	$result=mysql_query($query);
	mysql_close();
	if (!$result) {
		echo (mysql_error()."unable to delete from ProfileActivity table: ".$profileActivityRequestId);
		return false;
	}
    return true;
}
?>
