<?php

include('../core/config.php');
include_once (ROOT_DIR.'/database/dbProfileActivity.php');

echo ">>>DIRECTORY: ".ROOT_DIR.'/database/dbProfileActivity.php <br><br>';
//retrieve_ProfileActivity_byStatus($profileActivityStatus)
echo "////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////"."</br>";
echo ">>>TESTING: retrieve_dbProfileActivity_byStatus, expect four Profile Activities to be found". "</br>";
test_retrieve_dbProfileActivity_byStatus("Confirmed");

echo ">>>TESTING: retrieve_dbProfileActivity_byStatus, expect no Profile Activity to be found."."</br>";
test_retrieve_dbProfileActivity_byStatus("Denied");

echo ">>>TESTING: retrieve_ProfileActivity_byFamilyProfileID, expect 1 Profile Activity to be found."."</br>";
test_retrieve_ProfileActivity_byFamilyProfileID(2);

echo ">>>TESTING: insert_dbProfileActivity, expect success</br>";

$profileActivity = new ProfileActivity(0, 1, 3, 1, "Tove", "Mary", 1, "Shen",  "Tian", "2012-01-10 18:22:43", "2012-01-12 17:22:43","Create", "Pending", 
        "Joe", "Jones", "joejones@gmail.com", "9149999999", "9148888888", "333 1st Street", "Funville", "CT", "11111", "US", "Sammy", "Jone", 
        "father", "2005-02-18 00:00:00", "","","");
test_insert_dbProfileActivity($profileActivity);


function test_retrieve_ProfileActivity_byFamilyProfileID($familyProfileID) {

    $profileactivities = retrieve_ProfileActivity_byFamilyProfileID($familyProfileID);
    
    if ($profileactivities == false)
        echo "</br>". "No Profile Activity were found"."</br>";
    else
    {
        echo "</br>"."Records Found:"."</br>";
        foreach ($profileactivities as $profileactivity)
        {
            display_profileactivity($profileactivity);
        }
    }
}

function test_retrieve_dbProfileActivity_byStatus($profileActivityStatus)
{
    $profileactivities = retrieve_ProfileActivity_byStatus($profileActivityStatus);

if ($profileactivities == false)
    echo "</br>". "No Profile Activity were  found". "</br>";
else
{
    echo  "</br>". "Records Found:".  "</br>";
    foreach ($profileactivities as $profileactivity)
    {
         display_profileactivity($profileactivity);
    }
}

}

function test_insert_dbProfileActivity($profileActivity)
{
    $retVal = insert_ProfileActivity($profileActivity);
    if ($retVal == true)
        echo "</br> Insert succeeded </br>";
    else
        echo "</br> Insert failed </br>";
    echo "Profile Activity Request ID: ".$profileActivity->get_profileActivityRequestID();
}


function display_profileactivity($profileactivity)
{
    echo " Profile Activity Request ID is: " . $profileactivity->get_profileActivityRequestId() .  "</br>";
    echo " Profile Activity ID is: " . $profileactivity->get_profileActivityId().  "</br>";
    echo " Family Profile ID is: " . $profileactivity->get_familyProfileId().  "</br>";
    echo " Social Worker Profile ID is: " . $profileactivity->get_socialWorkerProfileId() . "</br>";
    echo " Social Worker Last Name is: " . $profileactivity->get_swLastName() .  "</br>";
    echo " Social Worker First Name is: " . $profileactivity->get_swFirstName().  "</br>";
    echo " RMH Staff Profile ID is: " . $profileactivity->get_rmhStaffProfileId().  "</br>";
    echo " RMH Staff Last Name is: " . $profileactivity->get_rmhStaffLastName() . "</br>";
    
    echo " RMH Staff First Name is: " . $profileactivity->get_rmhStaffFirstName() .  "</br>";
    echo " Social Worker Date Status Submitted is: " . $profileactivity->get_swDateStatusSubm().  "</br>";
    echo " RMH Date Status Submitted is: " . $profileactivity->get_rmhDateStatusSubm().  "</br>";
    echo " Activity Type is: " . $profileactivity->get_activityType() . "</br>";
   
    echo " Profile Activity Status is: " . $profileactivity->get_profileActivityStatus() .  "</br>";
    echo " Parent First Name is: " . $profileactivity->get_parentFirstName().  "</br>";
    echo " Parent Last Name is: " . $profileactivity->get_parentLastName().  "</br>";
    echo " Parent Email is: " . $profileactivity->get_parentEmail() . "</br>";
    
    echo " Parent Phone1 is: " . $profileactivity->get_parentPhone1() .  "</br>";
    echo " Parent Phone2 is: " . $profileactivity->get_parentPhone2().  "</br>";
    echo " Parent Address is: " . $profileactivity->get_parentAddress().  "</br>";
    echo " Parent City is: " . $profileactivity->get_parentCity() . "</br>";
    
    echo " Parent State is: " . $profileactivity->get_parentState() .  "</br>";
    echo " Parent Zip is: " . $profileactivity->get_parentZip().  "</br>";
    echo " Parent Country is: " . $profileactivity->get_parentCountry().  "</br>";
    echo " Patient First Name is: " . $profileactivity->get_patientFirstName() . "</br>";
        
    echo " Patient Last Name is: " . $profileactivity->get_patientLastName() .  "</br>";
    echo " Patient Relation is: " . $profileactivity->get_patientRelation().  "</br>";
    echo " Patient Date Of Birth is: " . $profileactivity->get_patientDOB().  "</br>";
    echo " Form PDF is: " . $profileactivity->get_formPdf() . "</br>";
    echo " Family Notes is: " . $profileactivity->get_familyNotes().  "</br>";
    echo " Profile Activity Notes is: " . $profileactivity->get_profileActivityNotes() . "</br>";
    echo "////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////"."</br></br>";

}


?>