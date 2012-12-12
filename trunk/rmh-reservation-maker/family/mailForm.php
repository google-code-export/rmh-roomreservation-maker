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
        display.innerHTML=month + ' ' + date + ', ' + year + ' at ' + hour + ':' + minute + ' ' + ampm;
}
    </script>
    </head>
    <body>
<!--line 56, 80, 90-->
     
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

<h1 class="heading">Step 1</h1>


<p class="small">Please read the statement below, type in your last name, and click on the button at the bottom to continue.</p>
<p class="intro">Acknowledgement of Status as Transient / Guest</p>

<p>It is hereby acknowledged and understood that during my {our} stay at the Ronald McDonald House, my {our} status is nothing more than a guest or transient occupant of the Ronald McDonald House. I {we} am not a tenant or resident nor do I {we} make any such claim. <span class="red">I {we} understand that my reservation begins with the check in date my {our} social worker gives and ends with the date my {our} social worker gives. My {our} social worker must extend me {us} if medically needed. I {we} have made my {our} travel arrangements according to my {our} medical visits.</span> Any payments made by me {us} to the Ronald McDonald House in connection with my {our} stay here is not to be construed as rent but is merely intended to help defray the cost of the Ronald McDonald House in extending temporary quarters to me {us} occasioned by the treatment of me or a member of my {our} family at a nearby hospital. The length of my {our} stay at the Ronald McDonald House shall be determined by the Ronald McDonald House in its sole and absolute discretion and such determination shall be final and absolute. At the conclusion of my {our} stay, as determined by the Ronald McDonald House, I {we} agree to vacate the premises in accordance with the instructions issued by the Ronald McDonald House. It is expressly understood and agreed that if I {we} fail to so vacate, the Ronald McDonald House has the absolute right to remove me {us} and our possessions from the premises forthwith without resort to any legal proceedings whatsoever. I {we} agree to indemnify and hold harmless the Ronald McDonald House for any and all liability and expenses including attorneys fees, for which the Ronald McDonald House may become liable occasioned by my {our} failure to vacate when instructed to do so. I hereby agree that Management reserves the right to check all occupied rooms at any given time, to abide by the rules and regulations above, and to acknowledge my status as transient/guest.</p>

<p class="intro">Smoking/Damage Agreement</p>

<p>In addition to the above agreement, it is hereby acknowledged and understood that during my {our} stay at the Ronald McDonald House New York (“Ronald McDonald House”), smoking is prohibited in all areas of the Ronald McDonald House, including all guest rooms, hallways, and terraces. I {we} agree to inform guest or visitors about the no smoking rule and shall promptly give notice to the owner/agent about any incident of violation of the no smoking rule.</p>

This agreement is entered between the parties with the intention to mitigate the following risks:
<list>
<ul>· Smoking increases the risk of fire</ul>
<ul>· Smoking is likely to damage the premises</ul>
<ul>· Adverse health effects of Secondhand smoke</ul>
<ul>· Secondhand smoke is likely to drift from one unit to another</ul>
<ul>· The increased maintenance and cleaning costs of smoking</ul>
</list>
<p>Smoking includes inhaling, exhaling, breathing, carrying, or possession of any lighted cigarette, cigar, pipe, other product containing any amount of tobacco or other similar lighted product. <span class="red">If the above agreement is breached, I {we} agree to pay a fine of $250 US Dollars.</span> I {we} also agree to indemify the entire risk of loss with respect to any damage, destruction, loss, or theft of the Equipment and any Placed Item, whether insured or not, whether such loss is partial or complete and from any cause at all, whether or not through any default or neglect of Ronald McDonald House.</p>

<!--Some sort of agreement button and the name info here-->

<h1 class="heading">Step 2</h1>

<p class="intro">Guest Wellness Profile</p>

<p>To ensure all of guests have a sick free stay, please take a minute to answer the following questions while you check in. Please check the appropriate box if it applies to you or anyone in your party who will be staying with you during this visit to the house.

<p>Thank you!</p>

<!--Wellness fill-ins go here, as well as a submission-->

<h1 class="heading">Step 3</h1>

<p class="intro">Image and Audio Release Agreement</p>

<p>This consent form gives permission to the Ronald McDonald House New York to use the likeness, image, and audio of the undersigned to distribute and display in video, audio, web-site and printed form for promotional purposes</p>

Our intended use is:
<list><ul>In house orientation.</ul>
<ul>Inform and promote Ronald McDonald House New York to corporate and individual sponsors through in-house and public events.</ul>
<ul>Inform and promote Ronald McDonald House New York through television, cable, radio, web site and printed publications.</ul>
</list>

<p>I hereby give permission to Ronald McDonald House New York to use my likeness, image, and audio for the above stated purposes. Further, as a parent or gardian to the listed children under the age of 18 years, I extend this permission for the above stated purposes. </p>



<h1 class="heading">Step 4</h1>

<p class="intro">Review Information</p>

<p>You are almost there! Please review the information below and resolve any red text! If everything is green, please type in your name, sign your name with your finger, and click on the button at the bottom of this page!</p>

<fieldset>
    <p class="intro">Acknowledgement of Status as Guest Form</p>
        <p>You have accepted to this acknowledgement on <span id="displayDate"></span></p>
</fieldset>
<br/>
<fieldset>
    <p class="intro">Guest Wellness Profile Form</p>
        You have indicated that someone in your party <?php if(isset($_SESSION['q1'])) { if($_SESSION['q1']==1) { echo 'DOES'; } else { echo 'DOES NOT'; }} ?> have a fever.
        <br/>You have indicated that someone in your party DOES have a headache.
        <br/>You have indicated that someone in your party DOES have muscle aches.
        <br/>You have indicated that someone in your party DOES have tiredness & weakness.
        <br/>You have indicated that someone in your party DOES have extreme exhaustion.
        <br/>You have indicated that someone in your party DOES have stuffy nose & sneezing.
        <br/>You have indicated that someone in your party DOES have a sore throat.
        <br/>You have indicated that someone in your party DOES have a sore throat.
        <br/>You have indicated that someone in your party HAS HAD CONTACT with someone that has/had the influenza, H1N1 influenza, measles, chicken pox, etc.
    <br/>Go Back to This Form!
</fieldset>
<br/>
<fieldset>
    Image and Audio Release Agreement Form
        You have accepted to this agreement on <!--onload this portion for the date. Call date()-->
    <br/>Go Back to This Form!
</fieldset>

    First and last name



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
If Yes, please schedule arrangements with the Ronald McDonald House ahead of time. Thank You.
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
<?php   
  function formToText($randURL,$familyID)
{
    //stores the URL with the family ID in a text file
    //the text file is in the wamp folder
    $URLFile='../mail/URLs.txt';
    $fh = fopen($URLFile, 'a') or die("can't open file");
    $stringData=$randURL . " " . $familyID . " ";
    fwrite($fh,$stringData);
    fclose($fh);
}

?>
             
  <!--<?php
     
   // print ("Please fill out this form BEFORE arrival at the Ronald McDoanld House.");
    
   
   //echo "<a href=\"http://reservations.rmdh.org/form1.php#home" target=\"_blank\">Click here if the form does not show</a";
    ?>    
    -->
    </body> 
</html>
