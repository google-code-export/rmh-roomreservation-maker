<?php
/*
* Copyright 2012 by Prayas Bhattarai and Bonnie MacKellar.
* This program is part of RMH-RoomReservationMaker, which is free software,
* inspired by the RMH Homeroom Project.
* It comes with absolutely no warranty.  You can redistribute and/or
* modify it under the terms of the GNU Public License as published
* by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
 
/**
* List User page for RMH-RoomReservationMaker. 
* This file contains the script to list out all the users that are registered in the system.
* The users are grouped by their category and can be filtered based on this category.
* @author Prayas Bhattarai
* @version May 1, 2012
*/
//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "User List"; //This should be the title for the page, included in the <title></title>

include('../header.php'); //including this will further include (globalFunctions.php and config.php)

include(ROOT_DIR.'/database/dbUserProfile.php');

$allUsers = array();
$userType = 'all';
if(isset($_GET['type']))
{
    $userType = $_GET['type'];
    
    switch($userType)
    {
        case 'admins':
            $allUsers['RMH Administrators'] = retrieve_all_UserProfile_byRole('RMH Administrator');
        break;
        case 'rmhstaff':
            $allUsers['RMH Staff Approvers'] = retrieve_all_UserProfile_byRole('RMH Staff Approver');
        break;
        case 'socialworkers':
           $allUsers['Social Workers'] = retrieve_all_UserProfile_byRole('Social Worker');
        break;
        default:
            $allUsers['RMH Administrators'] = retrieve_all_UserProfile_byRole('RMH Administrator');
            $allUsers['RMH Staff Approvers'] = retrieve_all_UserProfile_byRole('RMH Staff Approver');
            $allUsers['Social Workers'] = retrieve_all_UserProfile_byRole('Social Worker');
        break;
    }
}
else
{           
    $allUsers['RMH Administrators'] = retrieve_all_UserProfile_byRole('RMH Administrator');
    $allUsers['RMH Staff Approvers'] = retrieve_all_UserProfile_byRole('RMH Staff Approver');
    $allUsers['Social Workers'] = retrieve_all_UserProfile_byRole('Social Worker');
}

function displayUsersTable($allUsers)
{
    foreach($allUsers as $title=>$userGroup)
    {
        echo '<h2>'.$title.'</h2>';
        echo '<table border = "2" cellspacing = "10" cellpadding = "10" style="width:500px; margin-bottom: 10px;">';       
        echo '<thead>
                <tr>
                    <th>Username</th>
                    <th colspan="3">Actions</th>
                </tr>
                </thead>';
        foreach($userGroup as $user)
        {
            echo '<tr>';
                echo '<td>'.$user->get_usernameId().'</td>';
                echo '<td><a class="viewUser" href="#" data-user="'.$user->get_userProfileId().'" data-group="'.$user->get_UserCategory().'">View</a></td>';
                echo '<td>Edit</td>';
                echo '<td>Delete</td>';
            echo '</tr>';
        }
        echo '</table>';
               
    }
}

?>

<div id="container">

    <div id="content" style="margin-left: 250px; margin-top: 23px;">
        
        <!-- ALL YOUR HTML CONTENT GOES HERE -->
        <div>
            <label for="filterUsers">Show users:</label>
            <select id="filterUsers" name="filterUsers">
                <option value="all" <?php echo($userType=='all' ? ' selected="selected"':null) ?>>All</option>
                <option value="admins" <?php echo($userType=='admins' ? ' selected="selected"':null) ?>>RMH Administrators</option>
                <option value="rmhstaff" <?php echo($userType=='rmhstaff' ? ' selected="selected"':null) ?>>RMH Staff Approvers</option>
                <option value="socialworkers" <?php echo($userType=='socialworkers' ? ' selected="selected"':null) ?>>Social Workers</option>
            </select>
        </div>
        <div id ="userListContainer">
        <?php
            displayUsersTable($allUsers);
        ?> 
        </div>
        </br></br>
    <input type="submit" class="helpbutton" value="Help" align="bottom" onclick="location.href='../help/ViewUserHelp.php'" />
    </div>
    
</div>
<div class="overlay" style="display:none; background: url('<?php echo BASE_DIR;?>/images/bars.png') repeat; width: 100%; height: 100%; position: fixed;left:0; top:0; z-index: 999;">
    <div class="modalBox" style="position: relative; background: none #FFFFFF; width: 400px; margin:150px auto; border-radius: 5px; padding: 5px;">
        test
    </div>
    
</div>
<script type="text/javascript">
    $(function(){
       $('#filterUsers').change(function(){
          var userType = $(this).children('option:selected').val();
          window.location = '<?php echo BASE_DIR;?>/admin/listUsers.php?type='+userType;
       });
       
       $('.viewUser').click(function(evt){
           evt.preventDefault();
           evt.stopImmediatePropagation();
           var user = $(this).data('user');
           var group = $(this).data('group');
           var url = '<?php echo BASE_DIR;?>/admin/userActionHandler.php?view=' + user + '&group=' + group;
           $.ajax({
                    type: "POST",
                    url: url
                    }).success(function(data){
                        $('.modalBox').html(data);
                        $('.overlay').fadeIn();
                    }).error(function(error){
                        $('.modalBox').html(error.responseText);
                    });
          });
          $('.overlay').click(function(evt){
            if($(evt.target).hasClass('overlay'))
                $(this).fadeOut();
            else
                return true;
          })       
    });
</script>
<?php 
include (ROOT_DIR.'/footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
?>