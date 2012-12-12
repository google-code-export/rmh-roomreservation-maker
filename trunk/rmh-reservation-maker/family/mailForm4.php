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
        <title>FORM</title>
        <style>
            body {font-family:sans-serif, Arial, Centaur;font-size:17px;text-align:left;}
            h1.heading {font-size:24px;font-weight:bold;text-align:center;text-decoration: underline;}
            p.intro {font-weight:bold;font-size:20px;text-decoration: underline;}
            p.small {font-size:14px;text-align:center;}
            span.red {color:red;text-decoration:underline;}
        </style>
    </head>
    <body>
        
        <h1 class="heading">Step 3</h1>

<p class="intro">Image and Audio Release Agreement</p>

<p>This consent form gives permission to the Ronald McDonald House New York to use the likeness, image, and audio of the undersigned to distribute and display in video, audio, web-site and printed form for promotional purposes</p>

Our intended use is:
<list><ul>In house orientation.</ul>
<ul>Inform and promote Ronald McDonald House New York to corporate and individual sponsors through in-house and public events.</ul>
<ul>Inform and promote Ronald McDonald House New York through television, cable, radio, web site and printed publications.</ul>
</list>

<p>I hereby give permission to Ronald McDonald House New York to use my likeness, image, and audio for the above stated purposes. Further, as a parent or gardian to the listed children under the age of 18 years, I extend this permission for the above stated purposes. </p>

<!--Requires the agreement and the form for the child data.
Session variables as always.-->


    </body>
</html>