<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form name="reportChoice" action="reportHandler.php" method="POST">
            Report Type:
		<select name="choices"">
                <option value="30day">30 Day Report</option>
                <option value="mkscc">MKSCC Report</option>
            </select>
            <br>
            <br>
            Start Date: 
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
            End Date:  
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
    </body>
</html>