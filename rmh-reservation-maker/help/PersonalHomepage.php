<?PHP
/*
 * Brian Harrison Charles Holenstein
 */
session_start();
session_cache_expire(30);
$title = 'Personal Homepage';
include ('../header.php');
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Information about Your Personal Home page</title>
    </head>
    <body>
        <div align="center"><p><strong>Information about Your Personal Home Page</strong><BR>
        
<p>Whenever you log into the RMH Reservation Maker, some useful information will appear.
	<p> <B>If you are a volunteer, a social worker, or a manager</B> and
	you've never changed your password, you will see the following display: <BR><BR>
		
   <br> You may change your password by entering it and then entering your new password twice.  After you
   change your password in this way, it will be known only to you.  If you forget your password, please contact
   the house manager.  Until you change your password, this display continue to appear here.
   <p> <B>If you are a volunteer or a manager</B>,
   you will see the current day's room log, which looks like this:
<
<p> <B>If you are a social worker or a manager</B>,
   you will see the current day's room log, which looks like this:
<
<p> <B>If you are a manager</B>,
you will also see the following current information displayed:
<p> A log of the most recent schedule changes, which looks like this:
		 
		 <br> If you select <b>View full log</b> you will see a full listing of all schedule changes, like this:

		 <br>  This full log allows you to delete some or all of its entries, once they are no longer useful.
<p> A list of upcoming birthdays and volunteer anniversaries, which looks like this:
		 
<p> A list of upcoming calendar vacancies, which looks like this:
		
		 <br> Selecting any of the vacancies in this list takes you directly to that shift on the calendar, so that you can
		 examine its sub call list or other details.
<p> A list of all open applications, which looks like this:
		
		 <br> An "open" application signifies an applicant whose status has not yet been changed to "active".  Only "active"
		 volunteers can be scheduled for a shift.
        
    </body>
</html>
<?PHP include('../footer.php'); ?>

