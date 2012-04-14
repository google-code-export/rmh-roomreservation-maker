<?php

include_once(dirname(__FILE__).'/../domain/Family.php');
include_once(dirname(__FILE__).'/dbinfo.php');

function create_dbFamilyProfile() 
{
    connect();
    mysql_query("DROP TABLE IF EXISTS dbFamilyProfile");
    $result = mysql_query("CREATE TABLE dbFamilyProfile (familyProfileId int NOT NULL, parentFirstName varchar(50),
        parentLastName varchar(50) NOT NULL, parentEmail varchar(255), parentPhone1 varchar(20), parentPhone2 varchar(20),
        parentAddress varchar(100), parentCity varchar(50), parentState varchar(10), parentZIP varchar(12), 
        parentCountry(50), patientFirstName varchar(50) NOT NULL, patientLastNameemail varchar(50) NOT NULL,
    	patientRelation varchar(50), patientBirthDate datetime, patientFormPdf varchar(255), patientNotes text)");
    mysql_close();
    
    if (!$result) 
    {
        echo mysql_error() . "Error creating dbFamilyProfile table. <br>";
        return false;
    }
    return true;
}

function insert_dbFamilyProfile ($family)
{
    if (! $family instanceof Family) 
    {
        return false;
    }
    connect();

    $query = "SELECT * FROM dbFamilyProfile WHERE id = '" . $family->get_familyProfileId() . "'";
    $result = mysql_query($query);
    if (mysql_num_rows($result) != 0) 
    {
        delete_dbFamilyProfile ($family->get_familyProfileId());
        connect();
    }

    $query = "INSERT INTO dbFamilyProfile VALUES ('".
                $family->get_familyProfileId()."','" . 
                $family->get_parentfname()."','".
                $family->get_parentlname()."','".
                $family->get_parentemail()."','".
                $family->get_parentphone1()."','".
                $family->get_parentphone2()."','".
                $family->get_parentaddress()."','".
                $family->get_parentcity()."','".
                $family->get_parentstate()."','".
                $family->get_parentzip()."','".
                $family->get_parentcountry()."','".
                $family->get_patientfname()."','".
                $family->get_patientlname()."','".
                $family->get_patientrelation()."','".
                $family->get_patientdob()."','".
                $family->get_patientformpdf()."','".
                $family->get_patientnotes()."');";
    
    $result = mysql_query($query);
    if (!$result) 
    {
        echo (mysql_error(). " unable to insert into dbFamilyProfile: " . $family->get_familyProfileId(). "\n");
        mysql_close();
        return false;
    }
    mysql_close();
    return true;
}
          
function retrieve_dbFamilyProfile ($familyProfileId) 
{
    connect();
    $query = "SELECT * FROM dbFamilyProfile WHERE id = '".$familyProfileId."'";
    $result = mysql_query ($query);
    
    if (mysql_num_rows($result) !== 1)
    {
    	mysql_close();
        return false;
    }
    
    $result_row = mysql_fetch_assoc($result);
    $theFamily = new Family($result_row['parentFirstName'], $result_row['parentLastName'], $result_row['parentEmail'],
        $result_row['parentPhone1'], $result_row['parentPhone2'], $result_row['parentAddress'], $result_row['parentCity'],
        $result_row['parentState'], $result_row['parentZip'], $result_row['parentCountry'], $result_row['patientFirstName'],
        $result_row['patientLastName'], $result_row['patientRelation'], $result_row['patientBirthDate'],
        $result_row['patientFormPdf'], $result_row['patientNotes']);
    
    mysql_close(); 
    return $theFamily;
}

/*  Return an array of family profiles  from the FamilyProfile table
 * The first name and last name of the parent is used as the search key
* $fname = parent first name (String)
 * $lname = parent last name (String)
   *@return an array of Family objects
 */
function retrieve_dbFamilyProfileByName($fname, $lname) 
{
    connect();
    $query = "SELECT * FROM FamilyProfile WHERE ParentFirstName = '".$fname. "' AND ParentLastName='".$lname."'";
    
        // this can be useful for debugging, but turn it off before you commit!!
    //echo "query is " . $query;
    

    $result = mysql_query ($query);
    
    if (mysql_num_rows($result) <1)
    {
       mysql_close();
        return false;
    }
    
    $families = array();
    while ($result_row = mysql_fetch_assoc($result)) {
        $family = new Family($result_row['FamilyProfileID'], $result_row['ParentFirstName'], $result_row['ParentLastName'], $result_row['Email'],
                        $result_row['Phone1'], $result_row['Phone2'], $result_row['Address'], $result_row['City'],
                        $result_row['State'], $result_row['ZipCode'], $result_row['Country'], $result_row['PatientFirstName'],
                        $result_row['PatientLastName'], $result_row['PatientRelation'], $result_row['PatientBirthDate'],
                        $result_row['FormPDF'], $result_row['Notes']);


        $families[] = $family;
    }
    mysql_close();
    return $families;
}


function getall_family () 
{
    connect();
    $query = "SELECT * FROM dbFamilyProfile ORDER BY last_name";
    $result = mysql_query ($query);
    $theFamily = array();
    while ($result_row = mysql_fetch_assoc($result)) 
    {
        $theFamily = new Family($result_row['parentFirstName'], $result_row['parentLastName'], $result_row['parentEmail'],
        $result_row['parentPhone1'], $result_row['parentPhone2'], $result_row['parentAddress'], $result_row['parentCity'],
        $result_row['parentState'], $result_row['parentZip'], $result_row['parentCountry'], $result_row['patientFirstName'],
        $result_row['patientLastName'], $result_row['patientRelation'], $result_row['patientBirthDate'],
        $result_row['patientFormPdf'], $result_row['patientNotes']);
        $theFamily[] = $theFmaily;
    }
    mysql_close();
    return $theFamily; 
}

function update_dbFamilyProfile ($family) 
{
    if (! $family instanceof Family) 
        {
            echo ("Invalid argument for update_dbPersons function call");
            return false;
        }
    if (delete_dbFamilyProfile($family->get_familyProfileId()))
        return insert_dbFamilyProfile($family);
    else 
        {
            echo (mysql_error()."unable to update dbFamilyProfile table: ".$family->get_familyProfileId());
	    return false;
	}
}

function delete_dbFamilyProfile($familyProfileId) 
{
    connect();
    $query="DELETE FROM dbFamilyProfile WHERE id=\"".$familyProfileId."\"";
	$result=mysql_query($query);
	mysql_close();
	if (!$result) 
        {
            echo (mysql_error()." unable to delete from dbFamilyProfile: ".$familyProfileId);
            return false;
	}
    return true;
}

    
