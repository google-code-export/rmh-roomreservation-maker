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

$title = "User List"; //This should be the title for the page, included in the <title></title>

include('../header.php'); //including this will further include (globalFunctions.php and config.php)

include(ROOT_DIR.'/database/dbUserProfile.php');

$allUsers = array();

$allUsers['RMH Administrators'] = retrieve_all_UserProfile_byRole('RMH Administrator');
$allUsers['RMH Staff Approvers'] = retrieve_all_UserProfile_byRole('RMH Staff Approver');
$allUsers['Social Workers'] = retrieve_all_UserProfile_byRole('Social Worker');


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

    <?php include(ROOT_DIR.'/navigation.php');?>

    <div id="content" style="margin-left: 250px; margin-top: 23px;">
        
        <!-- ALL YOUR HTML CONTENT GOES HERE -->
        
        <?php
            foreach($allUsers as $title=>$userGroup)
            {
                echo '<table border = "2" cellspacing = "10" cellpadding = "10" style="width:500px; margin-bottom: 10px;">';       
                echo '<thead>
                        <tr>
                           <th colspan="4">'.$title.'</th>
                        </tr>
                        <tr>
                           <th>Username</th>
                           <th colspan="3">Actions</th>
                        </tr>
                      </thead>';
                foreach($userGroup as $user)
                {
                    echo '<tr>';
                        echo '<td>'.$user->get_usernameId().'</td>';
                        echo '<td>View</td>';
                        echo '<td>Edit</td>';
                        echo '<td>Delete</td>';
                    echo '</tr>';
                }
               echo '<tbody>';
               
            }
        ?>

    </div>
</div>
<?php 
include (ROOT_DIR.'/footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
?>

