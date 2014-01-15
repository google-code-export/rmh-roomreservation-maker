<?php
/*
*Copyright 2012 by Gregorie Sylvester and Bonnie MacKellar .
* This program is part of RMH-RoomReservationMaker, which is free software,
* inspired by the RMH Homeroom Project.
* It comes with absolutely no warranty.  You can redistribute and/or
* modify it under the terms of the GNU Public License as published
* by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
 
/*
* Referral From module for RMH-RoomReservationMaker. 
* Displays a form for the user to enter data to make a new reservation
* @author Gregorie Sylvester
* @version May 02, 2012
*/
session_start();
session_cache_expire(30);

$title = "Referral Form";

include ('header.php');
include_once (ROOT_DIR.'/domain/Reservation.php');
include_once (ROOT_DIR.'/domain/UserProfile.php');
include_once (ROOT_DIR.'/domain/Family.php');
include_once (ROOT_DIR.'/database/dbReservation.php');
include_once (ROOT_DIR.'/database/dbUserProfile.php');
//include_once (ROOT_DIR.'/database/ProfileActivity.php');
include_once (ROOT_DIR.'/database/dbFamilyProfile.php');
include_once (ROOT_DIR .'/mail/functions.php');
/**
 * Submitted Form Actions if a token is set, and $_POST['submit'] ==
"submit"
*/

$showForm = false;
$showResult = false;
$message= array();

error_log("in referralForm");

        //get family values from database to fill into form
        if(isset($_GET['id'])){
        $familyID = sanitize($_GET['id']);
        $family = retrieve_FamilyProfile($familyID);
        $patientfname= $family->get_patientfname();
        $patientlname= $family->get_patientlname();
        $patientnotes= $family->get_patientnotes();
        $parentfname= $family->get_parentfname();
        $parentlname= $family->get_parentlname();
        setFamilyID($familyID);
        }
        else
        {
            $family = retrieve_FamilyProfile($_SESSION['familyID']);
            $patientfname= $family->get_patientfname();
            $patientlname= $family->get_patientlname();
            $patientnotes= $family->get_patientnotes();
            $parentfname= $family->get_parentfname();
            $parentlname= $family->get_parentlname();
        }
       
//if token works
    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
   //startDate is not set
    if ((empty($_POST['begindate'])))
   {
       $message['BeginningDate'] = '<p><font color="red">You must select a beginning date!</font></p>';
       $showForm = true;
   }
   //endDate is not set
   if ((empty($_POST['enddate'])))
   {
       $message['EndDate'] = '<p><font color="red">You must select an end date!</font></p>';
       $showForm = true;
   }
    

   //Everything is set
else
    {
       //check if dates are valid
        $currentdate= date("Ymd");
        $bdate= new DateTime($_POST['begindate']);
        $edate= new DateTime($_POST['enddate']);
        $formatbdate= $bdate->format('Ymd');
        $formatedate= $edate->format('Ymd');
       //end date before begin date
       if(($formatedate - $formatbdate) <= 0)
       {
           $message['EndAfterBeginDate'] = '<p><font color="red">End date must be after begin date!</font></p>';
           $showForm = true;
       }
       //request dates are in the past
       if($currentdate - $formatedate >=0 || $currentdate - $formatbdate >0)
       {
           $message['DatesInThePast'] = '<p><font color="red">Dates cannot be in the past!</font></p>';
           $showForm = true;
       }
       else
       {
           $showResult = true;
       }
    }
            //patient last name is not set
            if( isset( $_POST['PatientLastName'] )&& !empty($_POST['PatientLastName'])&& ($_POST['PatientLastName']!= 'Patient\'s Last Name')){
            $newPatientLastName = sanitize( $_POST['PatientLastName'] );
             }
             else{
                  $message['PatientLastName'] = '<p><font color="red">You must enter the Patient Last Name.</font></p>';
                  $showForm = true;
                  
             }
             //patient first name is not set
             if( isset( $_POST['PatientFirstName'] )&& !empty($_POST['PatientFirstName'])&& ($_POST['PatientFirstName']!= 'Patient\'s First Name')){
            $newPatientFirstName = sanitize( $_POST['PatientFirstName'] );
             }
             else{
                  $message['PatientFirstName'] = '<p><font color="red">You must enter the Patient First Name.</font></p>';
                  $showForm = true;
                  
             }         
            //patient diagnosis is not set
            if( isset( $_POST['PatientDiagnosis'] ) && !empty($_POST['PatientDiagnosis'])&& ($_POST['PatientDiagnosis']!= 'Patient Diagnosis and Reason for Stay')){
            $newPatientDiagnosis = sanitize( $_POST['PatientDiagnosis'] );
            }
            else { 
                $message['PatientDiagnosis'] = '<p><font color="red">You must enter the Patient Diagnosis and Reason for Stay.</font></p>';
                $showForm = true;
                
            }
            if( isset( $_POST['Notes'] ) && ($_POST['Notes']!='Notes')){
            $newNotes = sanitize( $_POST['Notes'] );
            }
            //parent last name is not set
            if( isset( $_POST['ParentLastName'] )&& !empty($_POST['ParentLastName']) && ($_POST['ParentLastName']!= 'Parent\'s Last Name')){
            $newParentLastName = sanitize( $_POST['ParentLastName'] );
             }
             else {
                  $message['ParentLastName'] = '<p><font color="red">You must enter the Parents Last Name.</font></p>';
                  $showForm = true;  
             }
             //parent first name is not set
            if( isset( $_POST['ParentFirstName'] ) && !empty($_POST['ParentFirstName']) && ($_POST['ParentFirstName']!= 'Parent\'s First Name')){
            $newParentFirstName = sanitize( $_POST["ParentFirstName"] );
            }
            else {
                $message['ParentFirstName'] = '<p><font color="red">You must enter the Parents First Name.</font></p>';
                $showForm = true;
            }
        echo '<div id="content" style="margin-left: 300px; margin-top: 23px;">';
        if (!empty($message)) 
        {
        foreach ($message as $messages) 
            {
            echo $messages;
            }
        }
    }
    
    
//Token is bad
 else if(isset($_POST['form_token']) && !validateTokenField($_POST))
{
    $_POST['begindate'] = "";
    $_POST['enddate'] = "";
    $_POST['PatientDiagnosis'] = "";
    $_POST['Notes'] = "";
    $_POST['ParentLastName'] = "";
    $_POST['ParentFirstName'] = "";
    $message = '<p><font color="red">Please select and enter all required data for your reservation</font></p>';
    $showForm = true;
}  
//No POST data
else
{
    $_POST['begindate'] = "";
    $_POST['enddate'] = "";
    $_POST['PatientDiagnosis'] = "";
    $_POST['Notes'] = "";
    $_POST['ParentLastName'] = "";
    $_POST['ParentFirstName'] = "";
    $message = '<p><font color="red">Please select and enter all required data for your reservation</font></p>';
    $showForm = true;

} ?>
</div>

 


<?php    
   // mail("approvers email address goes here", $RoomReservationRequestID,
//"This is a pending request")//email the approver the request key, not sure
//if it should look like this though.

   echo '<div id="container">';
   echo '<div id="content" style="margin-left: 250px; margin-top: 23px;">';

   //if $showForm = true, display form to enter data
if($showForm == true)
{
    //FORM
    ?>
<section class="content">
<form name ="NewReferralForm" method="POST" action="referralForm.php">
            <?php echo generateTokenField(); ?>
    <label for="BeginDate">Begin Date:</label>
        <input name="begindate" type="date">
    <br><br>
    <label for="endDate">End Date:</label>
        <input name="enddate" type="date">
    <br><br>
    <label for="patientlname">Patient Last Name</label>
         <input class="formt formtop" id="patientlname" type="text" name="PatientLastName" value="<?php echo htmlspecialchars($patientlname); ?>" onblur="if(this.value == '') { this.value = 'Patient\'s Last Name'; }" onfocus="if(this.value == 'Patient\'s Last Name'){ this.value = ''; }"/>
         <label for="patientfname">Patient First Name</label>
         <input class="formt" id="patientfname" type="text" name="PatientFirstName" value="<?php echo htmlspecialchars($patientfname); ?>" onblur="if(this.value == '') { this.value = 'Patient\'s First Name'; }" onfocus="if(this.value == 'Patient\'s First Name'){ this.value = ''; }"/>
         <label for="patientdiagnosis">Patient Diagnosis and Reason for Stay</label>        
         <input class="formt" id="patientdiagnosis" type="text" name="PatientDiagnosis" value="Patient Diagnosis and Reason for Stay" onblur="if(this.value == '') { this.value = 'Patient Diagnosis and Reason for Stay'; }" onfocus="if(this.value == 'Patient Diagnosis and Reason for Stay'){ this.value = ''; }"/>
         <label for="notes">Notes</label>         
         <input class="formt" id="notes" type="text" name="Notes" <?php isset($patientnotes) ? print ("value=\"$patientnotes\"") : print("Notes");?> onblur="if(this.value == '') { this.value = 'Notes'; }" onfocus="if(this.value == 'Notes'){ this.value = ''; }"/>
         <label for="parentlname">Parent Last Name</label>         
         <input class="formt" id="parentlname" type="text" name="ParentLastName" value="<?php echo htmlspecialchars($parentlname); ?>" onblur="if(this.value == '') { this.value = 'Parent\'s Last Name'; }" onfocus="if(this.value == 'Parent\'s Last Name'){ this.value = ''; }"/> 
         <label for="parentfirstname">Parent First Name</label>         
         <input class="formt formbottom" id="parentfirstname" type="text" name="ParentFirstName" value="<?php echo htmlspecialchars($parentfname); ?>" onblur="if(this.value == '') { this.value = 'Parent\'s First Name'; }" onfocus="if(this.value == 'Parent\'s First Name'){ this.value = ''; }"/>
          
         <input class="formsubmit"type="submit" value="Submit" name="submit" />
       </form>            
</section>
     <?php

}

     else if($showResult == true)
            {
            $newBeginDate =
sanitize($_POST['begindate']);
            $newEndDate =
sanitize($_POST['enddate']);

               
       //retrieves the sw, and gets id, firstname and lastname      
        $currentUser = getUserProfileID();
        $sw = retrieve_UserProfile_SW($currentUser);
        $swObject = current($sw);
        $sw_id = $swObject->get_swProfileId();
        $swFirstName = $swObject->get_swFirstName();
        $swLastName = $swObject->get_swLastName();
        $ActivityType ="Apply";
        $Status ="Unconfirmed";
        $swDateStatusSubmitted = date("Y-m-d");
        $userId = sanitize(getCurrentUser());
        


            }
             

       if(empty($message))
      {
           // RMH staff fields are null because this is a new reservation
        $currentreservation = new Reservation (0, 0, 0, $_SESSION['familyID'], $newParentLastName, 
                $newParentFirstName, $newPatientLastName, $newPatientFirstName, $sw_id, $swLastName, $swFirstName, 'NULL', 'NULL',
                'NULL', $swDateStatusSubmitted, 'NULL', $ActivityType, $Status, $newBeginDate, $newEndDate,
                $newPatientDiagnosis, $newNotes);
        $roomReservationKey= insert_RoomReservationActivity($currentreservation);
         echo '<section class="content">';
        echo '<p><font color="red">The reservation was made successfully made!</font></p><br/>';
        echo "The referral was made by : " .$userId. "<br>";
        echo "The Begin Date is : " .$newBeginDate. "<br>";
        echo "The End Date is : " .$newEndDate. "<br>";
        echo "The Patient's Diagnosis is : " .$newPatientDiagnosis."<br>";
        echo "Notes on the referral are : " .$newNotes."<br>";
        echo "The Parent's Last name is : ".$newParentLastName."<br>";
        echo "The Parent's First name is : ".$newParentFirstName."<br>";
        echo "The Referral Request currently has a Status of :
".$Status."<br>";
        echo "Date submitted is : " .$swDateStatusSubmitted."<br>";
        
        
         echo '<br>';
        
        echo '<br><br>
            <table border = "2" cellspacing = "10" cellpadding = "6">';       
        echo '<thead>
            <tr>
           <th>Room Reservation Key</th>
           <th>Status</th>
           <th>Parent Last Name</th>
           <th>Parent First Name</th>
           <th>Social Worker Profile ID</th>
           <th width="90">Begin Date</th>
           <th width="90">End Date</th>
         
           
            </thead>
            <tbody>';
        
        echo '<tr>';
        echo '<td>'.$roomReservationKey.'</td>';
        echo '<td>'.$Status.'</td>';
        echo '<td>'.$newParentLastName.'</td>';
        echo '<td>'.$newParentFirstName.'</td>';
        echo '<td>'.$sw_id.'</td>';
        echo '<td>'.$newBeginDate.'</td>';
        echo '<td>'.$newEndDate.'</td>';
       echo '</section>';

        //send email to RMH approver about new room reservation request
 //       newRequest($roomReservationKey, $swDateStatusSubmitted, $newBeginDate, $newEndDate);
          }
      

       
        
        
     ?>
</div>
</div>

    <?php    
include (ROOT_DIR.'/footer.php');
?>
