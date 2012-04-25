<?php
include_once('../mail/functions.php');    
//Doesn't work
//newRequest(100,'2012-12-12','2012-12-22');

echo "testing ConfirmCancel, expect one SW to be emailed with patient name included<p>";
ConfirmCancel(2,2,2, '2/2', '3/2');

echo "<p>testing ModifyDeny, expect one SW to be emailed with patient name included<p>";
ModifyDeny(2,2,2, '2/2', '3/2');

echo "<p>testing email, expect email attempt to be successful<p>";
email('alisa.modeste08@stjohns.edu', 'sub Request', 'mess');

echo "<p>testing ModifyAccept, expect one SW to be emailed with patient name included<p>";
ModifyAccept(2,2,2, '2/2', '3/2');
?>
