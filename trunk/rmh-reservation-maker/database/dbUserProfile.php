<?php

/*
 * UserProfile module for RMH Reservation Maker
 * It may be modified for every installation of the software.
 * @author Alain Brutus
 * @version 4/06/12
 */

include_once(dirname(__FILE__).'/../domain/UserProfile.php');
include_once(dirname(__FILE__).'/dbinfo.php');


/*
 * Inserts a new User Profile into the UserProfile table
 *  $user = the user being inserted
 */

function insert_UserProfile ($user){
    if (! $user instanceof UserProfile) {
        return false;
    }
    connect();

	$query = "SELECT * FROM userprofile WHERE UserProfileID = '" . $user->get_UserProfileID() . "'";
    $result = mysql_query($query);
    if (mysql_num_rows($result) != 0) {
        delete_UserProfile ($user->get_UserProfileID());
        connect();
    }

    $query = "INSERT INTO userprofile VALUES ('".
                $user->get_UserLoginInfoID()."','" . 
                $user->get_UserEmail ()."','".
                $user->get_Password()."','".
                $user->get_UserCategory()."',')".
                
                
    $result = mysql_query($query);
    if (!$result) {
        echo (mysql_error(). " Sorry unable to insert into userprofile: " . $user->get_UserProfileID(). "\n");
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

function view_UserProfile ($UserLoginInfoID) {
	connect();
    $query = "SELECT * FROM userprofile WHERE UserLoginInfoID = '".$UserLoginInfoID."'";
    $result = mysql_query ($query);
    if (mysql_num_rows($result) !== 1){
    	mysql_close();
        return false;
    }
    $result_row = mysql_fetch_assoc($result);
    $theUserProfile = new UserProfile($result_row['UserLoginInfoID'], $result_row['UserEmail'], $result_row['password'] 
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
	if (delete_UserProfile($user->get_UserProfileID()))
	   return insert_UserProfile($user);
	else {
	   echo (mysql_error()."unable to update UserProfile table: ".$user->get_UserProfileID());
	   return false;
	}
}

/*
   *Deletes a User Profile in the UserProfile table by UserLoginInfoID
    *$UserLoginInfoID is the User Profile being deleted
 */

function delete_UserProfile($UserLoginInfoID) {
	connect();
    $query="DELETE FROM userProfile WHERE UserLoginInfoID=\"".$UserLoginInfoID."\"";
	$result=mysql_query($query);
	mysql_close();
	if (!$result) {
		echo (mysql_error()." unable to delete from UserProfile: ".$UserLoginInfoID);
		return false;
	}
    return true;
}


?>
