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

$title = "Referral Form"; //This should be the title for the page, included in the <title></title>
if ($_GET['id'] = "new") $title = "New Reservation Form"; 
include('header.php'); //including this will further include (globalFunctions.php and config.php)


/*
 * If your page includes a form, please follow the instructions below.
 * If not, this code block can be deleted
 * 
 * If the page checks for $_POST data then it is important to validate the token that is attached with the form.
 * Attaching token to a form is described below in the HTML section.
 * Include the following check:
 */
    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        //the security validation was successful, perform required operation here below.
        //*** NOTE *** The validateTokenField DOES NOT filter/sanitize/clean the data fields.
        //A separate function sanitize() should be called to clean the data so that it is html/db safe
    }
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        //if the security validation failed. display/store the error:
        //'The request could not be completed: security check failed!'

    }
    else
    {
        //there was no POST DATA
    }
        

?>

<div id="container">

    <div id="content">
        
        <!-- ALL YOUR HTML CONTENT GOES HERE -->
        
        <!-- If your page has a form please follow the coding guideline:
        Once you have your form setup, add the following php code after the form declaration:
        generateTokenField() 
        
        IMPORTANT: Make sure that generateTokenField() is always after validateTokenField in your code sequence
        
        EXAMPLE code block below (can be deleted if not using form) -->
         
        <form name ="NewReservationForm" method="post" action="NewRequestHandler.php">
            <?php echo generateTokenField(); ?>
            
       
           <h3> fill in the fields for a New Request Form </h3><br><br>
           
          <label for="BeginDate">Start Date:</label>
            <select name="BeginMonth">
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
	    <select name="BeginDay">
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
	    <select name="BeginYear">
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
           <label class="noShow non" for="PatientDiagnosis"></label><input type="text" class="formtop formt" name="PatientDiagnosis" value="Patient Diagnosis" onfocus="if(this.value == 'Patient Diagnosis') { this.value = ''; }" size="15" /><br>
          <label class="noShow non" for="Notes"></label><input type="text" name="Notes" class="formt" value="Notes" size="15" onfocus="if(this.value == 'Notes') { this.value = ''; }" /><br>
              <label class="noShow non" for="ParentLastName"></label><input type="text" class="formt" name="ParentLastName" value="First Name" onfocus="if(this.value == 'First Name') { this.value = ''; }"size="15" /><br>
          <label class="noShow non" for="ParentLastName"> Parent First Name:</label> <input type="text" class="formbottom formt" name="ParentFirstName" onfocus="if(this.value == 'Last Name') { this.value = ''; }" value="Last Name" size="15" /><br>
           
          <input class="formsubmit" type="submit" name="submit" value="submit"/>
           
           
        
        
        
        </form>
            <?php include (ROOT_DIR. '/inc/back.php'); ?>
</div>      


  
         
       
<?php     
include (ROOT_DIR.'/footer.php');
?>

