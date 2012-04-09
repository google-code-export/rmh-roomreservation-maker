<?php
/**
 * Functions to create, insert, retrieve, and delete information from the
 * ProfileChange table in the database. This table is used with the ProfileChange class.  
 * @version April 06, 2012
 * @author Linda Shek 
 */

include_once(dirname(__FILE__).'/domain/ProfileChange.php');
include_once(dirname(__FILE__).'/dbinfo.php');

/**
 * Creates a ProfileActivityChange table with the following fields:
 * ProfileActivityChange: unique key of the ProfileActivityChange table.
 * ProfileActivityID: id of the ProfileActivity table. 
 * FieldName: name of the field from the FamilyProfile table. (ex. Address)
 * FieldChanges: change information corresponding to the field name.(ex. 111-11 4th Avenue)
 */

function create_ProfileActivityChange(){
	//Connect to the server
	connect();
	// Check if the table exists already
	mysql_query("DROP TABLE IF EXISTS ProfileActivityChange");
	// Create the table and store the result
	$result = mysql_query("CREATE TABLE ProfileActivityChange (
           ChangeIndex int NOT NULL AUTO_INCREMENT,
           ProfileActivityID int NOT NULL,
           FieldName varchar NOT NULL,
           FieldChanges varchar(255) NOT NULL,
           UNIQUE KEY ChangeIndex (ChangeIndex))");
        
	// Check if the creation was successful
	if(!$result){
		// Print an error
		echo mysql_error(). ">>>Error creating ProfileActivityChange table <br>";
		mysql_close();
		return false;
	}
	mysql_close();
	return true;
}

/**
 * Inserts a new Profile Change into the ProfileActivity table. This function
 * will be utilized by the social worker. 
 * @param $profileChange = the profileChange to insert
 */

function insert_ProfileActivityChange ($profileChange)
{
     if (! $profileChange instanceof ProfileChange) {
		echo ("Invalid argument for insert_ProfileActivityChange function call");
		return false;
	}
        connect();  
     
     $query="INSERT INTO ProfileActivityChange ('".
                $profileChange->get_profileActivityId()."','".
                $profileChange->get_profileChangeFieldName()."','".     
                $profileChange->get_profileChangeFieldChanges()."')";
     
    $result=mysql_query($query);
        if (!$result) {
            
		echo (mysql_error()."unable to insert into ProfileActivityChange: ".$profileChange->get_profileChangeIndex()."\n");
		mysql_close();     
    }
}

/**
 * Retrieves a Profile Activity Change from the ProfileActivityChange table by the ChangeIndex
 * @param $profileChangeIndex
 * @return the Profile Change corresponding to ProfileChangeIndex, or false if not in the table.
 */

function retrieve_ProfileActivityChange($profileChangeIndex){
        connect();
        
   $query = "SELECT ProfileActivityID, FieldName, FieldChanges FROM ProfileActivityChange 
            WHERE ChangeIndex = \"".$profileChangeIndex."\"";       
                
            $result = mysql_query ($query);
        if (mysql_num_rows($result)!==1) {
	    mysql_close();
		return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theProfileChange = build_profileChange($result_row);
	mysql_close();
	return $theProfileChange; 
}

/* 
 * auxiliary function to build a Profile Activity Change from a row in the ProfileActivityChange table
 */

function build_profileChange($result_row) {
    $theProfileChange = new ProfileChange($result_row['ProfileActivityID'], $result_row['FieldName'],
        $result_row['FieldChanges']);
   
	return $theProfileChange;
}

/**
 * Deletes a ProfileActivityChange from the ProfileActivityChange table.
 * @param $profileChangeIndex of the ProfileActivityChange table to delete
 */

function delete_ProfileActivityChange($profileChangeIndex) {
	connect();
    $query="DELETE FROM ProfileActivityChange WHERE ChangeIndex=\"".$profileChangeIndex."\"";
	$result=mysql_query($query);
	mysql_close();
	if (!$result) {
		echo (mysql_error()."unable to delete from ProfileActivityChange table: ".$profileChangeIndex);
		return false;
	}
    return true;
}


?>
