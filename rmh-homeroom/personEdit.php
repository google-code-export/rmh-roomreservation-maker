<?PHP
/*
 * Copyright 2008 by Oliver Radwan, Maxwell Palmer, Nolan McNair,
 * Taylor Talmage, and Allen Tucker.  This program is part of RMH Homebase.
 * RMH Homebase is free software.  It comes with absolutely no warranty.
 * You can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
*/
/*
 *	personEdit.php
 *  oversees the editing of a person to be added, changed, or deleted from the database
 *	@author Oliver Radwan and Allen Tucker
 *	@version 9/1/2008
 */
	session_start();
	session_cache_expire(30);
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    include_once('database/dbBookings.php');
    include_once('database/dbLog.php');
	$id = $_GET["id"];
	if ($id=='new') {
	 	     $person = new Person('new','person',null,null,null,null,null,null,null,null,null,'new',null,null,md5('new'));
	}
	else {
		$person = retrieve_dbPersons($id);
		if (!person) {
             echo('<p id="error">Error: there\'s no person with this id in the database</p>'. $id);
		     die();
        }
	}
?>
<html>
	<head>
		<title>
			Editing <?PHP echo($person->get_first_name()." ".$person->get_last_name());?>
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
<body>
  <div id="container">
    <?PHP include('header.php');?>
	<div id="content">
<?PHP
	include('personValidate.inc');
	if($_POST['_form_submit']!=1)
	//in this case, the form has not been submitted, so show it
		include('personForm.inc');
	else {
	//in this case, the form has been submitted, so validate it
		$errors = validate_form(); 	//step one is validation.
									// errors array lists problems on the form submitted
		if ($errors) {
		// display the errors and the form to fix
			show_errors($errors);
		}
		// this was a successful form submission; update the database and exit
		else{
			$newperson = process_form($id,$person);
			if ($_POST['deleteMe']!="DELETE" && $_POST['reset_pass']!="RESET")
			   echo('Update successful.  Click <a href=personEdit.php?id='.$newperson->get_id().'> edit</a> to review your changes.');
		}
		include('footer.inc');
		echo('</div></div></body></html>');
		die();
	}
	include('footer.inc');

/**
* process_form sanitizes data, concatenates needed data, and enters it all into the database
*/
function process_form($id,$person)	{	
     // Get the info of the user who is making the update
	 $user = retrieve_dbPersons($_SESSION['_id']);
	 $name = $user->get_first_name()." ".$user->get_last_name();
	 
	    $first_name = trim(str_replace("'","\'", htmlentities(str_replace('&','and',$_POST['first_name']))));
		$last_name = trim(str_replace("'","\'", htmlentities($_POST['last_name'])));
		$address = trim(str_replace("'","\'", htmlentities($_POST['address'])));
		$city = trim(str_replace("'","\'", htmlentities($_POST['city'])));
		$state = $_POST['state'];
		$zip = trim(htmlentities($_POST['zip']));
		$phone1 = trim(str_replace(' ','',htmlentities($_POST['phone1'])));
		$clean_phone1 = ereg_replace("[^0-9]", "", $phone1);
		$phone2 = trim(str_replace(' ','',htmlentities($_POST['phone2'])));
		$clean_phone2 = ereg_replace("[^0-9]", "", $phone2);
		$email = trim(str_replace("'","\'", htmlentities($_POST['email'])));
        $patient_name = trim(str_replace("'","\'", htmlentities($_POST['patient_name'])));
	    $patient_birthdate = $_POST['DateOfBirth_Year'].'-'.$_POST['DateOfBirth_Month'].'-'.$_POST['DateOfBirth_Day'];
        $patient_relation = trim(str_replace('\\\'','\'',htmlentities($_POST['patient_relation'])));
      
        $type = implode(',',$_POST['type']);
        $prior_bookings = implode(',',$person->get_prior_bookings());
		$newperson = new Person($last_name, $first_name, $address, $city, $state, $zip, $clean_phone1, $clean_phone2, 
                                   $email, $type, $prior_bookings, $patient_name, $patient_birthdate,$patient_relation,"");   
        if(!retrieve_dbPersons($newperson->get_id())){
           insert_dbPersons($newperson);
           return $newperson;
        }
        else if($_POST['deleteMe']!="DELETE" && $_POST['reset_pass']!="RESET"){
         	update_dbPersons($newperson);
         	return $newperson;
        }
        
	//step two: try to make the deletion or password change
		if($_POST['deleteMe']=="DELETE"){
			$result = retrieve_dbPersons($id);
			if (!$result)
				echo('<p>Unable to delete. ' .$first_name.' '.$last_name. ' is not in the database. <br>Please report this error to the House Manager.');
			else {
				//What if they're the last remaining manager account?
				if(strpos($type,'manager')!==false){
				//They're a manager, we need to check that they can be deleted
					$managers = getall_type('manager');
					if (!$managers || mysql_num_rows($managers) <= 1)
						echo('<p class="error">You cannot remove the last remaining manager from the database.</p>');
					else {
						$result = delete_dbPersons($id);
						echo("<p>You have successfully removed " .$first_name." ".$last_name. " from the database.</p>");
						if($id==$_SESSION['_id']){
							session_unset();
							session_destroy();
						}
					}
				}
				else {
					$result = delete_dbPersons($id);
					echo("<p>You have successfully removed " .$first_name." ".$last_name. " from the database.</p>");
					if($id==$_SESSION['_id']){
						session_unset();
						session_destroy();
					}
				}
				// Create the log message
				$message = "<a href='viewPerson.php?id=".$_SESSION['_id']."'>".$name."</a>".
				" has removed ".$first_name." ".$last_name." from the database";
				add_log_entry($message);
			}
			return $person;
		}
		// try to reset the person's password
		else if($_POST['reset_pass']=="RESET"){
			$id = $_POST['old_id'];
			// $result = delete_dbPersons($id);
			// $pass = $first_name . $phone1;
            $person = new Person($last_name, $first_name, $address, $city, $state, $zip, $clean_phone1, $clean_phone2, 
                               $email, $type, implode(',',$person->get_prior_bookings()), $patient_name, $patient_birthdate,$patient_relation,"");
            $result = insert_dbPersons($person);
			if (!$result)
            	echo ('<p class="error">Unable to reset ' .$first_name.' '.$last_name. "'s password.. <br>Please report this error to the House Manager.");
			else {
				echo("<p>You have successfully reset " .$first_name." ".$last_name. "'s password.</p>");
				// Create the log message
				$message = "<a href='viewPerson.php?id=".$_SESSION['_id']."'>".$name."</a>".
				" has reset the password for <a href='viewPerson.php?id=".$id."'>".
				$first_name." ".$last_name."</a>";
				add_log_entry($message);
			}
			return $person;
		}
}
?>
    </div>
  </div>
</body>
</html>
