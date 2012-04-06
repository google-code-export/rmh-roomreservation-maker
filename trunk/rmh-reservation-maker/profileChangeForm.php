<?php
/**
 * This is a template for people who would want to create an interface for user interaction. The sequence of code blocks is important
 * because session handling requires proper sequence. Also the inclusion of header file is important. 
 * 
 * When you are creating a new file based on this template, make sure to add your page's permission requirement to the header.php file
 * example: $permission_array['template.php']=3;
 * where template.php is your file
 *         3 is the permission level required to access your page. this can be 0 through 3, where 0 is all, and 3 is admin
 * 
 * Detail explanation for each code
 * block has been provided for each section below:
 */

//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Profile Change Form"; //This should be the title for the page, included in the <title></title>

include('header.php'); //including this will further include (globalFunctions.php and config.php)

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
        
       <form name ="profileChangeForm" method="post" action="ProfileChange.php">
            <?php echo generateTokenField(); ?>
                                    
           <h1> Profile Change Request Form </h1> <br><br>
           <h3> Only fill in the field(s) that needs modification: </h3><br><br>
           
           Parent First Name:   <input type="text" name="ParentFirstName" value="" size="15" /><br>
           Parent Last Name:    <input type="text" name="ParentLastName" value="" size="15" /><br>
           Email:               <input type="text" name="Email" value="" size="30" /><br>
           Phone1:              <input type="text" name="Phone1" value="" size="15" /><br>
           Phone2:      <input type="text" name="Phone2" value="" size="15" /><br>
           Address:     <input type="text" name="Address" value="" size="30" /><br>
           City:        <input type="text" name="City" value="" size="15" /><br>
           State:       <input type="text" name="State" value="" size="2" /><br>
           Zip Code:    <input type="text" name="ZipCode" value="" size="10" /><br>
           Patient First Name:  <input type="text" name="PatientFirstName" value="" size="15" /><br>
           Patient Last Name:   <input type="text" name="PatientLastName" value="" size="15" /><br>
           Patient Relation:    <input type="text" name="PatientRelation" value="" size="15" /><br>
           Patient Day Of Birth: <input type="text" name="PatientBirthDate" value="" size="15" /><br>
           Patient Diagnosis:   <input type="text" name="PatientDiagnosis" value="" size="15" /><br><br>
                        
            <input type="submit" name="submit" value="Modify"/>
            
       </form>

    </div>
</div>

<?php 
include ('footer.php'); 
//include the footer file, this contains the proper </body> and </html> ending tag.
?>

