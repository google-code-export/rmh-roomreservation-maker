<?php
include_once('../mail/functions.php'); 


//This won't work because you need to use forward slashes not back slashes.
//include_once('..\mail\functionsWithPEAR.php');  

//Doesn't work because these parameters no longer match the function header
//newRequest(100,'2012-12-12','2012-12-22');
//newRequest($RequestKey, $DateSubmitted, $BeginDate, $EndDate)
//newRequest(100,'2012-12-12','2012-12-22','2012-12-30');

echo"TESTING VARDUMP<br>";

for ( $i=0;$i<=8;$i++){
    echo"testing $i";
vardumping($i);
}



echo "<p>testing email, expect email attempt to be successful<p>";
email('david.elias09@stjohns.edu', 'sub Request', 'mess');//to me

echo "testing ConfirmCancel, expect one SW to be emailed with patient name included<p>";
ConfirmCancel(2,2,2, '2/2', '3/2');

echo "<p>testing ModifyDeny, expect one SW to be emailed with patient name included<p>";
ModifyDeny(2,2,2, '2/2', '3/2');

echo "<p>testing ModifyAccept, expect one SW to be emailed with patient name included<p>";
ModifyAccept(2,2,2, '2/2', '3/2');

echo "<p>testing PasswordReset, expect one user to be emailed<p>";
PasswordReset('567yfghj', 'anna123', "david.elias09@stjohns.edu");
        
echo "<p>testing NewFamilyProfile, expect an array of users to be emailed<p>";
NewFamilyProfile(345);


echo"<p>testing Confirm<p>";
Confirm(7, '3/3','3/4',2,2);

echo "<p>Testing RequestAccept<p>";
RequestAccept(7,'3/2', '3/3', 2, 2);


echo"<p>Testing RequesDeny<p>";
RequestDeny(7,'3/2', '3/3', 2, 2);

echo"testing FamilyModConfirm<p>";
FamilyModConfirm(7, 2, 2);

echo"<p>Testing FamilyModAccept<p>";
FamilyModAccept(7, 2, 2);

echo"<p>testing FamilyModDeny<p>";
FamilyModDeny(7,2,2);

echo"<p>Testing newRequest<p>";
newRequest(123, '3/1', '3/2', '3/3');

echo"<p>Testing NewReservationMod<p>";
newReservationMod(1234, '3/1', 2);

echo"<p>Testing NewCancel<p>";
newCancel(1321321321, '3/1', 2);

echo"<p>Testing newFamilyMod</br>";
newFamilyMod(1321321321, '3/1', 2);

echo"<p>testing family confirm<p>";
 FamilyConfirm(2,'3/1','3/2','nsdjasdjad');













//Testing Mail to STjohns Email
echo"<p> Testing  ST johns Email</br>";

 
$to = 'david.elias09@stjohns.edu'; //valid destination email address
$subject = 'testing php mail function windows';
$message = 'This is a test email, I am testing the php mail function';
 
$mailed = mail($to, $subject, $message);
 
if($mailed)
{
    echo 'The email was sent (Stjohns).</br>';
}
else
{
    echo 'The email could not be sent, please try again (Stjohns)';
}


echo"<p> Testing  Gmail Email</br>";

 
$to = 'david.elias097@gmail.com'; //valid destination email address
$subject = 'testing php mail function windows';
$message = 'This is a test email, I am testing the php mail function';
 
$mailed = mail($to, $subject, $message);
 
if($mailed)
{
    echo 'The email was sent (gmail).</br>';
}
else
{
    echo 'The email could not be sent, please try again (Stjohns)';
}


echo"<p>Testing RandURL<p>";
$string1=randURL(2);
echo"$string1";
error_reporting(E_ALL);

?>
