<?php

 include('../core/config.php');
include_once (ROOT_DIR.'/database/dbFamilyProfile.php');

echo ROOT_DIR.'/database/dbFamilyProfile.php';
echo "</br> testing retrieve_dbFamilyProfileByName, expect one family to be found";
test_retrieve_dbFamilyProfileByName("Scott", "Miller");

echo "</br> testing retrieve_dbFamilyProfileByName, expect no families to be found";
test_retrieve_dbFamilyProfileByName("Joe", "Miller");

echo "</br> testing retrieve_dbFamilyProfileByStatus, expect 2 familes to be found";
test_retrieve_dbFamilyProfileByStatus("Permanent");

echo "</br> testing retrieve_dbFamilyProfileByStatus, expect 0 familes to be found";
test_retrieve_dbFamilyProfileByStatus("");

echo "</br> testing retrieve_dbFamilyProfileByStatus, expect 1 familes to be found";
test_retrieve_dbFamilyProfileByStatus("Pending");

function test_retrieve_dbFamilyProfileByName($fname, $lname)
{
    $families = retrieve_FamilyProfileByName($fname, $lname);

if ($families == false)
    echo "</br>". "No families were  found";
else
{
    echo  "</br>". "found  records".  "</br>";
    foreach ($families as $family)
    {
         display_family($family);
    }
}
}

function test_retrieve_dbFamilyProfileByStatus($familyProfileStatus)
{
    $families = retrieve_FamilyProfileByStatus($familyProfileStatus);
    
if ($families == false)
    echo "</br>". "No families were  found";
else
{
    echo  "</br>". "found  records".  "</br>";
    foreach ($families as $family)
    {
         echo "</br>";
         display_family($family);
    }
}    
}

function display_family($family)
{
    echo "id is " . $family->get_familyProfileId() .  "</br>";
    echo "status is " . $family->get_familyProfileStatus() . "</br>";
    echo " lname is " . $family->get_parentlname().  "</br>";
    echo " fname is " . $family->get_parentfname().  "</br>";
    echo " patient first name is " . $family->get_patientfname() . "</br>";
    echo "patient last name  is " . $family->get_patientlname() .  "</br>";
    echo " parent email  is " . $family->get_parentemail().  "</br>";
    echo " parent phone1 is " . $family->get_parentphone1().  "</br>";
    echo " patient phone2 is " . $family->get_parentphone2() . "</br>";
}
?>
