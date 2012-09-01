<?php
/**
 * Functions to create, retrieve, update, and delete information from the
 * FamilyProfile table in the database. This table is used with the family class.  
 * @version April 22, 2012
 * @author Weiyu Shang
 */

include_once(ROOT_DIR.'/domain/Family.php');
include_once(ROOT_DIR.'/database/dbinfo.php');

/**
 * Creates a FamilyProfile table with the following fields:
 * FamilyProfileID: primary key of the FamilyProfile table.
 * ParentFirstName: first name of the parent. 
 * ParentLastName: last name of the parent. 
 * Email: email address of the parent. 
 * Phone1: primary phone number of the parent. 
 * Phone2: secondary phone number of the parent. 
 * Address: parent address. 
 * City: parent city.
 * State: parent state. 
 * ZipCode: parent zipcode.
 * Country: parent country. 
 * PatientFirstName: first name of the patient. 
 * PatientLastName: last name of the patient. 
 * PatientRelation: patient relation with the parent
 * PatientDateOfBirth: Patient's date of birth
 * FormPDF: the URL of the Form. 
 * Notes: (optional) notes about the family.
 */

/**DO NOT CALL THE FUNCTION create_FamilyProfile() if TABLE ALREADY EXISTS. 
function create_FamilyProfile(){
    connect();
    mysql_query("DROP TABLE IF EXISTS FamilyProfile");
    $result = mysql_query("CREATE TABLE FamilyProfile (
        FamilyProfileID int NOT NULL AUTO_INCREMENT,
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
        Notes text,
        PRIMARY KEY (FamilyProfileID))");
    mysql_close();
    if (!$result){
        echo mysql_error() . ">>>Error creating FamilyProfile table. <br>";
        return false;
    }
    return true;
}
**/

/**
 * function that inserts a Family Profile based on the FamilyProfileID, ParentFirstName, ParentLastName, Email
 * Phone1, Phone2, Address, City, State, ZipCode, Country, PatientFirstName, PatientLastName, PatientRelation
 * PatientDateOfBirth, FormPDF, and Notes provided. 
 * Note: if calling function insert_FamilyProfileDetail make -1 as a placeholder for familyProfileId. 
 *
 * @author Linda Shek 
 */
 
function insert_FamilyProfileDetail($familyProfileId, $parentFirstName, $parentLastName, $parentEmail,
            $parentPhone1, $parentPhone2, $parentAddress, $parentCity, $parentState, $parentZIP,
            $parentCountry, $patientFirstName, $patientLastName, $patientRelation,
            $patientDateOfBirth, $patientFormPdf, $patientNotes){
    
    $family = new Family ($familyProfileId, $parentFirstName, $parentLastName, $parentEmail,
            $parentPhone1, $parentPhone2, $parentAddress, $parentCity, $parentState, $parentZIP,
            $parentCountry, $patientFirstName, $patientLastName, $patientRelation,
            $patientDateOfBirth, $patientFormPdf, $patientNotes);
   return insert_FamilyProfile ($family);
}

/**
 * function to insert family profile using class object Family.
 * @return boolean false if no family profile was inserted, OR true if family profile was inserted. 
 * 
 * @author Linda Shek
 */

function insert_FamilyProfile ($family){
    
    if (! $family instanceof Family) {
        echo("Invaild argument for insert_FamilyProfile function call");
        return false;
    }
    connect();

   /* $query = "SELECT * FROM FamilyProfile WHERE id = '" . $family->get_familyProfileId() . "'";
    $result = mysql_query($query);
    if (mysql_num_rows($result) != 0) 
    {
        delete_dbFamilyProfile ($family->get_familyProfileId());
        connect();
    }*/

    $query = "INSERT INTO familyprofile (ParentFirstName, ParentLastName, Email, Phone1, 
                Phone2, Address, City, State, ZipCode, Country, PatientFirstName, PatientLastName,
                PatientRelation, PatientDateOfBirth, FormPDF, Notes) VALUES ('". 
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
                $family->get_patientnotes()."')";
    
        echo "<br>";
        $result = mysql_query($query);
   
       if (!$result) {
        echo (mysql_error()."<br>". "Unable to insert into FamilyProfile.");
        mysql_close();
        return false;
    }
    mysql_close();
    return true;
}
   
/**
 * Retrieves a Family Profile from the FamilyProfile table by familyProfileId
 * @param $familyProfileId 
 * @return the Family Profile corresponding to familyProfileId, or false if not in the table.
 */

function retrieve_FamilyProfile ($familyProfileId) 
{
    connect();
    $query = "SELECT * FROM familyprofile WHERE FamilyProfileID = ".$familyProfileId;
    $result = mysql_query($query) or die(mysql_error());
    
    if (mysql_num_rows($result) !== 1){
    	mysql_close();
        return false;
    }
    
    $result_row = mysql_fetch_assoc($result);
    $theFamily = build_family($result_row);
    mysql_close();
    return $theFamily;
}

/* 
 * auxiliary function to build a Family Profile from a row in the FamilyProfile table
 */

function build_family($result_row){
    $theFamily = new Family($result_row['FamilyProfileID'],$result_row['ParentFirstName'], $result_row['ParentLastName'], $result_row['Email'],
        $result_row['Phone1'], $result_row['Phone2'], $result_row['Address'], $result_row['City'],
        $result_row['State'], $result_row['ZipCode'], $result_row['Country'], $result_row['PatientFirstName'],
        $result_row['PatientLastName'], $result_row['PatientRelation'], $result_row['PatientDateOfBirth'],
        $result_row['FormPDF'], $result_row['Notes']);
    
    return $theFamily;
}

/*  Return an array of family profiles  from the FamilyProfile table
 * The first name and last name of the parent is used as the search key
* $fname = parent first name (String)
 * $lname = parent last name (String)
   *@return an array of Family objects
 */
function retrieve_FamilyProfileByName($fname, $lname) 
{
    connect();
    $fname_sent = FALSE;
    $lname_sent = FALSE;
    $new_query = "SELECT * FROM familyprofile WHERE ";
    
    if( ( $fname == "" ) && ( $lname == "" ) )
        return NULL; //two blank search fields is erroneous return a NULL
    
      if( $fname != "" ) 
        $fname_sent = TRUE;
    
    if( $lname != "" ) 
        $lname_sent = TRUE;
        
    if( $fname_sent && $lname_sent ) 
        $new_query .= "ParentFirstName=\"$fname\" AND ParentLastName=\"$lname\"";
    else if( $fname_sent ) //allow a blank last name??
        $new_query .= "ParentFirstName=\"$fname\"";
    else//allow a blank first name
        $new_query .= "ParentLastName=\"$lname\"";
    
    // this can be useful for debugging, but turn it off before you commit!!
    //echo "query is " . $new_query;
    

    $result = mysql_query($new_query) or die(mysql_error());
    
    if (mysql_num_rows($result) <1)
    {
       mysql_close();
        return NULL;
    }
    
    $families = array();
    while ($result_row = mysql_fetch_assoc($result)) {
        $family = new Family($result_row['FamilyProfileID'], $result_row['ParentFirstName'], $result_row['ParentLastName'], $result_row['Email'],
                        $result_row['Phone1'], $result_row['Phone2'], $result_row['Address'], $result_row['City'],
                        $result_row['State'], $result_row['ZipCode'], $result_row['Country'], $result_row['PatientFirstName'],
                        $result_row['PatientLastName'], $result_row['PatientRelation'], $result_row['PatientDateOfBirth'],
                        $result_row['FormPDF'], $result_row['Notes']);


        $families[] = $family;
    }
    mysql_close();
    return $families;
}


/*function getall_family() 
{
    connect();
    $query = "SELECT * FROM FamilyProfile ORDER BY last_name";
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
}*/

/**
 * function that updates a Family Profile based on the FamilyProfileID, ParentFirstName, ParentLastName, Email
 * Phone1, Phone2, Address, City, State, ZipCode, Country, PatientFirstName, PatientLastName, PatientRelation
 * PatientDateOfBirth, FormPDF, and Notes provided. 
 * 
 * @author Linda Shek 
 */

function update_FamilyProfileDetail($familyProfileId, $parentFirstName, $parentLastName, $parentEmail,
            $parentPhone1, $parentPhone2, $parentAddress, $parentCity, $parentState, $parentZIP,
            $parentCountry, $patientFirstName, $patientLastName, $patientRelation,
            $patientDateOfBirth, $patientFormPdf, $patientNotes){
    
    $family = new Family ($familyProfileId, $parentFirstName, $parentLastName, $parentEmail,
            $parentPhone1, $parentPhone2, $parentAddress, $parentCity, $parentState, $parentZIP,
            $parentCountry, $patientFirstName, $patientLastName, $patientRelation,
            $patientDateOfBirth, $patientFormPdf, $patientNotes);
   return update_FamilyProfile($family);
}

/**
 * function to update family profile using class object Family.
 * @return boolean false if no family profile was updated, OR true if family profile was updated. 
 * 
 * @author Linda Shek
 */

function update_FamilyProfile($family) 
{
    if (! $family instanceof Family) {
    echo("Invaild argument for update_FamilyProfile function call");
    return false;
    }
    connect();
    
    $query= "UPDATE familyprofile SET ParentFirstName = '".$family->get_parentfname()."', 
            ParentLastName ='".$family->get_parentlname()."', 
            Email = '".$family->get_parentemail()."',
            Phone1 = '".$family->get_parentphone1()."',
            Phone2 = '".$family->get_parentphone2()."',
            Address = '".$family->get_parentaddress()."',
            City = '".$family->get_parentcity()."',
            State = '".$family->get_parentstate()."',
            ZipCode = '".$family->get_parentzip()."',
            Country = '".$family->get_parentcountry()."',
            PatientFirstName = '".$family->get_patientfname()."', 
            PatientLastName = '".$family->get_patientlname()."', 
            PatientRelation = '".$family->get_patientrelation()."', 
            PatientDateOfBirth = '".$family->get_patientdob()."',
            FormPDF = '".$family->get_patientformpdf()."', 
            Notes = '".$family->get_patientnotes()."'
            WHERE FamilyProfileID = ".$family->get_familyProfileId();
    
    
 $result=mysql_query($query);
   	
    if(!$result) {
		echo mysql_error() . "Error updating FamilyProfile table. <br>";
                mysql_close();
	    return false;
    }
    mysql_close();
    return true;
}

    /*if (! $family instanceof Family) 
        {
            echo ("Invalid argument for update_dbPersons function call");
            return false;
        }
    if (delete_dbFamilyProfile($family->get_familyProfileId()))
        return insert_dbFamilyProfile($family);
    else 
        {
            echo (mysql_error()."unable to update FamilyProfile table: ".$family->get_familyProfileId());
	    return false;
	}*/


/**
 * Deletes a Family Profile from the FamilyProfile table.
 * @param $familyProfileId the id of the FamilyProfile to delete
 */

function delete_FamilyProfile($familyProfileId) 
{
    connect();
    $query="DELETE FROM familyprofile WHERE FamilyProfileID=".$familyProfileId;
	$result=mysql_query($query);
	mysql_close();
	if (!$result) 
        {
            echo (mysql_error()."unable to delete from FamilyProfile: ".$familyProfileId);
            return false;
	}
    return true;
}
    
?>