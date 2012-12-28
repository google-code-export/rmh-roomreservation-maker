<!DOCTYPE HTML>
<html>
    <head>
        <title>Welcome to the reservation maker</title>
    </head>
    <body>
<?php

    session_start();
    include_once ('../core/globalFunctions.php');
    include_once ('../mail/functions.php');
    include_once ('../database/dbFamilyProfile.php');

/*
 * This piece of code should get the randomly generated URL that is saved in the text file
 * (currently C:\wamp\www\rmh-reservation-maker\mail) and get the connected family profile ID.
 * The URL will be like:  registration.rmh-newyork.org/prereg.php?url=3928fFa4d
 * The only important part of the URL is the prereg.php?url=3928fFa4d, where prereg
 * is called and the url is specified
 */

if(isset($_GET["url"])) //get the url if possible. If not, set url as -1.
{
    $randURL=$_GET["url"];
}
else
{
    $randURL=-1;
}
$familyID=getFamilyIDFromURL($randURL);//grabs the family ID associated with the URL
$_SESSION['ID']=$familyID;
if($familyID==-1) //if for some reason the URL is not valid, they get taken to the index page instead.
{
    echo "We're sorry. We could not find the form for you to fill out. You should contact your social worker.<br/>";
}
 else//redirects to stephon's form for filling out
{
    header("refresh:5;url=mailForm.php");
    echo "You are being redirected to the form for you to fill out.<br/>";
    echo 'If you do not get redirected in 5 seconds, click <a href="mailForm.php">here</a>.';
}

?>
    </body>
</html>