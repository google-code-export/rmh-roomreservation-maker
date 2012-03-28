<?php
include_once(dirname(__FILE__).'/../domain/Loaner.php');
include_once(dirname(__FILE__).'/../database/dbLoaners.php');
class testdbLoaners extends UnitTestCase {
    function testdbLoanersModule() {
        
        //creates some loaners to add to the database
        $loaner1 = new Loaner("remote3", "remote", "available", null);
        $loaner2 = new Loaner("remote4", "remote", "available", null);
        
        // tests the insert function
        $this->assertTrue(insert_dbLoaners($loaner1));
        $this->assertTrue(insert_dbLoaners($loaner2));
                 
        //tests the retrieve function
        $this->assertEqual(retrieve_dbLoaners($loaner1->get_id())->get_id (), "remote3");
        $this->assertEqual(retrieve_dbLoaners($loaner1->get_id())->get_type (), "remote");
        $this->assertEqual(retrieve_dbLoaners($loaner1->get_id())->get_status (), "available");    
        $this->assertEqual(retrieve_dbLoaners($loaner1->get_id())->get_booking_id (), null);
                 
        //tests the update function
        $loaner1->check_out("11-02-07Meghan2077291234");
        $this->assertEqual(retrieve_dbLoaners($loaner1->get_id())->get_status (), "inuse");    
        $this->assertEqual(retrieve_dbLoaners($loaner1->get_id())->get_booking_id (), "11-02-07Meghan2077291234");
                 
        //tests the delete function
        $this->assertTrue(delete_dbLoaners($loaner1->get_id()));
        $this->assertTrue(delete_dbLoaners($loaner2->get_id()));
        $this->assertFalse(retrieve_dbLoaners($loaner2->get_id()));
                 
        echo ("testdbLoaners complete");
    }
}

?>

