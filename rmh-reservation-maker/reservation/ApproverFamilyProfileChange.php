<?php
 /*
  * @author Paul Kubler
  * 
  * Approver Form View
  * 
  */
    
//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Approve Family Profile Change"; //This should be the title for the page, included in the <title></title>

include('..\header.php'); //including this will further include (globalFunctions.php and config.php)

/*
 * If your page includes a form, please follow the instructions below.
 * If not, this code block can be deleted
 * 
 * If the page checks for $_POST data then it is important to validate the token that is attached with the form.
 * Attaching token to a form is described below in the HTML section.
 * Include the following check:
 */
    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        //the security validation was successful, perform required operation here below.
        //*** NOTE *** The validateTokenField DOES NOT filter/sanitize/clean the data fields.
        //A separate function sanitize() should be called to clean the data so that it is html/db safe
    }
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        //if the security validation failed. display/store the error:
        //'The request could not be completed: security check failed!'

    }
    else
    {
        //there was no POST DATA
    }
  
    //DISPLAY THE ENTIRE FAMILY PROFILE TO SW
?>

<div id="container">

    <div id="content">
        
        <!-- ALL YOUR HTML CONTENT GOES HERE -->
        
        <!-- If your page has a form please follow the coding guideline:
        Once you have your form setup, add the following php code after the form declaration:
        generateTokenField() 
        
        IMPORTANT: Make sure that generateTokenField() is always after validateTokenField in your code sequence
        
        EXAMPLE code block below (can be deleted if not using form) -->
       
       <form name ="approvefamilyprofile" method="post">
            <?php echo generateTokenField(); ?>
                                    
           <h1> Approve Family Profile Form </h1> <br><br>
           <?php
           '<title>$title</title>';
           include_once(ROOT_DIR .'domain/UserProfile.php');
            include_once(ROOT_DIR .'domain/ProfileChange.php');
            include_once(ROOT_DIR .'database/dbProfileActivity.php');
            include_once(ROOT_DIR .'database/dbUserProfile.php');

                //gets the family profileID and retrieves the fields into an array to validate the input changes
                //and to display in the html form
                if(isset($_GET['family']) ){
                $familyID = sanitize($_GET['family']);
                $Profile = array();
                $familyProfile = retrieve_dbFamilyProfile($familyID);
                $Profile['parentfname']=$familyProfile->get_parentfname();
                $Profile['parentlname']=$familyProfile->get_parentlname();
                $Profile['parentemail']=$familyProfile->get_parentemail();
                $Profile['parentphone1']=$familyProfile->get_parentphone1();
                $Profile['parentphone2']=$familyProfile->get_parentphone2();
                $Profile['parentcity']=$familyProfile->get_parentcity();
                $Profile['parentstate']=$familyProfile->get_parentstate();
                $Profile['parentzip']=$familyProfile->get_parentzip();
                $Profile['parentcountry']=$familyProfile->get_parentcountry();
                $Profile['patientfname']=$familyProfile->get_patientfname();
                $Profile['patientlname']=$familyProfile->get_patientlname();
                $Profile['patientrelation']=$familyProfile->get_patientrelation();
                $Profile['patientdob']=$familyProfile->get_patientdob();
                $Profile['patientformpdf']=$familyProfile->get_patientformpdf();
                $Profile['patientnotes']=$familyProfile->get_patientnotes();
            }
           'Parent First Name:'.$Profile['parentfname'].'</br>
           Parent Last Name:    '.$Profile['parentlname'].'</br>
           Email:               '.$Profile['parentemail'].'</br>
           Phone1:              '.$Profile['parentphone1'].'</br>
           Phone2:              '.$Profile['parentphone2'].'</br>
           Address:             </br>
           City:                '.$Profile['parentcity'].'</br>
           State:               '.$Profile['parentstate'].'</br>
           Zip Code:            '.$Profile['parentzip'].'</br>
           Country:             '.$Profile['parentcountry'].'</br>
           Patient First Name:  '.$Profile['patientfname'].'</br>
           Patient Last Name:   '.$Profile['patientlname'].'</br>
           Patient Relation:    '.$Profile['patientrelation'].'</br>
           Patient Day Of Birth:'.$Profile['patientdob'].'</br>
           Patient Diagnosis:   '.$Profile['patientformpdf'].'</br>
           Notes from Social Worker:'.$Profile['patientnotes'].'</br>';
           ?>
            <input type="submit" name="Approve" value="Approve" action="Approve.php"/>
            <input type="submit" name="Deny" value="Deny" action="Deny.php"/>
       </form>

    </div>
</div>

<?php 
include ('footer.php'); 
//include the footer file, this contains the proper </body> and </html> ending tag.
?>