<!DOCTYPE html>

<?php 
//connects to the session to retrieve the family profile ID
//also connects to the database to retrieve user information.
session_start();
include_once ('../core/globalFunctions.php');
include_once (ROOT_DIR.'/database/dbFamilyProfile.php');
$familyID = $_SESSION['ID'];
$family = retrieve_FamilyProfile($familyID);
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>FORM</title>
        <style>
            body {font-family:sans-serif, Arial, Centaur;font-size:17px;text-align:left;}
            h1.heading {font-size:24px;font-weight:bold;text-align:center;text-decoration: underline;}
            p.intro {font-weight:bold;font-size:20px;text-decoration: underline;}
            p.small {font-size:14px;text-align:center;}
            span.red {color:red;text-decoration:underline;}
        </style>
        
        <script type="text/javascript">
        function date()
{
	var today=new Date();
        var month=today.getMonth();
        var date=today.getDate();
        var year=today.getFullYear();
        var hour=today.getHours();
        var ampm="am";
        if(hour>12)
            {
            hour=hour-12;
            ampm="pm";
            }
        var minute=today.getMinutes();
        var display=document.getElementsByID("displayDate");
        var fixedDate=month + ' ' + date + ', ' + year + ' at ' + hour + ':' + minute + ' ' + ampm;
        return fixedDate;
}
    </script>
    </head>
    <body>
     
        <h1 class=heading>Introduction</h1>
<br/>
<p>We know that you are eager to get settled, but we have a few things to take care so that we can make everyone's stay enjoyable!</p>

<p class="intro">Check-in Notes</p>

<p>During the check-in process, you will receive a tour of the house, an electronic card key for your room, and keys to the kitchen cabinet as well as the mailbox. NOTE: We require a security deposit of $35.00.</p>

<p>We know that some of you are not from an English speaking country, so we have a phone translator service for those who require communication to our staff in other than English! Please request this at your check-in!</p>

<p>Today, we will be taking a photo for your key. We ask you to keep your key with you at all times while you are at the house as it will serve as an identification card to ensure everyone's safety.</p>

<p class="intro">Check-out Notes</p>

<p>Check-out is at 2:00 PM! If you fail to check-out by this time, you will be responsible for payment of that day's stay. Please also note that the deposit will be kept if the room and kitchen is not returned to its original condition.</p>

<p>Let's get started! We have three forms for you to fill out and sign:</p>

<list>
<ul>Acknowledgement Forms</ul>
<ul>Guest Wellness Profile Form</ul>
<ul>Image and Audio Release Agreement Form</ul>
</list>
        
<p>You may have additional forms to fill out. The person assisting you during your check-in will let you know based on your needs.</p>

<!--needs some sort of agreement acceptance button or something-->
<!--Call the function date() and save the returned string to a session variable
So like: $_SESSION['fixedDate']=date();-->




        <form action="formToText.php" name="Welcome to RMH" method="post" >
            <!--The php portion of the form fills in the text boxes with information if available-->
    First Name:<input type = "text" name = "First Name" value = "<?php if(isset($family)){ echo $family->get_patientfname(); }else echo 'fname';?>" size = "14" />
    <br>     
    Middle Initial<input type= "text" name= "Middle Initial" value="m" size="2" />
    <br>
    Last Name:<input type = "text" name = "Last Name" value = "<?php if(isset($family)){ echo $family->get_patientlname(); }else echo 'fname';?>" size = "14" />
    <br> <br>
    
    
    #1. Does anyone with you have any fevers, headaches? <select name="ques1" >
        <option>No</option>
        <option>Yes</option>
    </select> <br> <br>
    #2. Do you or anyone in your party currently have a headache? <select name="ques2" >
        <option>No</option>
        <option>Yes</option>
    </select> <br> <br>
   #3. Do you or anyone in your party currently have muscle aches? <select name="ques3" >
        <option>No</option>
        <option>Yes</option>
    </select> <br> <br>
    #4. Do you or anyone in your party currently have tiredness & weakness? <select name="ques4" >
        <option>No</option>
        <option>Yes</option>
    </select> <br> <br>
   #5. Do you or anyone in your party currently have extreme exhaustion? <select name="ques5" >
        <option>No</option>
        <option>Yes</option>
    </select> <br> <br>
    #6. Do you or anyone in your party currently have stuffy nose & sneezing? <select name="ques6" >
        <option>No</option>
        <option>Yes</option>
    </select> <br> <br>
    #7. Do you or anyone in your party currently have a sore throat? <select name="ques7" >
        <option>No</option>
        <option>Yes</option>
    </select> <br> <br>
    #8.  Do you or anyone in your party currently have a cough? <select name="ques8" >
        <option>No</option>
        <option>Yes</option>
    </select> <br> <br>
    #9. Do you or anyone in your party had recent contact with anyone that has/had influenza, H1N1 influenza, measles, chicken pox, etc? 
    <select name="ques9" >
        <option>No</option>
        <option>Yes</option>
    </select> <br> <br> 
    
A) Will you need transportation from a local airport, rail or bus terminal? 
If Yes, please schedule arrangements with the Ronald McDonald House ahead of time. Thank You!
    <select name="quesA" >
        <option>No</option>
        <option>Yes</option>
    </select> <br> <br> 
    

    
    Please list your children name and age. <br>
    Name <input type="text" name="child1" value="first child" /> Age: <input type="text" name="age1" value="age" /><br>
    Name <input type="text" name="child2" value="second child" /> Age: <input type="text" name="age2" value="age" /><br>
    Name <input type="text" name="child3" value="third child" /> Age: <input type="text" name="age3" value="age" /><br>
    Name <input type="text" name="child4" value="fourth child" /> Age: <input type="text" name="age4" value="age" /><br>
    
    
   
    <br/>
    <br/> <input type="submit" value="Submit">
       </form>

             
  <!--<?php
     
   // print ("Please fill out this form BEFORE arrival at the Ronald McDoanld House.");
    
   
   //echo "<a href=\"http://reservations.rmdh.org/form1.php#home" target=\"_blank\">Click here if the form does not show</a";
    ?>    
    -->
    </body> 
</html>
