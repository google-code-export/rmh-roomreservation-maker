<?php
include_once(dirname(__FILE__).'/../domain/Loaner.php');
include_once(dirname(__FILE__).'/../database/dbLoaners.php');
class testLoaner extends UnitTestCase {
    function testLoanerModule() {

        //creates a new loaner to test
        $loaner1 = new Loaner("remote3", "remote", "available", null);
                 
        //tests the getters
        $this->assertEqual($loaner1->get_id (), "remote3");
        $this->assertEqual($loaner1->get_status(), "available");
        $this->assertEqual($loaner1->get_type(), "remote");    
        $this->assertEqual($loaner1->get_booking_id(), null);
                 
        $this->assertTrue(insert_dbLoaners($loaner1));
        $this->assertTrue($loaner1 = $loaner1->check_out("11-01-01Meghan2077291234"));
                 
        //ensures that the loaner was checked out successfully
        $this->assertTrue($loaner1->get_status() == "inuse");
        $this->assertEqual($loaner1->get_booking_id(), "11-01-01Meghan2077291234");
                 
        //checks that a loaner cannot be checked out twice
        $this->assertFalse($loaner1->check_out("11-01-01Jones2077311154"));
                       
        //checks in loaner
        $loaner1 = $loaner1->check_in("11-01-01Meghan2077291234");
        $this->assertEqual($loaner1->get_status(), "available");
        $this->assertEqual($loaner1->get_booking_id(), null);
                 
//        $this->assertTrue(delete_dbLoaners($loaner1));
                 
        echo ("testLoaner complete");
    }
}

?>

