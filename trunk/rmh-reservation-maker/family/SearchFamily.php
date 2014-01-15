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

// this is done because $act is set to the orginating action - is the user trying to
// make a reservation or just look at a family profile record?
// the value will be passed to the next script as well
if (isset($_GET['act']))
{
    $act = $_GET['act'];
    error_log("action is $act");
      $nextScript = "/family/profileDetail.php?act=$act";
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