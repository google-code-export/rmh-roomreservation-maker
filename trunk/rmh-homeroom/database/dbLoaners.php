<?php
/*
 * Copyright 2011 by Alex Lucyk, Jesus Navarro, and Allen Tucker.
 * This program is part of RMH Homeroom, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

/**
 * Functions to create, retrieve, update, and delete information from the
 * dbLoaners table in the database.  This table is used with the Loaner class.  
 * @version February 25, 2011
 * @author Allen
 */

include_once(dirname(__FILE__).'/../domain/Loaner.php');
include_once(dirname(__FILE__).'/dbinfo.php');

/**
 * Create the dbLoaners table with the following fields:
 * id: uniquely identifies a loaner, like "remote1"
 * type: "remote", "fan", or "airbed"
 * status: "available", "inuse", or "lost"
 * booking_id: if status == "inuse", link to its booking, otherwise null
 */
function create_dbLoaners() {
    connect();
    mysql_query("DROP TABLE IF EXISTS dbLoaners");
    $result=mysql_query("CREATE TABLE dbLoaners (id VARCHAR(8) NOT NULL, type TEXT,
								status TEXT, booking_id TEXT, PRIMARY KEY (id))");
    mysql_close();	
    if(!$result) {
		echo mysql_error() . ">>>Error creating dbLoaners table. <br>";
	    return false;
    }
    return true;
}

/**
 * Inserts a new loaner into the dbLoaners table
 * @param $loaner = the loaner to insert
 */
function insert_dbLoaners ($loaner) {
    if (! $loaner instanceof Loaner) {
		echo ("Invalid argument for insert_dbLoaners function call");
		return false;
	}
    connect();
    $query = "SELECT * FROM dbLoaners WHERE id ='".$loaner->get_id()."'";
    $result = mysql_query ($query);
    if (mysql_num_rows($result)!=0) {
        delete_dbLoaners ($loaner->get_id());
        connect();
    }
    $query="INSERT INTO dbLoaners VALUES ('".
				$loaner->get_id()."','".
				$loaner->get_type()."','".
				$loaner->get_status()."','".
				$loaner->get_booking_id()."')";
	$result=mysql_query($query);
    if (!$result) {
		echo (mysql_error()."unable to insert into dbLoaners: ".$loaner->get_id()."\n");
		mysql_close();
    return false;
    }
    mysql_close();
    return true;
 }

/**
 * Retrieves a Loaner from the dbLoaners table
 * @param $id loaner_id
 * @return $loaner with same loaner_id, or else false if not in the table.
 */
function retrieve_dbLoaners ($id) {
	connect();
    $query = "SELECT * FROM dbLoaners WHERE id =\"".$id."\"";
    $result = mysql_query ($query);
    if (mysql_num_rows($result)!==1) {
	    mysql_close();
		return false;
	}
	$result_row = mysql_fetch_assoc($result);
	mysql_close();
	$theLoaner = new Loaner($result_row['id'], $result_row['type'], $result_row['status'], $result_row['booking_id']);
	return $theLoaner;
}

/**
 * Updates a loaner in the dbLoaners table by deleting it and re-inserting it
 * @param $loaner the week to update
 */
function update_dbLoaners ($loaner) {
	if (! $loaner instanceof Loaner) {
		echo ("Invalid argument for update_dbLoaners function call");
		return false;
	}
	if (delete_dbLoaners($loaner->get_id()))
	   return insert_dbLoaners($loaner);
	else {
	   echo (mysql_error()."unable to update dbLoaners table: ".$loaner->get_id());
	   return false;
	}
}

/**
 * Deletes a loaner from the dbLoaners table
 * @param $loaner the id of the loaner to delete
 */
function delete_dbLoaners($id) {
	connect();
    $query="DELETE FROM dbLoaners WHERE id=\"".$id."\"";
	$result=mysql_query($query);
	mysql_close();
	if (!$result) {
		echo (mysql_error()."unable to delete from dbLoaners: ".$id);
		return false;
	}
    return true;
}

?>
