

        <?php
        // put your code here
        session_start();
        session_cache_expire(30);

        $title = "Family Profile Menu"; //This should be the title for the page, included in the <title></title>

        include('../header.php');
        include_once(ROOT_DIR .'/domain/UserProfile.php');
        include_once(ROOT_DIR .'/domain/ProfileActivity.php');
        include_once(ROOT_DIR .'/database/dbProfileActivity.php');
        include_once(ROOT_DIR .'/database/dbUserProfile.php');
        
        
        
        ?>
<html>
    <head>
    
        <title></title>
    </head>
    <body>
        <div id="container">

    <div id="content">
        
       <form name ="newProfileForm" method="post" action="FamilyProfileMenu">
            <?php echo generateTokenField(); ?>

           
        <!-- Centralizing the buttons in the middle of the screen -->
        <div > <h2 style= "margin-left: 150px; margin-top: 180px;">
        <!-- Adding the first button and linking it with newProfile class -->
        <a href="newProfile.php" style="color: white" <input class="formsubmit" type="submit" name="new"  /> Create New Profile </a>
        <!-- Putting space between the two buttons -->
        &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp;
        <!-- Adding the second button and linking it to SearchFamily Function -->
        <a href="SearchFamily.php" style="color: white" <input class="formsubmit"type="submit" name="modify" /> Search for Families</a>
         </h2>
      </body>
</html>




<?php 
include (ROOT_DIR .'/footer.php');
//include the footer file, this contains the proper </body> and </html> ending tag.
?>