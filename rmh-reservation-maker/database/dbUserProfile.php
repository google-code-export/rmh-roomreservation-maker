<?php

/*
 * UserProfile module for RMH Reservation Maker
 * It may be modified for every installation of the software.
 * @author Alain Brutus
 * @version 4/22/12
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
    $query = "SELECT UserCategory, UserProfileID FROM userprofile WHERE UsernameID = '".$username."' AND Password = '".$password."' LIMIT 1";
    $result = mysql_query($query) or die(mysql_error());
    if(mysql_num_rows($result) !== 1)
    {
        mysql_close();
        return false;
    }
     $result_row = mysql_fetch_assoc($result);

     return $result_row;
 }
      
/*
 * Inserts a new User Profile into the UserProfile table
 * $userprofile = the user being inserted
 *
 * @author: Linda Shek
 */

function insert_UserProfile ($userprofile){
    if (! $userprofile instanceof UserProfile) {
        return false;
    }
    connect();
    
        //Check if the user profile already exists
        $query = "SELECT * FROM userprofile WHERE UserProfileID =".$userprofile->get_userProfileId();
         
         $result = mysql_query($query) or die(mysql_error());
        
        if(mysql_num_rows($result)>0){
            //Need to return an update function if already exists. 
            return update_UserProfile($userprofile);
        }
    
    /*
	$query = "SELECT * FROM userprofile WHERE UserProfileID = '" . $userprofile->get_profileId() . "'";
    $result = mysql_query($query);
    if (mysql_num_rows($result) != 0) {
        delete_UserProfile ($userprofile->get_profileId());
        connect();
    }*/

    $query = "INSERT INTO userprofile (UsernameID, UserEmail, Password, UserCategory) VALUES ('".
                $userprofile->get_usernameId()."','".
                $userprofile->get_userEmail()."','".
                $userprofile->get_password()."','".
                $userprofile->get_userCategory()."')";
       

    $result = mysql_query($query);
    if (!$result) {
        echo (mysql_error()." Sorry unable to insert into UserProfile.");
        mysql_close();
        return false;
    }
    mysql_close();
    return true;
}


/**
 * Inserts a new Social Worker Profile into the SocialWorkerProfile table
 * @param $userprofile = the userprofile to insert
 *
 * @author: Linda Shek
 */

function insert_SocialWorkerProfile($userprofile){
    if (! $userprofile instanceof UserProfile) {
        return false;
    }
    connect();
    
        //Check if the social worker profile already exists
        $query = "SELECT * FROM socialworkerprofile WHERE SocialWorkerProfileID =".$userprofile->get_swProfileId()." 
            AND UserProfileID =".$userprofile->get_userProfileId();
                
         $result = mysql_query($query) or die(mysql_error());
        
        if(mysql_num_rows($result)>0){
            //Need to return an update function if already exists. 
            return update_SocialWorkerProfile($userprofile);
        }
        
    $query = "INSERT INTO socialworkerprofile (UserProfileID, Title, FirstName, LastName, HospitalAffiliation, Phone,
              EmailNotification) VALUES (".
                $userprofile->get_userProfileId().",'" . 
                $userprofile->get_swTitle()."','".
                $userprofile->get_swFirstName()."','".
                $userprofile->get_swLastName()."','".
                $userprofile->get_hospitalAff()."','".
                $userprofile->get_swphone()."','".
                $userprofile->get_email_notification()."')";
   
        $result = mysql_query($query);
    if (!$result) {
        echo (mysql_error()." Sorry unable to insert into SocialWorkerProfile.");
        mysql_close();
        return false;
    }
    mysql_close();
    return true;
}

/**
 * Inserts a new RMH Staff Profile into the RMHStaffProfile table
 * @param $userprofile = the userprofile to insert
 *
 * @author: Linda Shek
 */

function insert_RmhStaffProfile($userprofile){
    if (! $userprofile instanceof UserProfile) {
        return false;
    }
    connect();
    
        //Check if the rmh staff profile already exists
        $query = "SELECT * FROM rmhstaffprofile WHERE RMHStaffProfileID =".$userprofile->get_rmhStaffProfileId();
         $result = mysql_query($query) or die(mysql_error());
        
        if(mysql_num_rows($result)>0){
            //Need to return an update function if already exists. 
            return update_RMHStaffProfile($userprofile);
        }
    
    $query = "INSERT INTO rmhstaffprofile (UserProfileID, Title, FirstName, LastName, Phone) VALUES (".
                $userprofile->get_userProfileId().",'" . 
                $userprofile->get_rmhStaffTitle()."','".
                $userprofile->get_rmhStaffFirstName()."','".
                $userprofile->get_rmhStaffLastName()."','".
                $userprofile->get_rmhStaffphone()."')";
    
     $result = mysql_query($query);
        if (!$result) {
        echo (mysql_error()." Sorry unable to insert into RMH Staff Profile.");
        mysql_close();
        return false;
    }
    mysql_close();
    return true;
}

/**
 * function to update the User Profile
 * @param $userprofile = the userprofile to update
 *
 * @author: Linda Shek
 */

function update_UserProfile($userprofile){
    connect();
    
    $query = "UPDATE userprofile SET UsernameID ='".$userprofile->get_usernameId()."',". 
            "UserEmail = '".$userprofile->get_userEmail()."',"."Password ='".$userprofile->get_password()."',". 
            "UserCategory ='".$userprofile->get_userCategory()."' WHERE UserProfileID =".$userprofile->get_userProfileId();

      
    $result = mysql_query($query);
   	
    if(!$result) {
		echo mysql_error() . ">>>Error updating UserProfile. <br>";
	    return false;
    }  
    mysql_close();
    return true;
}


/**
 * function to update the SocialWorkerProfile
 * @param $userprofile = the userprofile to update
 *
 * @author: Linda Shek
 */

function update_SocialWorkerProfile($userprofile){
    connect();
    
    $query = "UPDATE socialworkerprofile SET Title ='".$userprofile->get_swTitle()."',". 
             "FirstName = '".$userprofile->get_swFirstName()."',"."LastName ='".$userprofile->get_swLastName()."',". 
             "HospitalAffiliation ='".$userprofile->get_hospitalAff()."',".
             "Phone='".$userprofile->get_swphone()."',". 
             "EmailNotification ='".$userprofile->get_email_notification()."' WHERE UserProfileID =".$userprofile->get_userProfileId()
              ." AND SocialWorkerProfileID = ".$userprofile->get_swProfileId();
      
    $result = mysql_query($query);
   	
    if(!$result) {
		echo mysql_error() . ">>>Error updating SocialWorkerProfile. <br>";
	    return false;
    }  
    mysql_close();
    return true;
}


/**
 * function to update the RMHStaffProfile
 * @param $userprofile = the userprofile to update
 *
 * @author: Linda Shek
 */

function update_RMHStaffProfile($userprofile){
        connect();
    
    $query = "UPDATE rmhstaffprofile SET Title ='".$userprofile->get_rmhStaffTitle()."',". 
            "FirstName = '".$userprofile->get_rmhStaffFirstName()."',"."LastName ='".$userprofile->get_rmhStaffLastName()."',". 
            "Phone ='".$userprofile->get_rmhStaffPhone()."' WHERE UserProfileID =".$userprofile->get_userProfileId()
            ." AND RMHStaffProfileID = ".$userprofile->get_rmhStaffProfileId();
      
    $result = mysql_query($query);
   	
    if(!$result) {
		echo mysql_error() . ">>>Error updating RMHStaffProfile. <br>";
	    return false;
    }  
    mysql_close();
    return true;
}
    


/**
 * Retrieves User Profiles in the User Profile table by Role. 
 * This function will be utilized by the administrator to view a list of 
 * users by roles.
 * 
 * @author: Linda Shek
 */

function retrieve_all_UserProfile_byRole($userCategory){

    connect();
    
    $query = "SELECT U.UserCategory, U.UserProfileID, U.UsernameID, U.UserEmail, U.Password, 
        R.RMHStaffProfileID, R.Title AS RMH_Staff_Title, R.FirstName AS RMH_Staff_FirstName, 
        R.LastName AS RMH_Staff_LastName, R.Phone AS RMH_Staff_Phone, S.SocialWorkerProfileID, 
        S.Title AS SW_Title, S.FirstName AS SW_FirstName, S.LastName AS SW_LastName, 
        S.HospitalAffiliation, S.Phone AS SW_Phone, S.EmailNotification
        FROM userprofile U LEFT OUTER JOIN socialworkerprofile S ON S.UserProfileID = U.UserProfileID 
        LEFT OUTER JOIN rmhstaffprofile R ON R.UserProfileID = U.UserProfileID 
        Where U.UserCategory = '".$userCategory."'";
  
   $result = mysql_query($query) or die(mysql_error());
        if(mysql_num_rows($result)===0){
            mysql_close();
                return false;
        }
   
         $theUserProfiles = array();
         while ($result_row = mysql_fetch_assoc($result)) {
         $theUserProfile = build_userprofile($result_row);
         $theUserProfiles[] =  $theUserProfile;
         }
   
         mysql_close();
         return $theUserProfiles;
      }
      
 /* 
 * auxiliary function to build a User Profile, Social Worker Profile, and RMH Staff Profile from a row in the UserProfile table, SocialWorkerProfile table, 
 * and RMHStaffProfile table, respectively. 
 *
 * @author: Linda Shek
 */

    function build_userprofile($result_row) {
    $theUserProfiles = new userprofile($result_row['UserCategory'], $result_row['UserProfileID'], $result_row['UsernameID'],$result_row['UserEmail'],
    $result_row['Password'], $result_row['RMHStaffProfileID'],$result_row['RMH_Staff_Title'], $result_row['RMH_Staff_FirstName'],
    $result_row['RMH_Staff_LastName'], $result_row['RMH_Staff_Phone'], $result_row['SocialWorkerProfileID'], $result_row['SW_Title'],
    $result_row['SW_FirstName'], $result_row['SW_LastName'], $result_row['HospitalAffiliation'], $result_row['SW_Phone'], 
    $result_row['EmailNotification']);
                        
	return $theUserProfiles;
}
    /*
  *Retrieves  User Profile in the UserProfile table by RMH Staff Approver by profileID
   *$profileid is the User Profile being retrieved for the RMH Staff Approver
     *null used to keep order of constructor when unused column in constructor
     * Returns an Object
   *@author: Alain Brutus
 */

function retrieve_UserProfile_RMHApprover_OBJ($userProfileId)
{
    connect();
    $query="SELECT U.UserProfileID, U.UserCategory,R.RMHStaffProfileID ,R.Title,R.FirstName, R.LastName,U.UsernameID, U.Password, U.UserEmail, R.Phone
        FROM userprofile U JOIN rmhstaffprofile R
        ON U.UserProfileID= R.UserProfileID
        WHERE U.UserCategory='RMH Staff Approver' AND U.UserProfileID=\"".$userProfileId."\"";     
        
       $result = mysql_query($query) or die(mysql_error());
    
    if (mysql_num_rows($result) <1)
    {
       mysql_close();
        return false;
    }
    $result_row = mysql_fetch_assoc($result); 
    $user = new UserProfile($result_row['UserCategory'], $result_row['UserProfileID'], $result_row['UsernameID'],$result_row['UserEmail'],
    $result_row['Password'], $result_row['RMHStaffProfileID'],$result_row['Title'], $result_row['FirstName'],
    $result_row['LastName'], $result_row['Phone'],'null', 'null',
    'null', 'null', 'null', 'null', 'null');
	
        mysql_close();
	return $user;  

}

/*
    *Retrieves a User Profile in the UserProfile table for SocialWorker by profileID
      *$profileid is the User Profile being retrieved for the SocialWorker
 * Returns an object
    *@author: Alain Brutus
*/

function retrieve_UserProfile_SW_OBJ($userProfileId)
{
        connect();
	$query="SELECT U.UserProfileID, U.UserCategory, S.SocialWorkerProfileID,S.Title,S.FirstName, S.LastName,U.UsernameID, U.Password, U.UserEmail, S.Phone,S.HospitalAffiliation,S.EmailNotification
            FROM userprofile U JOIN socialworkerprofile S
            ON U.UserProfileID= S.UserProfileID
            WHERE U.UserCategory='Social Worker' AND U.UserProfileID=\"".$userProfileId."\"";
        
        $result = mysql_query($query) or die(mysql_error());
    
    if (mysql_num_rows($result) <1)
    {
       mysql_close();
        return false;
    }
    
    $result_row = mysql_fetch_assoc($result); 
    $user = new UserProfile($result_row['UserCategory'], $result_row['UserProfileID'], $result_row['UsernameID'],$result_row['UserEmail'],
    $result_row['Password'],'null','null', 'null',
    'null', 'null', $result_row['SocialWorkerProfileID'], $result_row['Title'],
    $result_row['FirstName'], $result_row['LastName'], $result_row['HospitalAffiliation'], $result_row['Phone'], 
    $result_row['EmailNotification']);
	
        mysql_close();
	return $user;  

}

/*
  *Retrieves a User Profile in the UserProfile table by RMH Staff Approver by profileID
   *$profileid is the User Profile being retrieved for the RMH Staff Approver
     *null used to keep order of constructor when unused column in constructor
 * Returns an array
   *@author: Alain Brutus
 */

function retrieve_UserProfile_RMHStaffApprover($userProfileId)
{
    connect();
    $query="SELECT U.UserProfileID, U.UserCategory,R.RMHStaffProfileID ,R.Title,R.FirstName, R.LastName,U.UsernameID, U.Password, U.UserEmail, R.Phone
        FROM userprofile U JOIN rmhstaffprofile R
        ON U.UserProfileID= R.UserProfileID
        WHERE U.UserCategory='RMH Staff Approver' AND U.UserProfileID=\"".$userProfileId."\"";     
        
       $result = mysql_query ($query);
    
    if (mysql_num_rows($result) <1)
    {
       mysql_close();
        return false;
    }
    $user=array();
    while ($result_row = mysql_fetch_assoc($result)) {
    $userprofile = new UserProfile($result_row['UserCategory'], $result_row['UserProfileID'], $result_row['UsernameID'],$result_row['UserEmail'],
    $result_row['Password'], $result_row['RMHStaffProfileID'],$result_row['Title'], $result_row['FirstName'],
    $result_row['LastName'], $result_row['Phone'],'null', 'null',
    'null', 'null', 'null', 'null', 'null');
	
        $user[] = $userprofile;
     }
	mysql_close();
	return $user;  

}

/*
    *Retrieves a User Profile in the UserProfile table for SocialWorker by profileID
      *$profileid is the User Profile being retrieved for the SocialWorker
 * Returns an array
    *@author: Alain Brutus
*/

function retrieve_UserProfile_SW($userProfileId)
{
        connect();
	$query="SELECT U.UserProfileID, U.UserCategory, S.SocialWorkerProfileID,S.Title,S.FirstName, S.LastName,U.UsernameID, U.Password, U.UserEmail, S.Phone,S.HospitalAffiliation,S.EmailNotification
            FROM userprofile U JOIN socialworkerprofile S
            ON U.UserProfileID= S.UserProfileID
            WHERE U.UserCategory='Social Worker' AND U.UserProfileID=\"".$userProfileId."\"";
        
       $result = mysql_query ($query);
    
    if (mysql_num_rows($result) <1)
    {
       mysql_close();
        return false;
    }
    $user=array();
    while ($result_row = mysql_fetch_assoc($result)) {
    $userprofile = new UserProfile($result_row['UserCategory'], $result_row['UserProfileID'], $result_row['UsernameID'],$result_row['UserEmail'],
    $result_row['Password'],'null','null', 'null',
    'null', 'null', $result_row['SocialWorkerProfileID'], $result_row['Title'],
    $result_row['FirstName'], $result_row['LastName'], $result_row['HospitalAffiliation'], $result_row['Phone'], 
    $result_row['EmailNotification']);
	
        $user[] = $userprofile;
     }
	mysql_close();
	return $user;  

}


/*
   *Retrieves a User Profile in the UserProfile table for RMH Administrator by profileID
    *$profileid is the User Profile being retrieved for the RMH Administrator
     * null used to keep order of constructor when unused column in constructor
*@author: Alain Brutus
 */

function retrieve_UserProfile_RMHAdmin($userProfileId) 
{
        connect();
	$query="SELECT U.UserProfileID, U.UserCategory, R.RMHStaffProfileID, R.Title,R.FirstName, R.LastName,U.UsernameID, U.Password, U.UserEmail, R.Phone
            FROM userprofile U JOIN rmhstaffprofile R
            ON U.UserProfileID= R.UserProfileID
            WHERE U.UserCategory='RMH Administrator' AND U.UserProfileID=\"".$userProfileId."\"";
        
        $result = mysql_query ($query);
    
    if (mysql_num_rows($result) <1)
    {
       mysql_close();
        return false;
    }
    $user=array();
    while ($result_row = mysql_fetch_assoc($result)) {
    $userprofile = new UserProfile($result_row['UserCategory'], $result_row['UserProfileID'], $result_row['UsernameID'],$result_row['UserEmail'],
    $result_row['Password'], $result_row['RMHStaffProfileID'],$result_row['Title'], $result_row['FirstName'],
    $result_row['LastName'], $result_row['Phone'],'null', 'null',
    'null', 'null', 'null', 'null', 'null');
	
        $user[] = $userprofile;
     }
	mysql_close();
	return $user;  
}

/**
 * Deletes a User Profile in the User Profile table by UserProfileID. 
 * Note: Need to delete the child record first, before you can proceed to delete the parent record. 
 *
 * @author: Linda Shek
 */

function delete_UserProfile($userProfileId) 
{
    connect();
    $query="DELETE FROM userprofile WHERE UserProfileID=".$userProfileId;
    
	$result=mysql_query($query);
	mysql_close();
	if (!$result) 
        {
            echo (mysql_error()."unable to delete from UserProfile: ".$userProfileId);
            return false;
	}
    return true;
}


/**
 * Deletes a Social Worker Profile in the SocialWorkerProfile table by SocialWorkerProfileID. 
 * 
 * @author: Linda Shek
 */

function delete_SocialWorkerProfile($swProfileId) 
{
    connect();
    $query="DELETE FROM socialworkerprofile WHERE SocialWorkerProfileID=".$swProfileId;
      
	$result=mysql_query($query);
	mysql_close();
	if (!$result) 
        {
            echo (mysql_error()."unable to delete from SocialWorkerProfile: ".$swProfileId);
            return false;
	}
    return true;
}


/**
 * Deletes an RMH Staff Profile in the RMHStaffProfile table by RMHStaffProfileID. 
 * 
 * @author: Linda Shek
 */

function delete_RMHStaffProfile($rmhStaffProfileId) 
{
    connect();
    $query="DELETE FROM rmhstaffprofile WHERE RMHStaffProfileID=".$rmhStaffProfileId;

	$result=mysql_query($query);
	mysql_close();
	if (!$result) 
        {
            echo (mysql_error()."unable to delete from RMHStaffProfile: ".$rmhStaffProfileId);
            return false;
	}
    return true;
}

?>
