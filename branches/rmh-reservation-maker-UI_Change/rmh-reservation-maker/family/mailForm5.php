<!DOCTYPE html>

<?php 
//connects to the session to retrieve the family profile ID
//also connects to the database to retrieve user information.
session_start();
include_once ('../core/globalFunctions.php');
include_once (ROOT_DIR.'/database/dbFamilyProfile.php');
include_once (ROOT_DIR.'/mail/functions.php');
$familyID = $_SESSION['ID'];
$family = retrieve_FamilyProfile($familyID);
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Step 4</title>
        <style>
            body {font-family:sans-serif, Arial, Centaur;font-size:17px;text-align:left;}
            h1.heading {font-size:24px;font-weight:bold;text-align:center;text-decoration: underline;}
            p.intro {font-weight:bold;font-size:20px;text-decoration: underline;}
            p.small {font-size:14px;text-align:center;}
            span.red {color:red;text-decoration:underline;}
        </style>
    </head>
    <body>
        
        <h1 class="heading">Step 4</h1>

<p class="intro">Review Information</p>

<p>You are almost there! Please review the information below. If everything is correct, please type in your name and click on the button at the bottom of this page!</p>

<fieldset>
    <p class="intro">Acknowledgement of Status as Guest Form</p>
        <p>You have accepted to this acknowledgement on <?php if(isset($_SESSION['fixedDate'])) {echo $_SESSION['fixedDate'];} ?></p>
</fieldset>
<br/>
<fieldset>
    <p class="intro">Guest Wellness Profile Form</p>
        You have indicated that someone in your party <?php if(isset($_SESSION['ques1'])) { if($_SESSION['ques1']==1) { echo 'DOES'; } else { echo 'DOES NOT'; }} ?> have a fever.
        <br/>You have indicated that someone in your party <?php if(isset($_SESSION['ques2'])) { if($_SESSION['ques2']==1) { echo 'DOES'; } else { echo 'DOES NOT'; }} ?> have a headache.
        <br/>You have indicated that someone in your party <?php if(isset($_SESSION['ques3'])) { if($_SESSION['ques3']==1) { echo 'DOES'; } else { echo 'DOES NOT'; }} ?> have muscle aches.
        <br/>You have indicated that someone in your party <?php if(isset($_SESSION['ques4'])) { if($_SESSION['ques4']==1) { echo 'DOES'; } else { echo 'DOES NOT'; }} ?> have tiredness & weakness.
        <br/>You have indicated that someone in your party <?php if(isset($_SESSION['ques5'])) { if($_SESSION['ques5']==1) { echo 'DOES'; } else { echo 'DOES NOT'; }} ?> have extreme exhaustion.
        <br/>You have indicated that someone in your party <?php if(isset($_SESSION['ques6'])) { if($_SESSION['ques6']==1) { echo 'DOES'; } else { echo 'DOES NOT'; }} ?> have stuffy nose & sneezing.
        <br/>You have indicated that someone in your party <?php if(isset($_SESSION['ques7'])) { if($_SESSION['ques7']==1) { echo 'DOES'; } else { echo 'DOES NOT'; }} ?> have a sore throat.
        <br/>You have indicated that someone in your party <?php if(isset($_SESSION['ques8'])) { if($_SESSION['ques8']==1) { echo 'DOES'; } else { echo 'DOES NOT'; }} ?> have a sore throat.
        <br/>You have indicated that someone in your party <?php if(isset($_SESSION['ques9'])) { if($_SESSION['ques9']==1) { echo 'HAS HAD CONTACT'; } else { echo 'HAS NOT HAD CONTACT'; }} ?> with someone that has/had the influenza, H1N1 influenza, measles, chicken pox, etc.
    <br/><a href="mailform3.php">Go Back to This Form!</a>
</fieldset>
<br/>
<fieldset>
    Image and Audio Release Agreement Form
        You have accepted to this agreement on <?php if(isset($_SESSION['fixedDate2'])) {echo $_SESSION['fixedDate2'];}?>
    <br/><a href="mailform4.php">Go Back to This Form!</a>
</fieldset>

    First and last name
    <!--requires the final submit button that calls a function to save all the
    data in the session variables to the text file. I was thinking of naming the
    text file by the familyID, which is unique.-->
    </body>
</html>