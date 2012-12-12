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
    </head>
    <body>
        
        <h1 class="heading">Step 1</h1>


<p class="small">Please read the statement below, and click on the button at the bottom to continue.</p>
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

<!--Some sort of agreement button-->


    </body> 
</html>