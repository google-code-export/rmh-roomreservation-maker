<!DOCTYPE html>

<?php 
//connects to the session to retrieve the family profile ID
//also connects to the database to retrieve user information.
session_start();
include_once ('../core/globalFunctions.php');
include_once (ROOT_DIR.'/database/dbFamilyProfile.php');
$familyID = $_SESSION['ID'];
$family = retrieve_FamilyProfile($familyID);
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Step 2</title>
        <style>
            body {font-family:sans-serif, Arial, Centaur;font-size:17px;text-align:left;}
            h1.heading {font-size:24px;font-weight:bold;text-align:center;text-decoration: underline;}
            p.intro {font-weight:bold;font-size:20px;text-decoration: underline;}
            p.small {font-size:14px;text-align:center;}
            span.red {color:red;text-decoration:underline;}
        </style>
    </head>
    <body>
        
        <h1 class="heading">Step 2</h1>

<p class="intro">Guest Wellness Profile</p>

<p>To ensure all of guests have a sick free stay, please take a minute to answer the following questions while you check in. Please check the appropriate box if it applies to you or anyone in your party who will be staying with you during this visit to the house.

<p>Thank you!</p>

<!--Wellness fill-ins go here, as well as a submission button.
Remember to save the information in a session variable $_SESSION['ques1']=1 (or 0), etc.-->
<a href="mailForm4.php">Temporary button</a>

    </body>
</html>