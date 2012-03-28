<?php
Class Requests  {

    private $id;            // unique identifier of the form $date_submitted."guest_id"
    private $date_submitted;// date that the boooking information was submitted in pending form "yy-mm-dd"
    private $date_in;       // check-in date in the form "yy-mm-dd"
    private $date_out;      //check-out date in the form "yy-mm-dd"
	private $guest_id;      // id of the primary guest e.g., "John2077291234"
 	private $status;		// "pending", "active", or "closed"
  	private $room_no;	    // id of the room; null if status == "pending" or "wait-list"
	private $patient;       // name of the patient for whom this booking is made
  	private $occupants; //number of guests that the family has
    
}

function __construct ($date_submitted, $date_in, $guest_id, $status, $room_no, $patient, 
            $occupants, $date_out) {
    	$this->id = $date_submitted . $guest_id;
    	$this->date_submitted = $date_submitted;
    	$this->date_in = $date_in;
    	$this->guest_id = $guest_id;
    	$this->status = $status;
    	$this->room_no = $room_no;
    	$this->patient = $patient;
    	$this->occupants = $occupants;
    	$this->date_out = $date_out; 
    
    }







?>
