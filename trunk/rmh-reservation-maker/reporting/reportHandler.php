<?php


//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Report"; //title for page

include('../header.php'); //including the header file



if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        $showReport = true;
        $reportType = sanitize($_POST["reportType"]);
        $dateStart = sanitize($_POST["startMonth"].":".$_POST["startDay"].":".$_POST["startYear"]);
        $dateEnd = sanitize($_POST["endMonth"].":".$_POST["endDay"].":".$_POST["endYear"]);
        
    }
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        $showReport = false;
        echo "Security check failed: Go back to the form and resubmit your selections<br>";

    }
    else
    {
        //there was no POST DATA
    }
        

?>

<div id="container">

    <div id="content">
        
<?php
    if($showReport==true)
    {
        echo "<br>";
        echo "Report Type: ".$reportType."<br>";
        echo "Start Date: ".$dateStart."<br>";
        echo "End Date: ".$dateEnd."<br>";
    }
?>
        <br>
        
        

    </div>
</div>
<?php 
include ('../footer.php'); //include the footer file
?>

