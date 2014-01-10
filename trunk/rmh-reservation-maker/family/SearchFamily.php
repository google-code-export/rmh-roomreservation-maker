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
* Search Family
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
$helpPage = "SearchingFamilyProfile.php";

include('../header.php');
include(ROOT_DIR .'/domain/Family.php');
include(ROOT_DIR . '/database/dbFamilyProfile.php');


/*if(isset($_POST['form_token']) && validateTokenField($_POST) && ( isset( $_POST['firstName'] ) || isset( $_POST['lastName'] ) ) )
{
	$fn = ( (isset( $_POST['firstName'] ) )?sanitize( $_POST['firstName']):""); //if firstName isset, sanitize it, else empty string
	if($fn == "first name" )
		$fn = "";
	$ln = ( (isset( $_POST['lastName'] ) )?sanitize( $_POST['lastName']):"");
	if($ln == "last name" )
		$ln = "";

	$families = retrieve_FamilyProfileByName($fn, $ln);//calls db receives an array of family objs

	if( is_array( $families ) )
	{
		foreach( $families as $family )
		{
			//create a row with a td for lname, fname, town, dob
			$table .= "<tr>\n\t<td><a href=\"?id=";// DYNAMIC LINK CREATION
			$table .= $family->get_familyProfileId();
			$table .= "\">";
			$table .= $family->get_parentlname();
			$table .= ", ";
			$table .= $family->get_parentfname();
			$table .= "</a></td>";
			$table .= "<td>";
			$table .= $family->get_parentcity();
			$table .= "</td>";
			$table .= "<td>";
			$table .= $family->get_patientdob();
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

}
else
{
	//there was no POST DATA
}

/*if(isset($_GET['id']) )
{   //gets the familyid passed down by the family profile search and when the profile is selected(clicked)
$familyID = sanitize( $_GET['id'] );

$familyProfile = retrieve_FamilyProfile ($familyID);
if($familyProfile){

}
else
{
	$content = "not found";
} 

}//end function  */

if (isset($_GET['act']))
{
    $act = $_GET['act'];
    error_log("action is $act");
    if ($act == "RES")
        $nextScript = '/family/newReservation.php';
    else
        $nextScript = '/family/profileDetail.php';
}
?>
<section class="content">
	<div>
               <?php error_log("in main form for searchFamily"); ?>
                    <?php error_log("The next script is $nextScript"); ?>
		<!--this div should be hidden when search results are displayed-->
		<form class="generic" name="searchForm" method="POST" 
                                                        action="<?php echo BASE_DIR.$nextScript;?>">
			<?php echo generateTokenField(); ?>
			<div class="formRow">
				<label for="firstName">First Name</label>
				<input type="text" name="firstName" id="firstName" />
			</div>
			<div class="formRow">
				<label for="lastName">Last Name</label>
				<input type="text" name="lastName" id="lastName" />
			</div>
			<div class="formRow">
				<input type="submit" class="btn" value="Search" />
			</div>
		</form>
	</div>
	<?php 
	include (ROOT_DIR.'/footer.php');
	?>