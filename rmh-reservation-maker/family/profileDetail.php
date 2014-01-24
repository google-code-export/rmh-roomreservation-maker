<?php
/*
 * @current author Bruno Constantino
 * @current author Kristen Gentle
 * 
 * @past author Jessica Cheong
 * @past co-author William Lodise
 * 
 * current authors modidied past authors code
 * 
 * @version December 12, 2012
 *
 *  Family Profile Detail
 * 
 * This page allows SW to search a family profile by First Name or Last Name.
 * If the SW chooses to search by First Name, The family with the name requested is displayed.
 * Like wise happen if the SW choosees so search by Last Name.
 * 
 * two options are given to the SW:
 * 
 * 1. Search First Name.
 * 2. Search Last Name.
  * 
 */

session_start();
session_cache_expire(30);

$title = "Family Profile in Detail"; 
$helpPage = "RoomRequest.php";

include('../header.php'); 
include(ROOT_DIR .'/domain/Family.php');
include(ROOT_DIR . '/database/dbFamilyProfile.php');

$message = array();  // for error messages
//
// if we have come in from the initial search page, with just the first name and last name of the parent
// retrieve the family info from the database
if(isset($_POST['form_token']) && validateTokenField($_POST) && ( isset( $_POST['firstName'] ) || isset( $_POST['lastName'] ) ) )
    {
    
        $fn = ( (isset( $_POST['firstName'] ) )?sanitize( $_POST['firstName']):""); //if firstName isset, sanitize it, else empty string
        if($fn == "First Name" )
            $fn = "";
        $ln = ( (isset( $_POST['lastName'] ) )?sanitize( $_POST['lastName']):"");
        if($ln == "Last Name" )
            $ln = "";
       
        $families = retrieve_FamilyProfileByName($fn, $ln);//calls db receives an array of family objs
        if(!$families)
            $message['emptyFamily'] = "<div style='margin-left:260px; margin-top:30px;'><font color='red'><b>ERROR: Family not found, however, you may <a href='./newProfile.php'>create one.</a></b></font></div>";
        
       // if there were errors preventing the retrival of the family profiles, display them now
         echo '<div id="content" style="margin-left: 300px; margin-top: 23px;">';
        if (!empty($message)) 
        {
        foreach ($message as $messages) 
            {
            echo $messages;
            }
        }
      // since there may be more than one family profile retrieved, display in a table
        // the first name will be clickable, and if the user came in from the create reservation
        // menu option, clicking on it will take the user to a page for creating reservations
        // if the user came in from the search for families option, clicking takes the user
        // to a detail page for the family
        if( is_array( $families ) )
        {
            $table = "\n<table cellpadding='20' style=\"margin-left:250px;\">\n<thead>\n<tr>\n";
            $table .= "<th>Patient Name</th><th>Parent Name</th><th>Parent City</th><th>Patient Date Of Birth</th><th>Patient Notes</th>\n</tr></thead>";
            $numFamilies = 1;
            
       // use the act parameter to determine whether to move on to the new reservation page
        // or the display family profle page
        $act="SEARCH";
        $act = $_GET['act'];
       error_log("action is $act");
       if ($act == "RES")
           $nextScript=BASE_DIR.'/referralForm.php';
       else
        //   $nextScript = BASE_DIR.'/family/DetailedFamilyRecord.php';
       $nextScript = BASE_DIR.'/family/EditFamilyProfile.php';
        foreach( $families as $family )
        {
          
          //create a row with a td for lname, fname, town, dob
           $table .= "<tr>\n\t<td><a style = 'color:blue; font-weight:bold;' href=\"$nextScript?id=";//TODO: DYNAMIC LINK CREATION
           $table .= $family->get_familyProfileId();
           $table .= "\">";
           $table .= $family->get_patientlname();
           $table .= ", ";
           $table .= $family->get_patientfname();
           $table .= "</a></td>";
           $table .= "<td>";
           $table .= $family->get_parentlname() . ", " . $family->get_parentfname();
           $table .= "</td>";
           $table .= "<td>";
           $table .= $family->get_parentcity(); 
           $table .= "</td>";
           $table .= "<td>";
           $table .= $family->get_patientdob(); // TODO : Get rid of birthday time
           $table .= "</td>";
           $table .= "<td>";
           $table .= $family->get_patientnotes();
           $table .= "</td>";
           $table .= "</td>\n</tr>";
       
            
           $numFamilies++;
        }
      
        
        $table .= "</table>";
        echo $table;
        }//end if is_array
    }
    else if(isset($_POST["form_token"]) && !validateTokenField($_POST))
    {
        //if the security validation failed. display/store the error:
        //'The request could not be completed: security check failed!'
        $message['notValid'] = "<div style='margin-left:260px; margin-top:30px;'><font color='red'><b>ERROR: Security check failed, please go back and try again.</b></font></div>";

    }
    else
    {
        //there was no POST DATA  
    }
   
?>
<section class="content">
<div id="container">    
   <?php error_log("in main form for profileDetail"); ?>
   <!--  <div id="content" style="margin-left: 250px; margin-top: 13px;"> -->
  
        </div>
    


    </div>
    
</div>
<?php 
include (ROOT_DIR.'/footer.php');
?>