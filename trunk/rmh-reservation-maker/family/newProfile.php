<?php

 /*
  * @author Jessica Cheong
  * 
  * New family profile form
  * SW will complete the new family profile form
  * the form is then saved in the profile activity table until the record is validated by the RMH approver. 
  */
    
//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "New Family Profile"; //This should be the title for the page, included in the <title></title>

include('../header.php'); //including this will further include (globalFunctions.php and config.php)

include_once(ROOT_DIR .'/domain/UserProfile.php');
include_once(ROOT_DIR .'/domain/ProfileActivity.php');
include_once(ROOT_DIR .'/database/dbProfileActivity.php');
include_once(ROOT_DIR .'/database/dbUserProfile.php');
include_once(ROOT_DIR .'/mail/functions.php');

   $message = array();

    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        $activityType = "Create";
        $profileActitivityStatus = "Unconfirmed";

        //retrieves the sw, and gets id, firstname and lastname      
        $currentUser = getUserProfileID();
        $sw = retrieve_UserProfile_SW($currentUser);
        //print_r($sw);
        $swObject = current($sw);
        $sw_id = $swObject->get_userProfileId();
        $sw_fname = $swObject->get_swFirstName();
        $sw_lname = $swObject->get_swLastName();
        $dateSubmit = date("Y-m-d");
        
        if(isset($_POST['ParentFirstName'])&& $_POST['ParentFirstName'] != ""){
            $parentfname = sanitize($_POST['ParentFirstName']);
        }
        else{
            $message['ParentFirstName'] = "Must enter Parent First Name.";

        }
        if(isset($_POST['ParentLastName']) && $_POST['ParentLastName'] != ""){
            $parentlname = sanitize($_POST['ParentLastName']);
        }
        else{
            $message['ParentLastName'] = "Must enter Parent Last Name.";
            // print_r($message);
        }
        if(isset($_POST['Email'])&& $_POST['Email'] != ""){
            $parentemail = sanitize($_POST['Email']);
          }
        else{
            $message['Email'] = "Must enter Email.";
        }
        if(isset($_POST['Phone1'])&& $_POST['Phone1'] != ""){
            $parentphone1 = sanitize ($_POST['Phone1']);
        }
        else{
            $message['Phone1'] = "Must enter Phone1";
             //print_r($message);
        }    
        if(isset($_POST['Phone2'])){
             $parentphone2 = sanitize($_POST['Phone2']);
        }
        else{
             $parentphone2 = "";
        }
        if(isset($_POST['Address'])&& $_POST['Address'] != ""){
            $parentAddr = sanitize($_POST['Address']);
        }
        else{
            $message['Address'] = "Must enter Address";
        }
        if(isset($_POST['City'])&& $_POST['City'] != ""){
             $parentcity = sanitize($_POST['City']);
        }
        else{
            $message['City'] = "Must enter City";
        }
         if(isset($_POST['State'])&& $_POST['State'] != ""){
            $parentstate = sanitize($_POST['State']);
        }
        else{
            $message['State'] = "Must enter State";
        }
         if(isset($_POST['ZipCode'])&& $_POST['ZipCode'] != ""){
             $parentzip = sanitize($_POST['ZipCode']);
        }
        else{
            $message['ZipCode'] = "Must enter Zip Code";
        }
        if(isset($_POST['Country'])&& $_POST['Country'] != ""){
             $parentcountry = sanitize($_POST['Country']);
        }
        else{
            $message['Country'] = "Must enter Country";
        }
         if(isset($_POST['PatientFirstName'])&& $_POST['PatientFirstName'] != ""){
             $patientfname = sanitize($_POST['PatientFirstName']);
        }
        else{
             $message['PatientFirstName'] = "Must enter Patient First Name.";
        }
        if(isset($_POST['PatientLastName'])&& $_POST['PatientLastName'] != ""){
             $patientlname = sanitize($_POST['PatientLastName']);
        }
        else{
            $message['PatientLastName'] = "Must enter Patient Last Name";
        }
        if(isset($_POST['PatientRelation'])&& $_POST['PatientRelation'] != ""){
            $patientrelation = sanitize($_POST['PatientRelation']);
        }
        else{
            $message['PatientRelation'] = " Must enter Patient Relation.";
        }
        if(isset($_POST['PatientDOB'])&& $_POST['PatientDOB'] != ""){
             $patientdob = sanitize($_POST['PatientDOB']);
        }
        else{
            $message['PatientDOB'] = "Must enter Patient Date of Birth.";
        }
        if(isset($_POST['PatientDiagnosis'])){
             $patientformpdf = sanitize($_POST['PatientDiagnosis']);
        }
        else{
            $patientformpdf = "";
        }
        if(isset($_POST['PatientNote'])){
            $patientnotes = sanitize($_POST['PatientNote']);
        }
        else{
           $patientnotes = "";
        }
        if(isset($_POST['swNote'])){
            $profileActityNotes = sanitize($_POST['swNote']);
        }
        else{
             $profileActityNotes = "";
        }
//                      print_r($message);
//                      var_dump($message);                               
        
        if(!empty($message)){
            echo "unsuccessful" . "<br/>";
            
            foreach ($message as $messages){
                echo $messages . "<br/>";               
            }
       }
        
        else if (empty($message)){
            //no error messages
            //create profile activity object
            $current_activity = new ProfileActivity(0, 0, 0, $sw_id, $sw_lname, $sw_fname, //familyID and requestID set to 0 as placeholders. 
            0, "", "", $dateSubmit, 0, $activityType, $profileActitivityStatus,             
            $parentfname, $parentlname, $parentemail, $parentphone1, $parentphone2,        
            $parentAddr, $parentcity, $parentstate, $parentzip, 
            $parentcountry, $patientfname, $patientlname, $patientrelation, 
            $patientdob, $patientformpdf, $patientnotes, $profileActityNotes);
             
//            print_r($message);
//            var_dump($message);
          
            // check if insert function returns true, then insert profileactivity                     
            if(insert_ProfileActivity($current_activity)){
                 echo "Successfully inserted a profile activity request" . "<br/>";
                 
                 //if profileActivity is inserted, send the email to rmh approver
                 $profileID = $current_activity->get_profileActivityId();
                 NewFamilyProfile($profileID);
               
                 //I should pass the familyID to room reservation script 
                 echo '<a href="'.BASE_DIR.'/referralForm.php">Create Room Reservation</a>' . "\n";
        }       
        }
        
    }//end of success validation of tokens
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        //if the security validation failed. display/store the error:
        //'The request could not be completed: security check failed!'
        echo "The request could not be completed.";
    }
   
?>

<div id="container">

    <div id="content">
        
       <form name ="newProfileForm" method="post" action="newProfile.php">
            <?php echo generateTokenField(); ?>
           
        <table border = "0" cellspacing = "8" cellpadding = "5" style="width:500px; margin-bottom: 40px;">
        <thead>
        <tr>                         
        <th colspan="2"> <h2> New Family Profile Form </h2></th>
        </tr>
        <tr>
        <td>Parent First Name: </td> 
        <td><input type="text" name="ParentFirstName" value="" size="40" /></td></tr>
        <tr>
        <td>Parent Last Name:</td>
        <td><input type="text" name="ParentLastName" value="" size="40" /></td></tr>
        <tr>
        <td>Email:</td>
        <td><input type="text" name="Email" value="" size="40" /><br></td></tr>
        <tr>
        <td>Phone1:</td>
        <td><input type="text" name="Phone1" value="" size="40" /><br></td></tr>
        <tr>
        <td>Phone2:</td>
        <td><input type="text" name="Phone2" value="" size="40" /><br></td></tr>
        <tr>
        <td>Address:</td>
        <td><input type="text" name="Address" value="" size="40" /><br></td></tr>
        <tr>
        <td>City:</td>
        <td><input type="text" name="City" value="" size="40" /><br></td></tr>
        <tr>
        <td>State:</td>
        <td><input type="text" name="State" value="" size="40" /><br> </td></tr>
        <tr>
        <td>Zip Code:</td>
        <td><input type="text" name="ZipCode" value="" size="40" /><br></td></tr>
        <td>Country:</td>
        <td><input type="text" name="Country" value="" size="40" /><br></td></tr>
        <tr>
        <td>Patient First Name: </td>
        <td><input type="text" name="PatientFirstName" value="" size="40" /><br></td></tr>
        <tr>
        <td>Patient Last Name: </td>
        <td><input type="text" name="PatientLastName" value="" size="40" /><br></td></tr>
        <tr>
        <td>Patient Relation:  </td>
        <td><input type="text" name="PatientRelation" value="" size="40" /><br></td></tr>
        <tr>
        <td>Patient Date Of Birth:</td>
        <td><input type="text" name="PatientDOB" value="" size="40" /><br></td></tr>
        <tr>
        <td>Patient Diagnosis: </td>
        <td><input type="text" name="PatientDiagnosis" value="" size="40" /><br></td></tr>
        <tr>
        <td>Patient's Notes: </td>
        <td><input type="text" name="PatientNote" value="" size="40" /><br></td></tr>
        <tr>
        <td>Notes from Social Worker: </td>
        <td><input type="text" name="swNote" value="" size="40"/></td></tr>
        <tr>                        
            <td></td><td><input type="submit" name="submit" value="Modify"/></td></tr>
            
           </thead>
           </table>
       </form>

    </div>
</div>

<?php 
include (ROOT_DIR .'/footer.php');
//include the footer file, this contains the proper </body> and </html> ending tag.
?>

