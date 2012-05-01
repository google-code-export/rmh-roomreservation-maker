<?php
/**
 * @author Jessica Cheong
 * 
 * Profile Change Request Form and the Handling
 * 
 * This page deals with the profile change function. When the SW creates a room reservation, and there is
 * a need to modify an existing family profile. This is the page that would direct the SW to make the
 * appropriate change. The change would be stored in a different table until the data is verfied by the
 * RMH approver. This activity is stored for future references. 
 */

session_start();
session_cache_expire(30);

$title = "Family Profile Change Request";

include('../header.php');

include_once(ROOT_DIR .'/domain/UserProfile.php');
include_once(ROOT_DIR .'/domain/ProfileActivity.php');
include_once(ROOT_DIR .'/database/dbProfileActivity.php');
include_once(ROOT_DIR .'/database/dbUserProfile.php');
include_once(ROOT_DIR .'/database/dbFamilyProfile.php');
include_once(ROOT_DIR .'/mail/functions.php');

$errors = array(); //error variable that stores any error occured

        //if no family is passed, echo error and exit to prevent user from seeing the php error messages. 
        if (!isset($_GET['family'])){
            echo "The request could not be completed: Invalid family";
            exit();
        }
       //gets the family profileID from the URL
        if(isset($_GET['family'])){
            
          $familyID = sanitize($_GET['family']);           
          $Profile = familyProfileVar($familyID);
            
        }

 else if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
         
        //default types and status of the profileactivity object
        $activityType = "Edit";
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
                    
        //comparing old family profile record with new data
        //if nothing is changed, then $change remains false and the request would not be inserted
        $change = false;
        
        if(isset($_POST['familyProfileID'])){
           $familyID = sanitize($_POST['familyProfileID']);
           $Profile = familyProfileVar($familyID);
        }
            
            if($_POST['text_parentfname']!= $Profile['parentfname']){
                $parentfname = sanitize($_POST['text_parentfname']);
                //$current_activity->parentFirstName = $newParentFirstName;
                $change = true;
            }
           else{
               $parentfname = $Profile['parentfname'];
           }
            if($_POST['text_parentlname']!= $Profile['parentlname']){
                $parentlname = sanitize($_POST['text_parentlname']);
               // $current_activity->parentLastName = $newParentLastName;
                 $change = true;
            }
            else{
                $parentlname = $Profile['parentlname'];
            }
            if($_POST['text_parentemail']!= $Profile['parentemail']){
                 $parentemail = sanitize($_POST['text_parentemail']);
                  $change = true;
            }
            else{
                $parentemail = $Profile['parentemail'];
            }                
            if($_POST['text_parentphone1']!= $Profile['parentphone1']){
                $parentphone1 = sanitize($_POST['text_parentphone1']);
                 $change = true;
            }
            else{
                $parentphone1 = $Profile['parentphone1'];
            }
            if($_POST['text_parentphone2']!= $Profile['parentphone2']){
                $parentphone2 = sanitize($_POST['text_parentphone2']);
                  $change = true;
            }
            else{
                $parentphone2 = $Profile['parentphone2'];
            }
            if($_POST['text_parentAddr']!= $Profile['parentAddr']){
                $parentAddr = sanitize($_POST['text_parentAddr']);
                 $change = true;
            }
            else{
                $parentAddr = $Profile['parentAddr'];
            }
            if($_POST['text_parentcity']!= $Profile['parentcity']){
                $parentcity = sanitize($_POST['text_parentcity']);
                 $change = true;
            }
            else{
                $parentcity = $Profile['parentcity'];
            }
            if($_POST['text_parentstate']!= $Profile['parentstate']){
                $parentstate = sanitize($_POST['text_parentstate']);
                 $change = true;
            }
            else{
                $parentstate = $Profile['parentstate'];
            }
            if($_POST['text_parentzip']!= $Profile['parentzip']){
                $parentzip = sanitize($_POST['text_parentzip']);
                 $change = true;
            }
            else{
                 $parentzip = $Profile['parentzip'];
            }
            if($_POST['text_parentcountry']!= $Profile['parentcountry']){
                $parentcountry = sanitize($_POST['text_parentcountry']);
                 $change = true;
            }
            else{
                $parentcountry = $Profile['parentcountry'];
            }
             if($_POST['text_patientfname']!= $Profile['patientfname']){
                $patientfname = sanitize($_POST['text_patientfname']);
                 $change = true;
            }
            else{
                $patientfname = $Profile['patientfname'];
            }
             if($_POST['text_patientlname']!= $Profile['patientlname']){
                $patientlname = sanitize($_POST['text_patientlname']);
                 $change = true;
            }
            else{
                $patientlname = $Profile['patientlname'];
            }
             if($_POST['text_patientrelation']!= $Profile['patientrelation']){
                $patientrelation = sanitize($_POST['text_patientrelation']);
                   $change = true;
            }
            else{
                $patientrelation = $Profile['patientrelation'];
            }
             if($_POST['text_patientdob']!= $Profile['patientdob']){
                $patientdob = sanitize($_POST['text_patientdob']);
                 $change = true;
            }
            else{
                $patientdob = $Profile['patientdob'];
            }
             if($_POST['text_patientformpdf']!= $Profile['patientformpdf']){
                $patientformpdf = sanitize($_POST['text_patientformpdf']);
                 $change = true;
            }
            else{
                $patientformpdf = $Profile['patientformpdf'];
            }
            if($_POST['text_patientnotes']!= $Profile['patientnotes']){
                $patientnotes = sanitize($_POST['text_patientnotes']);
                 $change = true;
            }
            else{
               $patientnotes = $Profile['patientnotes'];
            }
             if(isset($_POST['text_swnotes'])){
                 $profileActityNotes = sanitize($_POST['text_swnotes']);
             }
             else{
                 $profileActityNotes = "";
             }
            
    $current_activity = new ProfileActivity(0, 0, $familyID, $sw_id, $sw_lname, $sw_fname, 
            0, "", "", $dateSubmit, 0, $activityType, $profileActitivityStatus, 
            $parentfname, $parentlname, $parentemail, $parentphone1, $parentphone2, 
            $parentAddr, $parentcity, $parentstate, $parentzip, 
            $parentcountry, $patientfname, $patientlname, $patientrelation, 
            $patientdob, $patientformpdf, $patientnotes, $profileActityNotes);
            
           //if there is a change, insert a new profileActivity object 
           if ($change){
               
                    if(insert_ProfileActivity($current_activity)){
                       echo "Successfully inserted a profile activity request";
                    }                  
           }
           
           //if nothing is changed, output error. No record is inserted into the db
           else if (!$change){
               echo "no changes detected\r\n";
           }
        
        //Send email to notify the rmh approvers 
        $RequestKey = $current_activity->get_profileActivityRequestId();
        
        if(newFamilyMod($RequestKey, $familyID, $dateSubmit)){
            echo "An email is sent to the RMH Approver";
        }
        echo '<a href="'.BASE_DIR.'/referralForm.php?family='.$familyID.'">Create Room Reservation</a>';
         
    } //end of success token validation
    
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        //if the security validation failed. display/store the error:
        echo "The request could not be completed.";

    }
    else
    {
        $errors['invalid_request'] = "Family Profile is not selected.";
    }

       //retrieves the family profile fields into an array to validate the input changes
       //and also to prefill existing family profile data in the html form
    function familyProfileVar($familyID){
        $Profile = array();
            
            $familyProfile = retrieve_FamilyProfile($familyID);
            $Profile['parentfname']=$familyProfile->get_parentfname();
            $Profile['parentlname']=$familyProfile->get_parentlname();
            $Profile['parentemail']=$familyProfile->get_parentemail();
            $Profile['parentphone1']=$familyProfile->get_parentphone1();
            $Profile['parentphone2']=$familyProfile->get_parentphone2();
            $Profile['parentAddr']=$familyProfile->get_parentaddress();
            $Profile['parentcity']=$familyProfile->get_parentcity();
            $Profile['parentstate']=$familyProfile->get_parentstate();
            $Profile['parentzip']=$familyProfile->get_parentzip();
            $Profile['parentcountry']=$familyProfile->get_parentcountry();
            $Profile['patientfname']=$familyProfile->get_patientfname();
            $Profile['patientlname']=$familyProfile->get_patientlname();
            $Profile['patientrelation']=$familyProfile->get_patientRelation();
            $Profile['patientdob']=$familyProfile->get_patientdob();
            $Profile['patientformpdf']=$familyProfile->get_patientformpdf();
            $Profile['patientnotes']=$familyProfile->get_patientnotes();
            return $Profile;
    }
    ?>

    <div id="container">

    <div id="content">
        
       <?php
        if(!empty($errors))
        {
            foreach($errors as $error)
            {
                echo $error;
            }
         }
       ?>
        
       <form name ="profileChangeForm" method="post" action=" <?php echo BASE_DIR; ?>/family/profileChange.php">
            <?php echo generateTokenField(); ?>    
                         
        <!--brings back the familyID-->
        <input type ="hidden" name ="familyProfileID" value="<?php echo $familyID; ?>" />   
            
        <table border = "0" cellspacing = "8" cellpadding = "5" style="width:500px; margin-bottom: 40px;">
        <thead>
        <tr>
        <th colspan="2"> <h2>Family Profile Modification Form </h2> </th>
        </tr>
        <tr>
        <td><label for="parentFname">Parent First Name: </label></td>
        <td><input type ="text" name ="text_parentfname" value="<?php echo $Profile['parentfname']; ?>" size="40" /> <br></td>
        </tr>
        <tr>
        <td> <label for="parentLname">Parent Last Name: </label></td>
        <td><input type ="text" name ="text_parentlname" value="<?php echo $Profile['parentlname']; ?>" size="40" /> <br></td> </tr>
        <tr>
        <td><label for="email"> Email: </label> </td>
        <td><input type ="text" name ="text_parentemail" value="<?php echo $Profile['parentemail']; ?>" size="40" /><br></td></tr>
        <tr>
        <td> <label for="phone1"> Phone1: </label> </td>
        <td><input type ="text" name ="text_parentphone1" value="<?php echo $Profile['parentphone1']; ?>" size="40" /><br></td></tr>
        <tr>
        <td><label for="phone2"> Phone2: </label> </td>
        <td><input type ="text" name ="text_parentphone2" value="<?php echo $Profile['parentphone2']; ?>" size="40" /><br></td></tr>
        <tr>
        <td> <label for="address"> Address: </label> </td>
        <td><input type ="text" name ="text_parentAddr" value="<?php echo $Profile['parentAddr']; ?>" size="40" /><br></td></tr>
        <tr>
        <td> <label for="city"> City: </label> </td>
        <td> <input type ="text" name ="text_parentcity" value="<?php echo $Profile['parentcity']; ?>" size="40" /><br></td></tr>
        <tr>
        <td><label for="state"> State: </label> </td>
        <td><input type ="text" name ="text_parentstate" value="<?php echo $Profile['parentstate']; ?>" size="40" /><br></td></tr>
        <tr>
        <td><label for="zip"> Zip Code: </label> </td>
        <td><input type ="text" name ="text_parentzip" value="<?php echo $Profile['parentzip']; ?>" size="40" /><br></td></tr>
        <tr>
        <td><label for="country"> Country: </label> </td>
        <td><input type ="text" name ="text_parentcountry" value="<?php echo $Profile['parentcountry']; ?>" size="40" /><br></td></tr>
        <tr>
        <td><label for="patientfname"> Patient First Name: </label> </td>
        <td><input type ="text" name ="text_patientfname" value="<?php echo $Profile['patientfname']; ?>" size="40" /><br></td> </tr>
        <tr>
        <td><label for="patientlname"> Patient Last Name: </label> </td>
        <td><input type ="text" name ="text_patientlname" value="<?php echo $Profile['patientlname']; ?>" size="40" /><br></td></tr>
        <tr>
        <td><label for="patientrelation"> Patient Relation: </label> </td>
        <td> <input type ="text" name ="text_patientrelation" value="<?php echo $Profile['patientrelation']; ?>" size="40" /></td></tr>
        <tr>
        <td><label for="dob"> Patient Day Of Birth: </label> </td>
        <td><input type ="text" name ="text_patientdob" value="<?php echo $Profile['patientdob']; ?>" size="40" /><br></td></tr>
        <tr>
        <td><label for="pdf"> Patient Diagnosis in PDF: </label> </td>
        <td><input type ="text" name ="text_patientformpdf" value="<?php echo $Profile['patientformpdf']; ?>" size="40" /><br></td></tr>
        <tr>
        <td><label for="notes"> Patient's Notes: </label> </td>
        <td><input type ="text" name ="text_patientnotes" value="<?php echo $Profile['patientnotes']; ?>" size="40" /></td></tr>
        <tr>
        <td><label for="swnotes"> Notes from Social Worker: </label> </td>
        <td><input type ="text" name ="text_swnotes" value="" size="40" /></td></tr>
        <tr>
            <td></td><td><input type="submit" name="modify" value="Modify"/></td></tr>
        </thead>
        </table>               
              
       </form>
    </div>
</div>


<?php 
include (ROOT_DIR .'/footer.php');
//include the footer file, this contains the proper </body> and </html> ending tag.

?>

