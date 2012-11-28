<html>
    <head>
        <title>Welcome to the Registration Form Page</title>
        <!--remember to <include_once> stephon's file so that it works-->
        
    </head>
    

<?php
/*
 * This piece of code should get the randomly generated URL that is saved in the text file
 * (currently C:\wamp\www\rmh-reservation-maker\family) and get the connected family profile ID.
 * I would also like to clear the text file of the URL if I can so there isn't a problem with it
 * being duplicated
 * assuming the URL will be like:  registration.rmh-newyork.org/prereg.php?url=3928fFa4d
 * 
 */


randURL();//generate the url (test)

if(isset($_GET["url]"])) //get the url if possible. If not, set url as -1.
{
    $randURL=$_GET["url"];
}
else
    $randURL=-1;
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






function randURL()
{
    /*This piece of code should generate the random string to append to the URL link
    * that will go in the email. 
    * The contents of the email should contain webaddress.com/blah(append(.))rng url
    * along with a message regarding the family reservation being made.
    */ 
    $length=12; //need to set a length for the URL, currently at 12
    $characters='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //the set of characters that can be chosen, should be 52.
    $randString='';
    for ($i = 0; $i < $length; $i++) {
    //chooses one character from the entire set of available characters in characters
    //this continues until it fills up the length.
       $randString .= $characters[mt_rand(0, strlen($characters))];
    }
    urlToText($randString,123123);
    return $randString;
}

function urlToText($randURL,$familyID)
{//stores the URL with the family ID in a text file
    //the text file is in the wamp folder
    $URLFile="URLs.txt";
    $fh = fopen($URLFile, 'a') or die("can't open file");
    $stringData=$randURL . " " . $familyID . " ";
    fwrite($fh,$stringData);
    fclose($fh);
}

function getFamilyIDFromURL($randURL)
{
    //gets the family ID associated with a specific URL
    $URLFile="URLs.txt";
    $fileContents=file_get_contents($URLFile);
    $URLArray=explode(" ",$fileContents);
    foreach ($URLArray as $URLs)
    {
        if($URLs==$randURL)
        {
            return $URLArray[key($URLArray)];
        }
    }
    return -1;
}

function clearContents()
{
    //clears the entire file
    $URLFile="URLs.txt";
    $fh = fopen($URLFile, 'w') or die("can't open file");
    fclose($fh);
}

function parseURL()
{
    //grabs the part of the URL that contains the actual RNG URL
    $parts=parse_url(curPageURL(),PHP_URL_PATH);
    $piecesOfURL=explode("?S=",$parts);
    return array_slice($piecesOfURL,1,1);
}

function curPageURL()
{
    //returns the current URL for parsing in the above function
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
     $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
     $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

?>
</html>