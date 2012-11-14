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
//include_once(ROOT_DIR .'/mail/functions.php');
/**
 * Submitted Form Actions if a token is set, and $_POST['submit'] ==
"submit"
*/

$showForm = false;
$showReport = false;
$message= array();


        //get family values from database to fill into form
        if(isset($_GET['family'])){
        $familyID = sanitize($_GET['family']);
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
    if ((empty($_POST['beginYear'])) || (empty($_POST['beginMonth'])) || (empty($_POST['beginDay'])))
   {
       $message['BeginningDate'] = '<p><font color="red">You must select a beginning date!</font></p>';
       $showForm = true;
   }
   //endDate is not set
   if ((empty($_POST['endYear'])) || (empty($_POST['endMonth'])) || (empty($_POST['endDay'])))
   {
       $message['EndDate'] = '<p><font color="red">You must select an end date!</font></p>';
       $showForm = true;
   }
    

   //Everything is set
else
    {
       //check if dates are valid
       $beginDateMins =
($_POST['beginYear']*365*24*60)+($_POST['beginMonth']*30*24*60)+($_POST['beginDay']*24*60);
       $endDateMins =
($_POST['endYear']*365*24*60)+($_POST['endMonth']*30*24*60)+($_POST['endDay']*24*60);
       if(($endDateMins - $beginDateMins) <= 0)
       {
           $message['EndAfterBeginDate'] = '<p><font color="red">End date must be after begin Date!</font></p>';
           $showForm = true;
       }
       else
       {
           $showReport = true;
       }
    }
            //patient last name is not set
            if( isset( $_POST['PatientLastName'] )&& !empty($_POST['PatientLastName'])){
            $newPatientLastName = sanitize( $_POST['PatientLastName'] );
             }
             else{
                  $message['PatientLastName'] = '<p><font color="red">You must enter the Patient Last Name.</font></p>';
                  $showForm = true;
                  
             }
             //patient first name is not set
             if( isset( $_POST['PatientFirstName'] )&& !empty($_POST['PatientFirstName'])){
            $newPatientFirstName = sanitize( $_POST['PatientFirstName'] );
             }
             else{
                  $message['PatientFirstName'] = '<p><font color="red">You must enter the Patient First Name.</font></p>';
                  $showForm = true;
                  
             }         
            //patient diagnosis is not set
            if( isset( $_POST['PatientDiagnosis'] ) && !empty($_POST['PatientDiagnosis'])){
            $newPatientDiagnosis = sanitize( $_POST['PatientDiagnosis'] );
            }
            else { 
                $message['PatientDiagnosis'] = '<p><font color="red">You must enter the Patient Diagnosis.</font></p>';
                $showForm = true;
                
            }
            if( isset( $_POST['Notes'] )){
            $newNotes = sanitize( $_POST['Notes'] );
            }
            //parent last name is not set
            if( isset( $_POST['ParentLastName'] )&& !empty($_POST['ParentLastName'])){
            $newParentLastName = sanitize( $_POST['ParentLastName'] );
             }
             else {
                  $message['ParentLastName'] = '<p><font color="red">You must enter the Parents Last Name.</font></p>';
                  $showForm = true;  
             }
             //parent first name is not set
            if( isset( $_POST['ParentFirstName'] ) && !empty($_POST['ParentFirstName'])){
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
    $_POST['beginYear'] = "";
    $_POST['beginMonth'] = "";
    $_POST['beginDay'] = "";
    $_POST['endYear'] = "";
    $_POST['endMonth'] = "";
    $_POST['endDay'] = "";
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
    $_POST['beginYear'] = "";
    $_POST['beginMonth'] = "";
    $_POST['beginDay'] = "";
    $_POST['endYear'] = "";
    $_POST['endMonth'] = "";
    $_POST['endDay'] = "";
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
<form name ="NewReferralForm" method="POST" action="referralForm.php">
            <?php echo generateTokenField(); ?>
           <label for="BeginDate">Begin Date:</label>
           <select name="beginMonth">
            <option value="">Month</option>
            <option value="01" <?php if($_POST['beginMonth']=='01') echo
"selected='selected'";?> >January</option>
            <option value="02" <?php if($_POST['beginMonth']=='02') echo
"selected='selected'";?> > February</option>
            <option value="03" <?php if($_POST['beginMonth']=='03') echo
"selected='selected'";?> >March</option>
            <option value="04" <?php if($_POST['beginMonth']=='04') echo
"selected='selected'";?> >April</option>
            <option value="05" <?php if($_POST['beginMonth']=='05') echo
"selected='selected'";?>>May</option>
            <option value="06" <?php if($_POST['beginMonth']=='06') echo
"selected='selected'";?> >June</option>
            <option value="07" <?php if($_POST['beginMonth']=='07') echo
"selected='selected'";?> >July</option>
            <option value="08" <?php if($_POST['beginMonth']=='08') echo
"selected='selected'";?> >August</option>
            <option value="09" <?php if($_POST['beginMonth']=='09') echo
"selected='selected'";?> >September</option>
            <option value="10" <?php if($_POST['beginMonth']=='10') echo
"selected='selected'";?> >October</option>
            <option value="11" <?php if($_POST['beginMonth']=='11') echo
"selected='selected'";?> >November</option>
            <option value="12" <?php if($_POST['beginMonth']=='12') echo
"selected='selected'";?> >December</option>
        </select>
        <select name="beginDay">
            <option value="">Day</option>
            <option value="01" <?php if($_POST['beginDay']=='01') echo
"selected='selected'";?> >01</option>
            <option value="02" <?php if($_POST['beginDay']=='02') echo
"selected='selected'";?> >02</option>
            <option value="03" <?php if($_POST['beginDay']=='03') echo
"selected='selected'";?> >03</option>
            <option value="04" <?php if($_POST['beginDay']=='04') echo
"selected='selected'";?> >04</option>
            <option value="05" <?php if($_POST['beginDay']=='05') echo
"selected='selected'";?> >05</option>
            <option value="06" <?php if($_POST['beginDay']=='06') echo
"selected='selected'";?> >06</option>
            <option value="07" <?php if($_POST['beginDay']=='07') echo
"selected='selected'";?> >07</option>
            <option value="08" <?php if($_POST['beginDay']=='08') echo
"selected='selected'";?> >08</option>
            <option value="09" <?php if($_POST['beginDay']=='09') echo
"selected='selected'";?> >09</option>
            <option value="10" <?php if($_POST['beginDay']=='10') echo
"selected='selected'";?> >10</option>
            <option value="11" <?php if($_POST['beginDay']=='11') echo
"selected='selected'";?> >11</option>
            <option value="12" <?php if($_POST['beginDay']=='12') echo
"selected='selected'";?> >12</option>
            <option value="13" <?php if($_POST['beginDay']=='13') echo
"selected='selected'";?> >13</option>
            <option value="14" <?php if($_POST['beginDay']=='14') echo
"selected='selected'";?> >14</option>
            <option value="15" <?php if($_POST['beginDay']=='15') echo
"selected='selected'";?> >15</option>
            <option value="16" <?php if($_POST['beginDay']=='16') echo
"selected='selected'";?> >16</option>
            <option value="17" <?php if($_POST['beginDay']=='17') echo
"selected='selected'";?> >17</option>
            <option value="18" <?php if($_POST['beginDay']=='18') echo
"selected='selected'";?> >18</option>
            <option value="19" <?php if($_POST['beginDay']=='19') echo
"selected='selected'";?> >19</option>
            <option value="20" <?php if($_POST['beginDay']=='20') echo
"selected='selected'";?> >20</option>
            <option value="21" <?php if($_POST['beginDay']=='21') echo
"selected='selected'";?> >21</option>
            <option value="22" <?php if($_POST['beginDay']=='22') echo
"selected='selected'";?> >22</option>
            <option value="23" <?php if($_POST['beginDay']=='23') echo
"selected='selected'";?> >23</option>
            <option value="24" <?php if($_POST['beginDay']=='24') echo
"selected='selected'";?> >24</option>
            <option value="25" <?php if($_POST['beginDay']=='25') echo
"selected='selected'";?> >25</option>
            <option value="26" <?php if($_POST['beginDay']=='26') echo
"selected='selected'";?> >26</option>
            <option value="27" <?php if($_POST['beginDay']=='27') echo
"selected='selected'";?> >27</option>
            <option value="28" <?php if($_POST['beginDay']=='28') echo
"selected='selected'";?> >28</option>
            <option value="29" <?php if($_POST['beginDay']=='29') echo
"selected='selected'";?> >29</option>
            <option value="30" <?php if($_POST['beginDay']=='30') echo
"selected='selected'";?> >30</option>
            <option value="31" <?php if($_POST['beginDay']=='31') echo
"selected='selected'";?> >31</option>
        </select>
        <select name="beginYear">
            <option value="">Year</option>
            <option value="2000" <?php if($_POST['beginYear']=='2000') echo
"selected='selected'";?> >2000</option>
            <option value="2001" <?php if($_POST['beginYear']=='2001') echo
"selected='selected'";?> >2001</option>
            <option value="2002" <?php if($_POST['beginYear']=='2002') echo
"selected='selected'";?> >2002</option>
            <option value="2003" <?php if($_POST['beginYear']=='2003') echo
"selected='selected'";?> >2003</option>
            <option value="2004" <?php if($_POST['beginYear']=='2004') echo
"selected='selected'";?> >2004</option>
            <option value="2005" <?php if($_POST['beginYear']=='2005') echo
"selected='selected'";?> >2005</option>
            <option value="2006" <?php if($_POST['beginYear']=='2006') echo
"selected='selected'";?> >2006</option>
            <option value="2007" <?php if($_POST['beginYear']=='2007') echo
"selected='selected'";?> >2007</option>
            <option value="2008" <?php if($_POST['beginYear']=='2008') echo
"selected='selected'";?> >2008</option>
            <option value="2009" <?php if($_POST['beginYear']=='2009') echo
"selected='selected'";?> >2009</option>
            <option value="2010" <?php if($_POST['beginYear']=='2010') echo
"selected='selected'";?> >2010</option>
            <option value="2011" <?php if($_POST['beginYear']=='2011') echo
"selected='selected'";?> >2011</option>
            <option value="2012" <?php if($_POST['beginYear']=='2012') echo
"selected='selected'";?> >2012</option>
            <option value="2013" <?php if($_POST['beginYear']=='2013') echo
"selected='selected'";?> >2013</option>
    </select>
    <br><br>
    <label for="endDate">End Date:</label>
        <select name="endMonth">
            <option value="">Month</option>
            <option value="01" <?php if($_POST['endMonth']=='01') echo
"selected='selected'";?> >January</option>
            <option value="02" <?php if($_POST['endMonth']=='02') echo
"selected='selected'";?> > February</option>
            <option value="03" <?php if($_POST['endMonth']=='03') echo
"selected='selected'";?> >March</option>
            <option value="04" <?php if($_POST['endMonth']=='04') echo
"selected='selected'";?> >April</option>
            <option value="05" <?php if($_POST['endMonth']=='05') echo
"selected='selected'";?>>May</option>
            <option value="06" <?php if($_POST['endMonth']=='06') echo
"selected='selected'";?> >June</option>
            <option value="07" <?php if($_POST['endMonth']=='07') echo
"selected='selected'";?> >July</option>
            <option value="08" <?php if($_POST['endMonth']=='08') echo
"selected='selected'";?> >August</option>
            <option value="09" <?php if($_POST['endMonth']=='09') echo
"selected='selected'";?> >September</option>
            <option value="10" <?php if($_POST['endMonth']=='10') echo
"selected='selected'";?> >October</option>
            <option value="11" <?php if($_POST['endMonth']=='11') echo
"selected='selected'";?> >November</option>
            <option value="12" <?php if($_POST['endMonth']=='12') echo
"selected='selected'";?> >December</option>
        </select>
        <select name="endDay">
            <option value="">Day</option>
            <option value="01" <?php if($_POST['endDay']=='01') echo
"selected='selected'";?> >01</option>
            <option value="02" <?php if($_POST['endDay']=='02') echo
"selected='selected'";?> >02</option>
            <option value="03" <?php if($_POST['endDay']=='03') echo
"selected='selected'";?> >03</option>
            <option value="04" <?php if($_POST['endDay']=='04') echo
"selected='selected'";?> >04</option>
            <option value="05" <?php if($_POST['endDay']=='05') echo
"selected='selected'";?> >05</option>
            <option value="06" <?php if($_POST['endDay']=='06') echo
"selected='selected'";?> >06</option>
            <option value="07" <?php if($_POST['endDay']=='07') echo
"selected='selected'";?> >07</option>
            <option value="08" <?php if($_POST['endDay']=='08') echo
"selected='selected'";?> >08</option>
            <option value="09" <?php if($_POST['endDay']=='09') echo
"selected='selected'";?> >09</option>
            <option value="10" <?php if($_POST['endDay']=='10') echo
"selected='selected'";?> >10</option>
            <option value="11" <?php if($_POST['endDay']=='11') echo
"selected='selected'";?> >11</option>
            <option value="12" <?php if($_POST['endDay']=='12') echo
"selected='selected'";?> >12</option>
            <option value="13" <?php if($_POST['endDay']=='13') echo
"selected='selected'";?> >13</option>
            <option value="14" <?php if($_POST['endDay']=='14') echo
"selected='selected'";?> >14</option>
            <option value="15" <?php if($_POST['endDay']=='15') echo
"selected='selected'";?> >15</option>
            <option value="16" <?php if($_POST['endDay']=='16') echo
"selected='selected'";?> >16</option>
            <option value="17" <?php if($_POST['endDay']=='17') echo
"selected='selected'";?> >17</option>
            <option value="18" <?php if($_POST['endDay']=='18') echo
"selected='selected'";?> >18</option>
            <option value="19" <?php if($_POST['endDay']=='19') echo
"selected='selected'";?> >19</option>
            <option value="20" <?php if($_POST['endDay']=='20') echo
"selected='selected'";?> >20</option>
            <option value="21" <?php if($_POST['endDay']=='21') echo
"selected='selected'";?> >21</option>
            <option value="22" <?php if($_POST['endDay']=='22') echo
"selected='selected'";?> >22</option>
            <option value="23" <?php if($_POST['endDay']=='23') echo
"selected='selected'";?> >23</option>
            <option value="24" <?php if($_POST['endDay']=='24') echo
"selected='selected'";?> >24</option>
            <option value="25" <?php if($_POST['endDay']=='25') echo
"selected='selected'";?> >25</option>
            <option value="26" <?php if($_POST['endDay']=='26') echo
"selected='selected'";?> >26</option>
            <option value="27" <?php if($_POST['endDay']=='27') echo
"selected='selected'";?> >27</option>
            <option value="28" <?php if($_POST['endDay']=='28') echo
"selected='selected'";?> >28</option>
            <option value="29" <?php if($_POST['endDay']=='29') echo
"selected='selected'";?> >29</option>
            <option value="30" <?php if($_POST['endDay']=='30') echo
"selected='selected'";?> >30</option>
            <option value="31" <?php if($_POST['endDay']=='31') echo
"selected='selected'";?> >31</option>
        </select>
        <select name="endYear">
            <option value="">Year</option>
            <option value="2000" <?php if($_POST['endYear']=='2000') echo
"selected='selected'";?> >2000</option>
            <option value="2001" <?php if($_POST['endYear']=='2001') echo
"selected='selected'";?> >2001</option>
            <option value="2002" <?php if($_POST['endYear']=='2002') echo
"selected='selected'";?> >2002</option>
            <option value="2003" <?php if($_POST['endYear']=='2003') echo
"selected='selected'";?> >2003</option>
            <option value="2004" <?php if($_POST['endYear']=='2004') echo
"selected='selected'";?> >2004</option>
            <option value="2005" <?php if($_POST['endYear']=='2005') echo
"selected='selected'";?> >2005</option>
            <option value="2006" <?php if($_POST['endYear']=='2006') echo
"selected='selected'";?> >2006</option>
            <option value="2007" <?php if($_POST['endYear']=='2007') echo
"selected='selected'";?> >2007</option>
            <option value="2008" <?php if($_POST['endYear']=='2008') echo
"selected='selected'";?> >2008</option>
            <option value="2009" <?php if($_POST['endYear']=='2009') echo
"selected='selected'";?> >2009</option>
            <option value="2010" <?php if($_POST['endYear']=='2010') echo
"selected='selected'";?> >2010</option>
            <option value="2011" <?php if($_POST['endYear']=='2011') echo
"selected='selected'";?> >2011</option>
            <option value="2012" <?php if($_POST['endYear']=='2012') echo
"selected='selected'";?> >2012</option>
            <option value="2013" <?php if($_POST['endYear']=='2013') echo
"selected='selected'";?> >2013</option>
</select>
    <br><br>
    <label for="patientlname">Patient Last Name</label>
         <input class="formt formtop" id="patientlname" type="text" name="PatientLastName" value="<?php echo htmlspecialchars($patientlname); ?>"/>
         <label for="patientfname">Patient First Name</label>
         <input class="formt" id="patientfname" type="text" name="PatientFirstName" value="<?php echo htmlspecialchars($patientfname); ?>" onfocus="if(this.value == 'PatientDiagnosis'){ this.value = ''; }"/>
         <label for="patientdiagnosis">Patient Diagnosis</label>        
         <input class="formt" id="patientdiagnosis" type="text" name="PatientDiagnosis" value=PatientDiagnosis onfocus="if(this.value == 'PatientDiagnosis'){ this.value = ''; }"/>
         <label for="notes">Notes</label>         
         <input class="formt" id="notes" type="text" name="Notes" value="<?php echo htmlspecialchars($patientnotes); ?>" onfocus="if(this.value == 'Notes'){ this.value = ''; }"/>
         <label for="parentlname">Parent Last Name</label>         
         <input class="formt" id="parentlname" type="text" name="ParentLastName" value="<?php echo htmlspecialchars($parentlname); ?>" onfocus="if(this.value == 'ParentLastName'){ this.value = ''; }"/>
         <label for="parentfirstname">Parent First Name</label>         
         <input class="formt formbottom" id="parentfirstname" type="text" name="ParentFirstName" value="<?php echo htmlspecialchars($parentfname); ?>" onfocus="if(this.value == 'ParentFirstName'){ this.value = ''; }"/>
          
           
           <input class="formsubmit"type="submit" value="Submit" name="submit" />
       </form>            

     <?php

}

     else if($showReport == true)
            {
            $newBeginDate =
sanitize($_POST['beginYear']."-".$_POST['beginMonth']."-".$_POST['beginDay']);
            $newEndDate =
sanitize($_POST['endYear']."-".$_POST['endMonth']."-".$_POST['endDay']);
            
            

   
    
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
            <table border = "2" cellspacing = "10" cellpadding = "10">';       
        echo '<thead>
            <tr>
            <th>Status</th>
            <th>Parent Last Name</th>
           <th>Parent First Name</th>
           <th>Social Worker Profile ID</th>
           <th>Begin Date</th>
           <th>End Date</th>
         
           
            </thead>
            <tbody>';
        
        echo '<tr>';
        echo '<td>'.$Status.'</td>';
        echo '<td>'.$newParentLastName.'</td>';
        echo '<td>'.$newParentFirstName.'</td>';
        echo '<td>'.$sw_id.'</td>';
        echo '<td>'.$newBeginDate.'</td>';
        echo '<td>'.$newEndDate.'</td>';
       
      
        
        $currentreservation = new Reservation (0, 0, 0, $newParentLastName, 
                $newParentFirstName, $sw_id, $swLastName, $swFirstName, 0, "",
                "", $swDateStatusSubmitted, "", $ActivityType, $Status, $newBeginDate, $newEndDate,
                $newPatientDiagnosis, $newNotes);
            insert_RoomReservationActivity($currentreservation);
          }
      

       
        
        
     ?>
</div>
</div>

    <?php    
include (ROOT_DIR.'/footer.php');
?>
