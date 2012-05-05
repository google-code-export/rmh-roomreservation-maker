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
        
        if(isset($_POST['ParentFirstName'])&& $_POST['ParentFirstName'] != "Parent First Name" && $_POST['ParentFirstName'] != ""){
            $parentfname = sanitize($_POST['ParentFirstName']);
        }
        else{
            $message['ParentFirstName'] = "Must enter Parent First Name.";

        }
        if(isset($_POST['ParentLastName']) && $_POST['ParentLastName'] != "Parent Last Name" && $_POST['ParentLastName'] != ""){
            $parentlname = sanitize($_POST['ParentLastName']);
        }
        else{
            $message['ParentLastName'] = "Must enter Parent Last Name.";
            // print_r($message);
        }
        if(isset($_POST['Email'])&& $_POST['Email'] != "E-Mail" && $_POST['Email'] != "" ){
            $parentemail = sanitize($_POST['Email']);
          }
        else{
            $message['Email'] = "Must enter Email.";
        }
        if(isset($_POST['Phone1'])&& $_POST['Phone1'] != "Phone # 1" && $_POST['Phone1'] != ""){
            $parentphone1 = sanitize ($_POST['Phone1']);
        }
        else{
            $message['Phone1'] = "Must enter Phone1";
             //print_r($message);
        }    
        if(isset($_POST['Phone2']) && $_POST['Phone2'] != "Phone # 2" && $_POST['Phone2'] != ""){
             $parentphone2 = sanitize($_POST['Phone2']);
        }
        else{
             $parentphone2 = "";
        }
        if(isset($_POST['Address'])&& $_POST['Address'] != "Address" && $_POST['Address'] != ""){
            $parentAddr = sanitize($_POST['Address']);
        }
        else{
            $message['Address'] = "Must enter Address";
        }
        if(isset($_POST['City'])&& $_POST['City'] != "City" && $_POST['City'] != "" ){
             $parentcity = sanitize($_POST['City']);
        }
        else{
            $message['City'] = "Must enter City";
        }
         if(isset($_POST['State'])&& $_POST['State'] != "State" && $_POST['State'] != ""){
            $parentstate = sanitize($_POST['State']);
        }
        else{
            $message['State'] = "Must enter State";
        }
         if(isset($_POST['ZipCode'])&& $_POST['ZipCode'] != "Zip Code" && $_POST['ZipCode'] != ""){
             $parentzip = sanitize($_POST['ZipCode']);
        }
        else{
            $message['ZipCode'] = "Must enter Zip Code";
        }
        if(isset($_POST['Country'])&& $_POST['Country'] != "Country" && $_POST['Country'] != ""){
             $parentcountry = sanitize($_POST['Country']);
        }
        else{
            $message['Country'] = "Must enter Country";
        }
         if(isset($_POST['PatientFirstName'])&& $_POST['PatientFirstName'] != "Patient First Name" && $_POST['PatientFirstName'] != ""){
             $patientfname = sanitize($_POST['PatientFirstName']);
        }
        else{
             $message['PatientFirstName'] = "Must enter Patient First Name.";
        }
        if(isset($_POST['PatientLastName'])&& $_POST['PatientLastName'] != "Patient Last Name" && $_POST['PatientLastName'] != ""){
             $patientlname = sanitize($_POST['PatientLastName']);
        }
        else{
            $message['PatientLastName'] = "Must enter Patient Last Name";
        }
        if(isset($_POST['PatientRelation'])&& $_POST['PatientRelation'] != "Patient Relation" && $_POST['PatientRelation'] != ""){
            $patientrelation = sanitize($_POST['PatientRelation']);
        }
        else{
            $message['PatientRelation'] = " Must enter Patient Relation.";
        }
        if(isset($_POST['PatientDOB'])&& $_POST['PatientDOB'] != "Patient Date Of Birth" && $_POST['PatientDOB'] != "" ){
             $patientdob = sanitize($_POST['PatientDOB']);
        }
        else{
            $message['PatientDOB'] = "Must enter Patient Date of Birth.";
        }
        if(isset($_POST['PatientDiagnosis']) && $_POST['PatientDiagnosis'] != "Patient Diagnosis" && $_POST['PatientDiagnosis'] != ""){
             $patientformpdf = sanitize($_POST['PatientDiagnosis']);
        }
        else{
            $patientformpdf = "";
        }
        if(isset($_POST['PatientNote'])&& $_POST['PatientNote'] != "Patient's Notes" && $_POST['PatientNote'] != ""){
            $patientnotes = sanitize($_POST['PatientNote']);
        }
        else{
           $patientnotes = "";
        }
        if(isset($_POST['swNote']) && $_POST['swNote'] != "Notes from Social Worker" && $_POST['swNote'] != ""){
            $profileActityNotes = sanitize($_POST['swNote']);
        }
        else{
             $profileActityNotes = "";
        }
//                      print_r($message);
//                      var_dump($message);                               
        
        if(!empty($message)){
//            echo "Cannot create New Profile" . "<br/>";
//            
//            foreach ($message as $messages){
//                echo $messages . "<br/>";               
//            }
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
               
                 //Need to pass the familyID to room reservation script 
                 echo '<a href="'.BASE_DIR.'/referralForm.php">Create Room Reservation</a>' . "\n";
        }       
        }
        
    }//end of success validation of tokens
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        //if the security validation failed. display/store the error
        //'The request could not be completed security check failed!'
        echo "The request could not be completed.";
    }
   
?>

<div id="container">

    <div id="content">
        
       <form name ="newProfileForm" method="post" action="newProfile.php">
            <?php echo generateTokenField(); ?>
         
        <div>                         
        <th colspan="2"> <h2> New Family Profile Form </h2></th>
        </div>
        
            <div>
                <?php 
                if (!empty($message)){
                    echo "Cannot create New Profile: ". "</br>";
                foreach ($message as $messages){
                echo $messages . "<br/>";               
                }
                }
                ?>
            </div>
           
            <div>
         <input class="formtop formt" type="text" name="ParentFirstName" onfocus="if(this.value == 'Parent First Name') { this.value = ''; }"  value="Parent First Name" size="40" /></div>
        <div>

         <input class="formt" type="text" name="ParentLastName" onfocus="if(this.value == 'Parent Last Name') { this.value = ''; }"  value="Parent Last Name" size="40" /></div>
        <div>

         <input class="formt" type="text" name="Email" onfocus="if(this.value == 'E-Mail') { this.value = ''; }"  value="E-Mail" size="40" /><br></div>
        <div>

         <input class="formt" type="text" name="Phone1" onfocus="if(this.value == 'Phone # 1') { this.value = ''; }"  value="Phone # 1" size="40" /><br></div>
        <div>

         <input class="formt" type="text" name="Phone2" onfocus="if(this.value == 'Phone # 2') { this.value = ''; }"  value="Phone # 2" size="40" /><br></div>
        <div>

         <input class="formt" type="text" name="Address" onfocus="if(this.value == 'Address') { this.value = ''; }"  value="Address" size="40" /><br></div>
        <div>

         <input class="formt" type="text" name="City" onfocus="if(this.value == 'City') { this.value = ''; }"  value="City" size="40" /><br></div>
        <div>

         <input class="formt" type="text" name="State" onfocus="if(this.value == 'State') { this.value = ''; }"  value="State" size="40" /><br> </div>
        <div>

         <input class="formt"  type="text" name="ZipCode" onfocus="if(this.value == 'Zip Code') { this.value = ''; }"  value="Zip Code" size="40" /><br></div>

         <input class="formt" type="text" name="Country" onfocus="if(this.value == 'Country') { this.value = ''; }"  value="Country" size="40" /><br>
        
         <input class="formt" type="text" name="PatientFirstName" onfocus="if(this.value == 'Patient First Nane') { this.value = ''; }"  value="Patient First Name" size="40" />
   
    
         <input class="formt" type="text" name="PatientLastName" onfocus="if(this.value == 'Patient Last Name') { this.value = ''; }"  value="Patient Last Name" size="40" />

  
         <input class="formt"  type="text" name="PatientRelation" onfocus="if(this.value == 'Patient Relation') { this.value = ''; }"  value="Patient Relation" size="40" />
   
        
         <input class="formt" type="text" name="PatientDOB" onfocus="if(this.value == 'Patient Date Of Birth') { this.value = ''; }"  value="Patient Date Of Birth" size="40" />
    
         
         <input class="formt" type="text" name="PatientDiagnosis" onfocus="if(this.value == 'Patient Diagnosis') { this.value = ''; }" value="Patient Diagnosis"  size="40" />
         <input class="formt" type="text" name="PatientNote" onfocus="if(this.value == 'Patient\'s Notes') { this.value = ''; }"  value="Patient's Notes" size="40" />
         <input class="formt formbottom" type="text" name="swNote" onfocus="if(this.value == 'Notes from Social Worker') { this.value = ''; }" value="Notes from Social Worker"  size="40"/></div>
        <div>                        
              <input class="formsubmit"type="submit" name="submit" value="Create New Profile"/></div>
            
       </form>

    </div>
</div>

<?php 
include (ROOT_DIR .'/footer.php');
//include the footer file, this contains the proper </body> and </html> ending tag.
?>

