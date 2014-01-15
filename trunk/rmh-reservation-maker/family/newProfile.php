<?php
/**
 * @author Jessica Cheong
 * @version May 5, 2012
 *
 * New Family Profile module for RMH-RoomReservationMaker.
 *
 * To make a new family profile, the new family profile form is required to be filled out completely.
 * The form is then saved in another table until the record is validated by the RMH approver.
 * A history of the activity is stored for future references.
 *
 */
//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "New Family Profile"; //This should be the title for the page, included in the <title></title>
$helpPage = "CreatingFamilyProfile.php";

include('../header.php'); //including this will further include (globalFunctions.php and config.php)

include_once(ROOT_DIR . '/domain/UserProfile.php');
include_once(ROOT_DIR . '/domain/ProfileActivity.php');
include_once(ROOT_DIR . '/database/dbProfileActivity.php');
include_once(ROOT_DIR . '/database/dbUserProfile.php');
include_once(ROOT_DIR . '/mail/functions.php');

$message = array();

$taskFinished = FALSE;
if (isset($_POST['form_token']) && validateTokenField($_POST)) {
	$activityType = "Create";
	$profileActitivityStatus = "Unconfirmed";

	//retrieves the sw, and gets id, firstname and lastname
	$currentUser = getUserProfileID();
	$sw = retrieve_UserProfile_SW($currentUser);
	//print_r($sw);
	$swObject = current($sw);
	$sw_id = $swObject->get_swProfileId();
	//$sw_fname = $swObject->get_swFirstName();
	//$sw_lname = $swObject->get_swLastName();
	$dateSubmit = date("Y-m-d");

	if (
		isset($_POST['ParentFirstName']) && $_POST['ParentFirstName'] != "") {
		$parentFirstName = $_POST['ParentFirstName'];
	}
	else {
		$message['ParentFirstName'] = '<p><font color="red">You must enter the Parent First Name.</font></p>';
	}

	if (
		isset($_POST['ParentLastName']) && $_POST['ParentLastName'] != "") {
		$parentLastName = $_POST['ParentLastName'];
	}
	else {
		$message['ParentLastName'] = '<p><font color="red">You must enter the Parent Last Name.</font></p>';
	}

	if (
		isset($_POST['Email']) && $_POST['Email'] != "") {
		$parentEmail = $_POST['Email'];
	}
	else {
		$message['Email'] = '<p><font color="red">You must enter the Email.</font></p>';
	}

	if (
		isset($_POST['Phone1']) && $_POST['Phone1'] != "") {
		$phone1 =$_POST['Phone1'];
	}
	else {
		$message['Phone1'] = '<p><font color="red">You must enter the Parent Primary Phone Number</font></p>';
		
	}

	if (
		isset($_POST['Phone2']) && $_POST['Phone2'] != "") {
		$phone2 = $_POST['Phone2'];
	}
	else {  // phone2 is optional
		$phone2 = "";
	}

	if (
		isset($_POST['Address']) && $_POST['Address'] != "") {
		$address = $_POST['Address'];
	}
	else {
		$message['Address'] = '<p><font color="red">You must enter the Address.</font></p>';
	}

	if (
		isset($_POST['City']) && $_POST['City'] != "") {
		$city = $_POST['City'];
	}
	else {
		$message['City'] = '<p><font color="red">You must enter the City.</font></p>';
	}

	if (
		isset($_POST['State']) && $_POST['State'] != "") {
		$state = $_POST['State'];
	}
	else {
		$message['State'] = '<p><font color="red">You must enter the State.</font><p>';
	}

	if (
		isset($_POST['ZipCode']) && $_POST['ZipCode'] != "") {
		$zip = $_POST['ZipCode'];
	}
	else {
		$message['ZipCode'] = '<p><font color="red">You must enter the Zip Code.</font></p>';
	}

	if (
		isset($_POST['Country']) && $_POST['Country'] != "") {
		$country = $_POST['Country'];
	} else {
		$message['Country'] = '<p><font color="red">You must enter the Country.</font></p>';
	}

	if (
		isset($_POST['PatientFirstName']) && $_POST['PatientFirstName'] != "") {
		$patientFirstName = $_POST['PatientFirstName'];
	}
	else {
		$message['PatientFirstName'] = '<p><font color="red">You must enter the Patient First Name.</font></p>';
	}

	if (
		isset($_POST['PatientLastName']) && $_POST['PatientLastName'] != "") {
		$patientLastName = $_POST['PatientLastName'];
	}
	else {
		$message['PatientLastName'] = '<p><font color="red">You must enter the Patient Last Name.</font><p>';
	}

	if (
		isset($_POST['PatientRelation']) && $_POST['PatientRelation'] != "") {
		$patientRelation = $_POST['PatientRelation'];
	} else {
		$message['PatientRelation'] = '<p><font color="red">You must enter the Patient Relation.</font></p>';
	}

	if (
		isset($_POST['PatientDOB']) && $_POST['PatientDOB'] != "") {
		$patientDateOfBirth = $_POST['PatientDOB'];
	} else {
		$message['PatientDOB'] = '<p><font color="red">You must enter the Patient Date of Birth.</font></p>';
	}

	if (
		isset($_POST['patientFormPDF']) && $_POST['patientFormPDF'] != "") {
		$patientFormPDF = $_POST['patientFormPDF'];
	} else {
		$patientFormPDF = "";  // this field is optional
	}

	if (
		isset($_POST['PatientNote']) && $_POST['PatientNote'] != "") {
		$patientNote = $_POST['PatientNote'];
	} else {
		$patientNote = "";  // this field is optional
	}

	if (
		isset($_POST['swNote']) && $_POST['swNote'] != "") {
		$profileActityNotes = $_POST['swNote'];
	} else {
		$profileActityNotes = "";  // this field is optional
	}
	
                  // there were no input errors in the form, so proceed with database inserts
	if (empty($message)) {
		// the family profile id is 0, but a real one will be generated while doing the insert
		$temporaryFamilyProfile = new Family(
				0,                          //$familyProfileId,
				"Pending",                  //$familyProfileStatus,
				$parentFirstName,
				$parentLastName,
				$parentEmail,
				$phone1,              
				$phone2,
				$address,
				$city,
				$state,
				$zip,
				$country,
				$patientFirstName,
				$patientLastName,
				$patientRelation,
				date($patientDateOfBirth),
				$patientFormPDF,
				$patientNote);

		if(insert_FamilyProfile($temporaryFamilyProfile))
		
		//Get generated familyProfileID from the familyProfile object.
		$results = retrieve_FamilyProfileByName($temporaryFamilyProfile->get_parentfname(), $temporaryFamilyProfile->get_parentlname());
		$resultsFamily = $results[0];
		$temporaryFamilyProfileID = $resultsFamily->get_familyProfileId();


		//create profile activity object
		$current_activity = new ProfileActivity(
				0,                          //$profileActivityId
				0,                          //$profileActivityRequestId
				$temporaryFamilyProfileID,    //$familyProfileId
				//requestID set to 0 as placeholders.
				//TODO: change this!
				$sw_id,                     
				//$sw_lname,                  
				//$sw_fname,                  
				'NULL',                          //$rmhStaffProfileId
			//	"",                         //$rmhStaffLastName
			//	"",                         //$rmhStaffFirstName
				$dateSubmit,                //$swDateStatusSubm
				'NULL',                          //$rmhDateStatusSubm
				$activityType,              
				$profileActitivityStatus,   
				$parentFirstName,           
				$parentLastName,            
				$parentEmail,               
				$phone1,                    
				$phone2,                    
				$address,                   
				$city,                      
				$state,                     
				$zip,                       
				$country,                   
				$patientFirstName,          
				$patientLastName,           
				$patientRelation,           
				$patientDateOfBirth,        
				$patientFormPDF,            
				$patientNote,               
				$profileActityNotes         
		);

	
		// check if insert function returns true, then insert profileactivity
		if (insert_ProfileActivity($current_activity)) {
                                                         $taskFinished = TRUE;
			

			//            //if profileActivity is inserted, send the email to rmh approver
			//            $profileID = $current_activity->get_profileActivityId();
			//            NewFamilyProfile($profileID);

		
		}
	}
}//end of success validation of tokens
else if (isset($_POST['form_token']) && !validateTokenField($_POST)) {
	//if the security validation failed. display/store the error
	//'The request could not be completed security check failed!'
	echo "The request could not be completed.";
}
?>
<section class="content">
<?php //ErrorHandler::displayErrors();?>
	<div>
	<h2>New Family Profile</h2>
	<div>
				<?php
			
				if (!empty($message)) {
   					 echo "Cannot create New Profile: " . "</br>";
   					 foreach ($message as $messages) {
        					echo $messages;
   				 			}
					}
                                                                           if ($taskFinished) {
                                                                                  echo '<p>Temporary family profile inserted successfully.</p>';
                                                                                  echo '<p>Successfully inserted a profile activity request.</p>';
                                                                                  echo '<p> These records will be finalized upon RMH approval</p>';
                                                                                   echo '<p> If you want to create a reservation for this family, go back to the Family Profile page </p>';
                                                                           }
?>
	</div>
		<form class="generic" name="newProfileForm" method="post" action="newProfile.php">
			<?php echo generateTokenField(); ?>
		
			<div class="formRow">
				<label for="ParentFirstName">Parent First Name</label>
				<input id="ParentFirstName" type="text" name="ParentFirstName"
					<?php isset($parentFirstName) ? print ("value=\"$parentFirstName\"") : print("");?> />
			</div>
			<div class="formRow">
				<label for="ParentLastName">Parent Last Name</label>
				<input type="text" id="ParentLastName" name="ParentLastName"
					<?php isset($parentLastName) ? print ("value=\"$parentLastName\"") : print("");?> />
			</div>
			<div class="formRow">
				<label for="Email">Parent Email Address</label>
				<input type="email" name="Email" id="Email"
					<?php isset($parentEmail) ? print ("value=\"$parentEmail\"") : print("");?> />
			</div>
			<div class="formRow">
				<label for="Phone1">Parent's Primary Phone</label>
				<input type="tel" name="Phone1" id="Phone1"
					<?php isset($phone1) ? print ("value=\"$phone1\"") : print("");?> />
			</div>
			<div class="formRow">
				<label for="Phone2">Parent's Secondary Phone</label>
				<input type="tel" name="Phone2" id="Phone2"
					<?php isset($phone2) ? print ("value=\"$phone2\"") : print("");?> />
			</div>
			<div class="formRow">	
				<label for="Address">Street Address</label>
				<input type="text" name="Address" id="Address"
					<?php isset($address) ? print ("value=\"$address\"") : print("");?> />
			</div>
			<div class="formRow">
				<label for="City">City</label>
				<input type="text" name="City" id="City"
					<?php isset($city) ? print ("value=\"$city\"") : print("");?> /> 
			</div>
			<div class="formRow">	
				<label for="State">State</label>
				<input type="text" name="State" id="State"
					<?php isset($state) ? print ("value=\"$state\"") : print("");?> />
			</div>
			<div class="formRow">
				<label for="ZipCode">Zip Code</label>
				<input type="number" name="ZipCode" id="ZipCode"
					<?php isset($zip) ? print ("value=\"$zip\"") : print("");?> /> 
			</div>
			<div class="formRow">
				<label for="Country">Country</label>	
				<input type="text" name="Country" id="Country"
					<?php isset($country) ? print ("value=\"$country\"") : print("");?> />
			</div>
			<div class="formRow">
				<label for="PatientFirstName">Patient's First Name</label>
				<input type="text" name="PatientFirstName" id = "PatientFirstName"
					<?php isset($patientFirstName) ? print ("value=\"$patientFirstName\"") : print("");?> />
			</div>
			<div class="formRow">
				<label for="PatientLastName">Patient's Last Name</label>
				<input type="text" name="PatientLastName" id = "PatientLastName"
					<?php isset($patientLastName) ? print ("value=\"$patientLastName\"") : print("");?> />
			</div>
			<div class="formRow">
				<label for="PatientRelation">Patient's Relationship Toward Parent</label>
				<input type="text" name="PatientRelation" id="PatientRelation"
					<?php isset($patientRelation) ? print ("value=\"$patientRelation\"") : print("");?> />
			</div>
			<div class="formRow">
				<label for="PatientDOB">Patient's Date of Birth</label>
				<input type="date" name="PatientDOB" id="PatientDOB"
					<?php isset($patientDateOfBirth) ? print ("value=\"$patientDateOfBirth\"") : print("");?> />
			</div>
			<div class="formRow">	
				<label for="PatientFormPDF">Patient Form PDF</label>
				<input type="text" name="patientFormPDF" id="PatientFormPDF"
					<?php isset($patientFormPDF) ? print ("value=\"$patientFormPDF\"") : print("");?> />
			</div>
			<div class="formRow">
				<label for="PatientNote">Notes on Patient</label>
				<!-- Should be text area? Make sure database has this type  -->
				<input type="text" name="PatientNote" id="PatientNote"
					<?php isset($patientNote) ? print ("value=\"$patientNote\"") : print("");?> />
			</div>
			<div class="formRow">
				<label for="swNote">Anything you would like to note?</label>	
				<!-- Should be textarea. Make sure database has this type -->			
				<input type="text" name="swNote" id="swNote"
					<?php isset($profileActityNotes) ? print ("value=\"$profileActityNotes\"") : print("");?> />
			</div>
                    <?php if ($taskFinished == FALSE)
			echo '<div class="formRow"><input class="btn" type="submit" name="submit" value="Create" />';
		?>	
                        </div>
		</form>
	</div>
</section>
	<?php
	include (ROOT_DIR . '/footer.php');
	//include the footer file, this contains the proper </body> and </html> ending tag.
	?>