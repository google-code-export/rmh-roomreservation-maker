<?php

/*
 * UserProfile module for RMH Reservation Maker
 * It may be modified for every installation of the software.
 * @author Alain Brutus
 * @version 4/06/12
 */

include_once (ROOT_DIR.'/domain/UserProfile.php');
include_once(ROOT_DIR.'/database/dbinfo.php');


/*
 * Inserts a new User Profile into the UserProfile table
 *  $user = the user being inserted
 */

function insert_UserProfile ($user){
    if (! $user instanceof UserProfile) {
        return false;
    }
    connect();

	$query = "SELECT * FROM userprofile WHERE UserProfileID = '" . $user->get_profileId() . "'";
    $result = mysql_query($query);
    if (mysql_num_rows($result) != 0) {
        delete_UserProfile ($user->get_profileId());
        connect();
    }

    $query = "INSERT INTO userprofile VALUES ('".
                $user->get_profileId()."','" . 
                $user->get_title ()."','".
                $user->get_firstName()."','".
                $user->get_lastName()."','". 
                $user->get_hospitalAff ()."','".
                $user->get_phone ()."','".
                $user->get_email ()."','".
                $user->get_email_notification ()."','".
                $user->get_userLoginInfoId ()."','".
                $user->get_userCategory ()."','".
                $user->get_password ()."',')".
                
    $result = mysql_query($query);
    if (!$result) {
        echo (mysql_error(). " Sorry unable to insert into userprofile: " . $user->get_profileId(). "\n");
        mysql_close();
        return false;
    }
    mysql_close();
    return true;
}

/* View a User Profile from the UserProfile table
    *$UserLoginInfoID is the user login id
   *@return the user Profile corresponding to user login id, or false if not in the table.
 */

function retrieve_UserProfile ($UsernameID) {
	connect();
    $query = "SELECT * FROM userprofile WHERE UsernameID = '".$UsernameID."'";
    $result = mysql_query ($query);
    if (mysql_num_rows($result) !== 1){
    	mysql_close();
        return false;
    }
    $result_row = mysql_fetch_assoc($result);
    $theUserProfile = new UserProfile($result_row['UsernameID'], $result_row['UserEmail'], $result_row['password'] 
    , $result_row['UserCategory']);
    
//    mysql_close(); 
    return $theUserProfile;   
}


/*
  * Updates a User Profile in the UserProfile table by deleting it and re-inserting it
    *$user the user to update
 */

function update_UserProfile ($user) {
if (! $user instanceof user) {
		echo ("Invalid argument for update_UserProfile function call");
		return false;
	}
	if (delete_UserProfile($user->get_profileId()))
	   return insert_UserProfile($user);
	else {
	   echo (mysql_error()."unable to update UserProfile table: ".$user->get_profileId());
	   return false;
	}
}

/*
   *Deletes a User Profile in the UserProfile table by UserLoginInfoID
    *$UserLoginInfoID is the User Profile being deleted
 */

function delete_UserProfile($UsernameID) {
	connect();
    $query="DELETE FROM userProfile WHERE UsernameID=\"".$UsernameID."\"";
	$result=mysql_query($query);
	mysql_close();
	if (!$result) {
		echo (mysql_error()." unable to delete from UserProfile: ".$UsernameID);
		return false;
	}
    return true;
}

/*
   *Retrieves a User Profile in the UserProfile table by RMH Staff Approver by profileID
    *$profileid is the User Profile being retrieved for the RMH Staff Approver
 */
function retrieve_UserProfile_RMHStaffApprover($profileId)
{
    $query="SELECT U.UserProfileID, R.UserProfileID, U.UserCategory, R.Title,R.FirstName, R.LastName,U.UsernameID, U.Password, U.UserEmail, R.Phone
        FROM userprofile U JOIN rmhstaffprofile R
        ON U.UserProfileID= R.UserProfileID
        WHERE U.UserCategory='RMH Staff Approver' AND U.UsernameID=\"".$profileId."\"";     
        
        $result = mysql_query ($query);
        if (mysql_num_rows($result)!==1) {
	    mysql_close();
		return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$RMHStaffProfile = get_rowRMHStaffProfile($result_row);
	mysql_close();
	return $RMHStaffProfile;  

}

/*
   *Retrieves a User Profile in the UserProfile table for SocialWorker by profileID
    *$profileid is the User Profile being retrieved for the SocialWorker
 */
function retrieve_UserProfile_SW($profileId)
{
	$query="SELECT U.UserProfileID, S.UserProfileID, U.UserCategory, S.Title,S.FirstName, S.LastName,U.UsernameID, U.Password, U.UserEmail, S.Phone,S.EmailNotification
            FROM userprofile U JOIN socialworkerprofile S
            ON U.UserProfileID= S.UserProfileID
            WHERE U.UserCategory='Social Worker' AND U.UsernameID=\"".$profileId."\"";
        
        $result = mysql_query ($query);
        if (mysql_num_rows($result)!==1) {
	    mysql_close();
		return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theSocialWorker = get_rowSocialWorker($result_row);
	mysql_close();
	return $theSocialWorker;  

}


/*
   *Retrieves a User Profile in the UserProfile table for RMH Administrator by profileID
    *$profileid is the User Profile being retrieved for the RMH Administrator
 */
function retrieve_UserProfile_RMHAdmin($profileId) 
{
	$query="SELECT U.UserProfileID, R.UserProfileID, U.UserCategory, R.Title,R.FirstName, R.LastName,U.UsernameID, U.Password, U.UserEmail, R.Phone
            FROM userprofile U JOIN rmhstaffprofile R
            ON U.UserProfileID= R.UserProfileID
            WHERE U.UserCategory='RMH Administrator' AND U.UsernameID=\"".$profileId."\"";
        
        $result = mysql_query ($query);
        if (mysql_num_rows($result)!==1) {
	    mysql_close();
		return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$RMHStaffProfile = get_rowRMHStaffProfile($result_row);
	mysql_close();
	return $RMHStaffProfile;  
}

/*
   *Functions that takes in the return results from query and returns an array of results
    *$profileid is the User Profile being retrieved for the RMH Administrator
 */
function get_rowSocialWorker($result_row) {
    $theSocialWorker = new Requests($result_row['UserProfileID'], $result_row['UserCategory'],
        $result_row['Title'], $result_row['FirstName'], $result_row['Lastname'], 
	    $result_row['UsernameID'], $result_row['Password'],
	    $result_row['UserEmail'], $result_row['Phone'],$result_row['EmailNotification']);
   
	return $theSocialWorker;
}

function get_rowRMHStaffProfile($result_row) {
    $theRMHStaffProfile = new Requests($result_row['UserProfileID'], $result_row['UserCategory'],
        $result_row['Title'], $result_row['FirstName'], $result_row['Lastname'], 
	    $result_row['UsernameID'], $result_row['Password'],
	    $result_row['UserEmail'], $result_row['Phone']);
   
	return $theRMHStaffProfile;
}

?>
