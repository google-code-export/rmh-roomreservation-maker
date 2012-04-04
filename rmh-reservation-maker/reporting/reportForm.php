
<?php
/**
 * This is a template for people who would want to create an interface for user interaction. The sequence of code blocks is important
 * because session handling requires proper sequence. Also the inclusion of header file is important. 
 * 
 * When you are creating a new file based on this template, make sure to add your page's permission requirement to the header.php file
 * example: $permission_array['template.php']=3;
 * where template.php is your file
 *         3 is the permission level required to access your page. this can be 0 through 3, where 0 is all, and 3 is admin
 * 
 * Detail explanation for each code
 * block has been provided for each section below:
 */

//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Report Generation"; 

include('../header.php'); //including this will further include (globalFunctions.php and config.php)

/*
 * If your page includes a form, please follow the instructions below.
 * If not, this code block can be deleted
 * 
 * If the page checks for $_POST data then it is important to validate the token that is attached with the form.
 * Attaching token to a form is described below in the HTML section.
 * Include the following check:
 */
   
$error = array(); //variable that sstores all the errors that occur in the login process
//if data is submitted then do the following:
//check for user and add session variables
//This check should be replaced by the tokenValidator function
if(isset($_POST['form_token']) && validateTokenField($_POST))
{

    //sanitize all these data before they get to the database !! IMPORTANT

    $db_pass = getHashValue($_POST['password']);
    $db_id = sanitize($_POST['username']);

    if($db_pass == getHashValue('test') && $db_id == 'test')
    {
        $_SESSION['logged_in'] = true;
        $_SESSION['access_level'] = 3; //0-3
        $_SESSION['id'] = $db_id;

        echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
        exit();
    }
    else
    {
        $error['invalid_username'] = "The username or password provided does not match";
    }

    
}
else if(isset($_POST['form_token']) && !validateTokenField($_POST))
{
    //if data was posted but the token was invalid then add it to the error array
    $error['csrf'] = 'The request could not be completed: security check failed!';
}
else
{
    //if no data was submitted then display the login form:

    if(($_SERVER['PHP_SELF']) == "/logout.php")
    {
        //prevents infinite loop of logging in to the page which logs you out...
        echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
    }
}
?>

<div id="container">
    <div id="content">
        <?PHP
        if(!empty($error))
        {
            echo '<div style="color:#f00;">';
            echo implode('<br />', $error);
            echo '</div>';
        }
        ?>

<div id="container">

    <div id="content">
        
        <!-- REPORTING FORM -->
        
        <br><br>
        <form name="reportChoice" action="reportHandler.php" method="POST">
            <?php echo generateTokenField(); ?>
            <label for="reportType">Report Type:</label>
		<select name="reportType"">
                <option value="30day">30 Day Report</option>
                <option value="mkscc">MKSCC Report</option>
            </select>
            <br>
            <br>
            <label for="startDate">Start Date:</label>
            <select name="startMonth">
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
	    <select name="startDay">
		<option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
	    </select>
	    <select name="startYear">
		<option value="2000">2000</option>
                <option value="2001">2001</option>
		<option value="2002">2002</option>
                <option value="2003">2003</option>
		<option value="2004">2004</option>
                <option value="2005">2005</option>
		<option value="2006">2006</option>
                <option value="2007">2007</option>
		<option value="2008">2008</option>
                <option value="2009">2009</option>
		<option value="2010">2010</option>
                <option value="2011">2011</option>
		<option value="2012">2012</option>
                <option value="2013">2013</option>
	    </select>
		
            <br><br>
            <label for="endDate">End Date:</label> 
            <select name="endMonth">
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
	    <select name="endDay">
		<option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
	    </select>
	    <select name="endYear">
		<option value="2000">2000</option>
                <option value="2001">2001</option>
		<option value="2002">2002</option>
                <option value="2003">2003</option>
		<option value="2004">2004</option>
                <option value="2005">2005</option>
		<option value="2006">2006</option>
                <option value="2007">2007</option>
		<option value="2008">2008</option>
                <option value="2009">2009</option>
		<option value="2010">2010</option>
                <option value="2011">2011</option>
		<option value="2012">2012</option>
                <option value="2013">2013</option>
	    </select>
            
            
            <input type="submit" value="Choose" name="choose" />
        </form>
       

    </div>
</div>
<?php 
include ('../footer.php'); // this contains the proper </body> and </html> ending tag.
?>

