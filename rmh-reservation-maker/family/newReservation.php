<?php
// this script is DEPRECATED
session_start();
session_cache_expire(30);

$title = "Create a Reservation";
$helpPage = "SearchingFamilyProfile.php";

include('../header.php');
include(ROOT_DIR .'/domain/Family.php');
include(ROOT_DIR . '/database/dbFamilyProfile.php');


if(isset($_POST['form_token']) && validateTokenField($_POST) && ( isset( $_POST['firstName'] ) || isset( $_POST['lastName'] ) ) )
{

        $fn = ( (isset( $_POST['firstName'] ) )?sanitize( $_POST['firstName']):""); //if firstName isset, sanitize it, else empty string
        if($fn == "First Name" )
            $fn = "";
        $ln = ( (isset( $_POST['lastName'] ) )?sanitize( $_POST['lastName']):"");
        if($ln == "Last Name" )
            $ln = "";
       
        $families = retrieve_FamilyProfileByName($fn, $ln);//calls db receives an array of family objs
        if($families)
            echo "";
        else
            echo("<div style='margin-left:260px; margin-top:30px;'><font color='red'><b>ERROR: Family not found, however, you may <a href='./newProfile.php'>create one.</a></b></font></div>"); //DON'T DIE!! Messes up the layout!!
        
      
         
        
        if( is_array( $families ) )
        {
        //TODO: start table with tags
            $table = "\n<table cellpadding='20' style=\"margin-left:250px;\">\n<thead>\n<tr>\n";
            $table .= "<th>Patient Name</th><th>Parent Name</th><th>Parent City</th><th>Patient Date Of Birth</th><th>Patient Notes</th>\n</tr></thead>";
            $numFamilies = 1;
            //create an array, 
        foreach( $families as $family )
        {
          $nextScript = BASE_DIR."/referralForm.php?id=".$family->get_familyProfileId();
          error_log("in new Reservation, nextScript is $nextScript");
          //create a row with a td for lname, fname, town, dob
           $table .= "<tr>\n\t<td><a style = 'color:blue; font-weight:bold;' href=\"$nextScript";//TODO: DYNAMIC LINK CREATION
    //       $table .= $family->get_familyProfileId();
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
            // TODO : put familyProfileId into the elements of the array created above
            //var_dump($family);
            
           $numFamilies++;
        }
      
        
        $table .= "</table>";
        echo "Please click on the patient name to create a reservation for that patient";
        echo $table;
        }//end if is_array
}
else if(isset($_POST["form_token"]) && !validateTokenField($_POST))
{
	//if the security validation failed. display/store the error:
	//'The request could not be completed: security check failed!'

}
else
{
	//there was no POST DATA
}

if(isset($_GET['id']) )
{   //gets the familyid passed down by the family profile search and when the profile is selected(clicked)
$familyID = sanitize( $_GET['id'] );

$familyProfile = retrieve_FamilyProfile ($familyID);
if($familyProfile){
     makeReservation($familyProfile);
}
else
{
	$content = "not found";
}

}

function makeReservation($familyProfile)
{
error_log("in make reservation");

} //end makeReservation
?>

	<?php 
	include (ROOT_DIR.'/footer.php');
	?>
?>

