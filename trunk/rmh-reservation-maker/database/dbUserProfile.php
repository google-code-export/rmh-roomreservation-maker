<?php

/*
 * UserProfile module for RMH Reservation Maker
 * It may be modified for every installation of the software.
 * @author Alain Brutus
 * @version 4/06/12
 */

include_once (ROOT_DIR.'/domain/UserProfile.php');
include_once(ROOT_DIR.'/database/dbinfo.php');

/**
 * function that looks for the user profile based on the username and password provided.
 * 
 * @param string $username the username entered by the user
 * @param string $password the hashed password entered by the user
 * @return boolean false if no profile is found, OR user category if profile was found
 * @author Prayas Bhattarai
 */
function retrieve_UserByAuth($username, $password)
{
    connect();
    $query = "SELECT UserCategory FROM userprofile WHERE UsernameID = '".$username."' AND Password = '".$password."' LIMIT 1";
    $result = mysql_query($query) or die(mysql_error());
    if(mysql_num_rows($result) !== 1)
    {
        mysql_close();
        return false;
    }
    $result_row = mysql_fetch_assoc($result);

    return $result_row['UserCategory'];
    }
    
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

function delete_UserProfile($profileId) {
	connect();
    $query="DELETE FROM userProfile WHERE UsernameID=\"".$profileId."\"";
	$result=mysql_query($query);
	mysql_close();
	if (!$result) {
		echo (mysql_error()." unable to delete from UserProfile: ".$profileId);
		return false;
	}
    return true;
}

/*
   *Retrieves a User Profile in the UserProfile table by RMH Staff Approver by profileID
    *$profileid is the User Profile being retrieved for the RMH Staff Approver
   * null used to keep order of constructor when unused column in constructor
 */
function retrieve_UserProfile_RMHStaffApprover($profileId)
{
    connect();
    $query="SELECT U.UserProfileID,  U.UserCategory, R.Title,R.FirstName, R.LastName,U.UsernameID, U.Password, U.UserEmail, R.Phone
        FROM userprofile U JOIN rmhstaffprofile R
        ON U.UserProfileID= R.UserProfileID
        WHERE U.UserCategory='RMH Staff Approver' AND U.UserProfileID=\"".$profileId."\"";     
        
       $result = mysql_query ($query);
    
    if (mysql_num_rows($result) <1)
    {
       mysql_close();
        return false;
    }
    $users=array();
    while ($result_row = mysql_fetch_assoc($result)) {
    $user = new UserProfile($result_row['UserProfileID'], $result_row['Title'], $result_row['LastName'] 
    , $result_row['FirstName'], 'null', $result_row['Phone'], $result_row['UserEmail'], 'null', $result_row['UsernameID'], $result_row['UserCategory'],
    $result_row['Password']);
	
        $users[] = $user;
     }
	mysql_close();
	return $users;  

}

/*
   *Retrieves a User Profile in the UserProfile table for SocialWorker by profileID
    *$profileid is the User Profile being retrieved for the SocialWorker
*/
function retrieve_UserProfile_SW($profileId)
{
        connect();
	$query="SELECT U.UserProfileID, U.UserCategory, S.Title,S.FirstName, S.LastName,U.UsernameID, U.Password, U.UserEmail, S.Phone,S.HospitalAffiliation,S.EmailNotification
            FROM userprofile U JOIN socialworkerprofile S
            ON U.UserProfileID= S.UserProfileID
            WHERE U.UserCategory='Social Worker' AND U.UserProfileID=\"".$profileId."\"";
        
       $result = mysql_query ($query);
    
    if (mysql_num_rows($result) <1)
    {
       mysql_close();
        return false;
    }
    $users=array();
    while ($result_row = mysql_fetch_assoc($result)) {
    $user = new UserProfile($result_row['UserProfileID'], $result_row['Title'], $result_row['LastName'] 
    , $result_row['FirstName'], $result_row['HospitalAffiliation'], $result_row['Phone'], $result_row['UserEmail'], $result_row['EmailNotification'], $result_row['UsernameID'], $result_row['UserCategory'],
    $result_row['Password']);
	
        $users[] = $user;
     }
	mysql_close();
	return $users;  

}
/*
   *Retrieves a User Profile in the UserProfile table for RMH Administrator by profileID
    *$profileid is the User Profile being retrieved for the RMH Administrator
     * null used to keep order of constructor when unused column in constructor
 */
function retrieve_UserProfile_RMHAdmin($profileId) 
{
        connect();
	$query="SELECT U.UserProfileID, U.UserCategory, R.Title,R.FirstName, R.LastName,U.UsernameID, U.Password, U.UserEmail, R.Phone
            FROM userprofile U JOIN rmhstaffprofile R
            ON U.UserProfileID= R.UserProfileID
            WHERE U.UserCategory='RMH Administrator' AND U.UserProfileID=\"".$profileId."\"";
        
        $result = mysql_query ($query);
    
    if (mysql_num_rows($result) <1)
    {
       mysql_close();
        return false;
    }
    $users=array();
    while ($result_row = mysql_fetch_assoc($result)) {
    $user = new UserProfile($result_row['UserProfileID'], $result_row['Title'], $result_row['LastName'] 
    , $result_row['FirstName'], 'null', $result_row['Phone'], $result_row['UserEmail'], 'null', $result_row['UsernameID'], 
    $result_row['UserCategory'],$result_row['Password']);
	
        $users[] = $user;
     }
	mysql_close();
	return $users;  
}
?>
