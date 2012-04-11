<?php
/**
 * This file contains the report based on the data selected in the form
 */


//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Report"; //title for page

include_once('header.php'); //including the header file



if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        $showReport = true;
        $beginDate = sanitize($_POST["startYear"]."-".$_POST["startMonth"]."-".$_POST["startDay"]." 00:00:00.0");
        $endDate = sanitize($_POST["endYear"]."-".$_POST["endMonth"]."-".$_POST["endDay"]." 23:59:59.99");
        $hospital = sanitize($_POST["hospital"]);
        $userId = sanitize(getCurrentUser());
        
    }
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        $showReport = false;
    }
    else
    {
        $showReport = false;
    }
        

?>

<div id="container">

    <div id="content">
        
<?php
    if($showReport==true)
    {
        echo "<br>";
        echo "Report Requested By: ".$userId."<br>";
        echo "Start Date: ".$beginDate."<br>";
        echo "End Date: ".$endDate."<br>";
        echo "Hospital: ".$hospital."<br>";
        
        if($hospital == '')
        {
           
        }
        
        else 
        {
            
        }
    }
    else
    {
    echo "Security check failed: Go back to the form and resubmit your selections<br>";
    }
?>
        <br>
        
        

    </div>
</div>
<?php 
include ('footer.php'); //include the footer file
?>

