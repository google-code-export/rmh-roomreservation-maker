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

$title = "Welcome"; //This should be the title for the page, included in the <title></title>

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
        

?>

<div id="container">
    <div id="content">
        
        <!-- ALL YOUR HTML CONTENT GOES HERE -->
        
        <!-- If your page has a form please follow the coding guideline:
        Once you have your form setup, add the following php code after the form declaration:
        generateTokenField() 
        
        IMPORTANT: Make sure that generateTokenField() is always after validateTokenField in your code sequence
        
        EXAMPLE code block below (can be deleted if not using form) -->
        
       <form method="post" action="<?php echo BASE_DIR;?>/template.php">
            <?php echo generateTokenField(); ?>
                                    
            <label for="testname">Testname</label>
            <input type="text" name="testname" id="testname" value="testname"/>
            
            <input type="submit" name="Submit" value="Submit"/>
       </form>

    </div>
</div>
<?php 
include (ROOT_DIR.'/footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
?>

