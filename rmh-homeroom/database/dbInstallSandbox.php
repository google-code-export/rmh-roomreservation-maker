<?php
/*
 * Copyright 2011 by Alex Lucyk, Jesus Navarro, and Allen Tucker.
 * This program is part of RMH Homeroom, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
/**
 * Inserts 6 persons, 2 bookings, and 5 loaners into the database as a "sandbox" to facilitate
 * testing of user interface functionality.  Run this right after dbInstall.php
 * @version April 1, 2011
 * @author Allen
 */
?>

<html>
<title>
Database Sandbox Initialization
</title>
<body>
<?php
	include_once(dirname(__FILE__).'/dbZipCodes.php');
	include_once(dirname(__FILE__).'/dbPersons.php');
	create_dbZipCodes();
	/* now add counties to the address of all Maine persons in the database
	 * 
	 */
	$every_person = getall_persons();
	$allpersons=sizeof($every_person);
	$mainepersons = $countiesadded = 0;
	foreach ($every_person as $person) {
	    if ($person->get_state()=="ME") {
	        $mainepersons +=1;
	        $countydata = false;
	        if ($person->get_zip()!="")
	            $countydata = retrieve_dbZipCodes($person->get_zip(),"");    
	        else if (!$countydata)
	            $countydata = retrieve_dbZipCodes("",$person->get_city());
	        if ($countydata) {
	            $person->set_county($countydata[3]);
	            update_dbPersons($person);
	            $countiesadded +=1;
	        }
	    }
	}
	echo $allpersons . " persons processed<br>". $mainepersons . " Maine persons processed<br>"
			. $countiesadded . " counties added\n";
	
/*	include_once(dirname(__FILE__).'/dbPersons.php');
    include_once(dirname(__FILE__).'/dbBookings.php');
	include_once(dirname(__FILE__).'/dbLoaners.php');
	
	$person = new Person("Smith", "John", "123 College Street","Brunswick", "ME", "04011", "2077291234", "", 
    	"email@bowdoin.edu", "guest","", "Willie Smith", "98-01-01", "parent" ,""); insert_dbPersons($person);
    $person = new Person("Smith", "Meghan", "3 Congress Street","Portand", "ME", "04103", 2075551234, "", 
    	"email@bowdoin.edu", "guest","", "Tiny Smith", "98-01-01", "parent", ""); insert_dbPersons($person);
    $person = new Person("Jones", "Bob", "100 Union Street","Bangor", "ME", "04401", 2075555678, null, 
    	"bjones@gmail.com", "guest","", "Dan Jones", "95-07-15", "grandfather", "" ); insert_dbPersons($person);
    $person = new Person("Adams", "Millie", "12 River Road","Augusta", "ME", "04330", 2073631234, 2075553434, 
    	"wadams@yahoo.com", "socialworker","", null, null, null, "" ); insert_dbPersons($person);
    $person = new Person("Williams", "Elizabeth", "50 Main Street","Portland", "ME", "04110", 2075555432, null, 
    	"ewilliams@comcast.net", "volunteer,guest","", null, null, null, ""); insert_dbPersons($person);

	$person = new Person("Little", "Gabrielle", "250 Brackett Street","Portland", "ME", "04102", 2077806282, 2075550000, 
    	"housemngr@rmhportland.org", "manager","", null, null, null, "" ); insert_dbPersons($person);
    $person = new Person("Lucyk", "Alex", "Bowdoin College","Brunswick", "ME", "04011", 2077806282, 2075550000, 
    	"azlucyk@gmail.com", "manager","", null, null, null, "" ); insert_dbPersons($person);
    $person = new Person("Navarro", "Jesus", "Bowdoin College","Brunswick", "ME", "04011", 2077806282, 2075550000, 
    	"jnavarro@bowdoin.edu", "manager","", null, null, null, "" ); insert_dbPersons($person);
    $person = new Person("Tucker", "Allen", "42 Walini Way","Harpswell", "ME", "04079", 2077298111, 2078419604, 
    	"allen@bowdoin.edu", "manager,guest","", null, null, null, "" ); insert_dbPersons($person);
            
    $loaner = new Loaner("remote1", "remote", "available", null); insert_dbLoaners($loaner);
    $loaner = new Loaner("remote2", "remote", "available", null); insert_dbLoaners($loaner);
    $loaner = new Loaner("fan1", "fan", "available", null); insert_dbLoaners($loaner);
    $loaner = new Loaner("fan2", "fan", "available", null); insert_dbLoaners($loaner);
    $loaner = new Loaner("airbed1", "airbed", "available", null); insert_dbLoaners($loaner);
    $loaner = new Loaner("airbed2", "airbed", "available", null); insert_dbLoaners($loaner);
   
    $b = new Booking("11-02-07",array("Meghan2075551234"),"Tiny",
              array("Meghan:mother", "Jean:father", "Teeny:sibling"),
              array("fan2", "remote1"),
              "Millie2073631234","Maine Med", "","", "10 per night", "yes", "yes", "");
    $b->add_loaner("airbed3");
	$b->add_occupant("Jordan","brother");
    $b->assign_room("223","11-05-02");
    insert_dbBookings($b);
    $b = new Booking("11-02-08",array("John2077291234"),"Willie",
              array("Sara:mother", "John:father", "Winky:sibling"),
              array(),"Millie2073631234","Maine Med", "", "","10 per night", "yes", "yes", "call back");
    insert_dbBookings($b);
    $loaner = new Loaner("remote1", "remote", "available", null); insert_dbLoaners($loaner);
    $loaner = new Loaner("remote2", "remote", "available", null); insert_dbLoaners($loaner);
    $loaner = new Loaner("fan1", "fan", "available", null); insert_dbLoaners($loaner);
    $loaner = new Loaner("fan2", "fan", "available", null); insert_dbLoaners($loaner);
    $loaner = new Loaner("airbed1", "airbed", "available", null); insert_dbLoaners($loaner);
    
    $person =  new Person("jones", "jane", "14 Way St","Harpswell","ME","04079",2077291234,"","jane@bowdoin.edu","guest","", "Aillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
    
    $person =  new Person("jones","cathy", "14 Way St","Harpswell","ME","04079","2077291234","","cathy@bowdoin.edu","guest","", "Billie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
    
    $person =  new Person("jones","don", "14 Way St","Harpswell","ME","04079","2077291234","","don@bowdoin.edu","guest","", "Cillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);

	$person =  new Person("jones","peter", "14 Way St","Harpswell","ME","04079","2077291234","","peter@bowdoin.edu","guest","", "Dillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","patricia", "14 Way St","Harpswell","ME","04079","2077291234","","patricia@bowdoin.edu","guest","", "Eillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","rob", "14 Way St","Harpswell","ME","04079","2077291234","","rob@bowdoin.edu","guest","", "Fillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","nancy", "14 Way St","Harpswell","ME","04079","2077291234","","nancy@bowdoin.edu","guest","", "Gillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","ben", "14 Way St","Harpswell","ME","04079","2077291234","","ben@bowdoin.edu","guest","", "Hillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","lynn", "14 Way St","Harpswell","ME","04079","2077291234","","lynn@bowdoin.edu","guest","", "Jillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","martie", "14 Way St","Harpswell","ME","04079","2077291234","","martie@bowdoin.edu","guest","", "Killie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","dorothy", "14 Way St","Harpswell","ME","04079","2077291234","","dorothy@bowdoin.edu","guest","", "Lillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","marguerite", "14 Way St","Harpswell","ME","04079","2077291234","","marguerite@bowdoin.edu","guest","", "Millie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","becky", "14 Way St","Harpswell","ME","04079","2077291234","","becky@bowdoin.edu","guest","", "Nillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","betsy", "14 Way St","Harpswell","ME","04079","2077291234","","betsy@bowdoin.edu","guest","", "Pillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","linda", "14 Way St","Harpswell","ME","04079","2077291234","","linda@bowdoin.edu","guest","", "Qillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","chris", "14 Way St","Harpswell","ME","04079","2077291234","","chris@bowdoin.edu","guest","", "Rillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","paula", "14 Way St","Harpswell","ME","04079","2077291234","","paula@bowdoin.edu","guest","", "Sillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
    $person =  new Person( "jones","kym","14 Way St","Harpswell","ME","04079","2077291234","","kym@bowdoin.edu","guest","", "Tillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person( "jones","jeannie","14 Way St","Harpswell","ME","04079","2077291234","","jeannie@bowdoin.edu","guest","", "Uillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","debbie", "14 Way St","Harpswell","ME","04079","2077291234","","debbie@bowdoin.edu","guest","", "Villie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
    $person =  new Person("jones","meg", "14 Way St","Harpswell","ME","04079","2077291234","","meg@bowdoin.edu","guest","", "Willie jones", "98-01-01", "parent","");
    insert_dbPersons($person);

	$person =  new Person("jones","derek", "14 Way St","Harpswell","ME","04079","2077291234","","derek@bowdoin.edu","guest","", "Yillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","sally", "14 Way St","Harpswell","ME","04079","2077291234","","sally@bowdoin.edu","guest","", "Zillie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","pat", "14 Way St","Harpswell","ME","04079","2077291234","","pat@bowdoin.edu","guest","", "Wallie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","evelyn", "14 Way St","Harpswell","ME","04079","2077291234","","evelyn@bowdoin.edu","guest","", "Wellie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
	$person =  new Person("jones","bob", "14 Way St","Harpswell","ME","04079","2077291234","","bob@bowdoin.edu","guest","", "Wollie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
    $person =  new Person( "jones","rita","14 Way St","Harpswell","ME","04079","2077291234","","rita@bowdoin.edu","guest","", "Wullie jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
    $person =  new Person("jones","beverly", "14 Way St","Harpswell","ME","04079","2077291234","","beverly@bowdoin.edu","guest","", "Willis jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
    $person =  new Person("jones","tina", "14 Way St","Harpswell","ME","04079","2077291234","","tina@bowdoin.edu","guest","", "Willit jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
    $person =  new Person("jones","deborah", "14 Way St","Harpswell","ME","04079","2077291234","","deborah@bowdoin.edu","guest","", "Willid jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
    $person =  new Person( "jones","dierdre","14 Way St","Harpswell","ME","04079","2077291234","","dierdre@bowdoin.edu","guest","", "Willig jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
    $person =  new Person( "jones","beth","14 Way St","Harpswell","ME","04079","2077291234","","beth@bowdoin.edu","guest","", "Willim jones", "98-01-01", "parent","");
    insert_dbPersons($person);
	
    $person =  new Person( "jones","paul","14 Way St","Harpswell","ME","04079","2077291234","","paul@bowdoin.edu","guest","", "Willip jones", "98-01-01", "parent","");
    insert_dbPersons($person);
*/	
        
    echo "<p>Sandbox installed</p>";
?>
</body>
</html>