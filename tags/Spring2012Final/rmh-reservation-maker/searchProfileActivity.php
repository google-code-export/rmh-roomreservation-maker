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
* Search profile script for RMH-RoomReservationMaker. 
* This page provides an interface to the profile activity approval page, by using the request ID as reference.
* Page can be modified to use different search methods.
* Right now, it just forwards the request ID, instead of searching.
* @author Prayas Bhattarai
* @version May 1, 2012
*/

//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Search Profile Activity"; //This should be the title for the page, included in the <title></title>

include('header.php'); //including this will further include (globalFunctions.php and config.php)
?>

<div id="container">
    <div id="content"> 
        <form method="post" action="<?php echo BASE_DIR;?>/searchProfileActivity.php">
            <?php echo generateTokenField(); ?>
                                    
            <label for="search_request_id">Enter request ID: </label>
            <input type="text" name="search_request_id" id="search_request_id" />
            
            <input id="searchActivity" type="submit" name="Search" value="Submit"/>
       </form>
    </div>
</div>
<script>
    $(function(){
        $('#searchActivity').click(function(evt){
            evt.preventDefault();
            
            var requestID = $.trim($('#search_request_id').val());
            window.location = '<?php echo BASE_DIR;?>/reservation/activity.php?type=profile&request='+requestID;
        });
    })
</script>
<?php
include (ROOT_DIR . '/footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
?>

