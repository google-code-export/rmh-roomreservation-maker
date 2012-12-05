

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



/*function formToText()

$textFile='./ / formFile.txt';
$formHandle = fopen($textFile, 'a') or else (" Destination notreachable")
$stringData=$textFile . " ");
fwrite($formHandle, $stringData);
fclose($formHandle);
?>

function urlToText($randURL,$familyID)
{
    //stores the URL with the family ID in a text file
    //the text file is in the wamp folder
    $URLFile='../mail/URLs.txt';
    $fh = fopen($URLFile, 'a') or die("can't open file");
    $stringData=$randURL . " " . $familyID . " ";
    fwrite($fh,$stringData);
    fclose($fh);
}
 * 
 */
