

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

<!DOCTYPE html>
 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>FORM</title>
    </head>
    <body>
   
        <form action="formToText.php"name="Welcome to RMH" method="post" >
    First Name:<input type = "text" name = "First Name" value = "fname" size = "14" />
    <br>     
    Middle Initial<input type= "text" name= "Middle Initial" value="m" size="2" />
    <br>
    Last Name:<input type = "text" name = "Last Name" value = "lname" size = "14" />
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
    
    Please list your children name and age. <br>
    Name <input type="text" name="child1" value="first child" /> Age: <input type="text" name="age1" value="age" /><br>
    Name <input type="text" name="child2" value="second child" /> Age: <input type="text" name="age2" value="age" /><br>
    Name <input type="text" name="child3" value="third child" /> Age: <input type="text" name="age3" value="age" /><br>
    Name <input type="text" name="child4" value="fourth child" /> Age: <input type="text" name="age4" value="age" /><br>
    
    
   
    <br>
    <br> <input type="submit">
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




?>
