<?php


//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Report"; //title for page

include('../header.php'); //including the header file
?>

<div id="container">

    <div id="content">
        
<?php
        $reportType = $_POST["reportType"];
        $dateStart = $_POST["startMonth"].":".$_POST["startDay"].":".$_POST["startYear"];
        $dateEnd = $_POST["endMonth"].":".$_POST["endDay"].":".$_POST["endYear"];

        echo "Report Type: ".$reportType."<br>";
        echo "Start Date: ".$dateStart."<br>";
        echo "End Date: ".$dateEnd."<br>";
?>
        <br>
        
        

    </div>
</div>
<?php 
include ('../footer.php'); //include the footer file
?>

