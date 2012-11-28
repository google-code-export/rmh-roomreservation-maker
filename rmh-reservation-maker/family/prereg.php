<?php
    include_once ('../mail/functions.php');
/*
 * This piece of code should get the randomly generated URL that is saved in the text file
 * (currently C:\wamp\www\rmh-reservation-maker\family) and get the connected family profile ID.
 * I would also like to clear the text file of the URL if I can so there isn't a problem with it
 * being duplicated
 * assuming the URL will be like:  registration.rmh-newyork.org/prereg.php?url=3928fFa4d
 * 
 */

if(isset($_GET["url]"])) //get the url if possible. If not, set url as -1.
{
    $randURL=$_GET["url"];
}
else
{
    $randURL=-1;
}
$familyID=getFamilyIDFromURL($randURL);
//currently does not work, but assume that it works and that it returns the family
//ID that was matched to the randomly generated URL
if($familyID==-1)
{
    header( "refresh:10;url=index.php" );
    echo "We're sorry. We could not find the form for you to fill out.<br/>";
    echo 'You\'ll be redirected in about 10 secs. If not, click <a href="../index.php">here</a>.'; 
}
//load stephon's form
//fill the form using retrieve_FamilyProfile($FamilyProfileID)->get_parentlname(), etc.




?>