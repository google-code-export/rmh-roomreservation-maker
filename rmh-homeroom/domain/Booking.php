<?php
/*
 * Copyright 2011 by Alex Lucyk, Jesus Navarro, and Allen Tucker.
 * This program is part of RMH Homeroom, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

/*
 * Booking class for RMH Homeroom.  A Booking is a connection between a Room and a Person
 * on a particular date.
 * @author Allen
 * @version Fabruary 7, 2011
 */
include_once(dirname(__FILE__).'/Loaner.php');
include_once(dirname(__FILE__).'/Room.php');
include_once(dirname(__FILE__).'/../database/dbBookings.php');
include_once(dirname(__FILE__).'/../database/dbPersons.php');

class Booking {
    private $id;            // unique identifier of the form $date_submitted."guest_id"
    private $date_submitted;// date that the boooking information was submitted in pending form "yy-mm-dd"
    private $date_in;       // check-in date in the form "yy-mm-dd"
	private $guest_id;      // id of the primary guest e.g., "John2077291234"
 	private $status;		// "pending", "active", or "closed"
  	private $room_no;	    // id of the room; null if status == "pending" or "wait-list"
	private $patient;       // name of the patient for whom this booking is made
  	private $occupants;     // array of people staying in the room.  
  	                        // Each entry has the form $first_name: $relationship_to_patient
  	                        // e.g., array("John:father", "Jean:mother", "Teeny:sibling")
  	private $loaners;       // array of loaner id's, like "remote3" or "fan2"
	private $linked_room;   // (optional) id of a room where other family members are staying
 	private $date_out;      // check-out date "yy-mm-dd" ; null if unknown
    private $referred_by;   // id of the person (eg, social worker) requesting this booking
	private $hospital;      // name of the hospital where the patient is staying
    private $department;    // (optional) department where the treatment occurs
    private $health_questions; // 11 health_questions for the family ("00000000000" means no problems)
    /* 
     * Do you:
     * 1.  Currently experience flu-like symptoms?
     * 2.  Have active shingles?
     * 3.  Have active TB?
     * 4.  Have active conjunctivitis, impetigo, or strep throat?
     * 5.  Have active scabies, head lice, or body lice?
     * 6. Have whooping cough?
     * Have you:
     * 7.  Been exposed to measles in the last 18 days?
     * 8.  Elected not to be immunized against measles?
     * 9.  Had or been exposed to chicken pox in the last 21 days?
     * 10. Been vaccinated against chicken pox in the last 21 days?
     * Do any of the children:
     * 11. Carry the hepatitis B virus? 
     */
	private $payment;       // the paymant arrangement for this booking, typically $10/night
	private $overnight;     // marks approval for overnight use (yes/no)
	private $day;           // marks approval for day use (yes/no)
    private $mgr_notes;		// (optional) notes from the manager/social worker
	private $flag;        // to mark whether this booking has been viewed since submission
	                        
    /*
     * construct a new Booking
     */
    function __construct ($date_submitted, $date_in, $guest_id, $status, $room_no, $patient, 
            $occupants, $loaners, $linked_room, $date_out, $referred_by, 
            $hospital, $department, $health_questions, $payment, $overnight, $day, $mgr_notes, $flag) {
    	$this->id = $date_submitted . $guest_id;
    	$this->date_submitted = $date_submitted;
    	$this->date_in = $date_in;
    	$this->guest_id = $guest_id;
    	$this->status = $status;
    	$this->room_no = $room_no;
    	$this->patient = $patient;
    	$this->occupants = $occupants;
    	$this->loaners = $loaners;
    	$this->linked_room = $linked_room;
    	$this->date_out = $date_out; 
    	$this->referred_by = $referred_by;
    	$this->hospital = $hospital;
    	$this->department = $department;
    	$this->health_questions = $health_questions;
    	$this->payment = $payment;
    	$this->overnight = $overnight;
    	$this->day = $day;
    	$this->mgr_notes = $mgr_notes;
    	$this->flag = $flag;
    }
    /* 
     * getters
     */
    function get_id() {
        return $this->id;
    }
    function get_date_submitted() {
        return $this->date_submitted;
    }
    function get_date_in() {
        return $this->date_in;
    }
    function get_guest_id() {
        return $this->guest_id;
    }
    function get_status () {
    	return $this->status;
    }
    function get_room_no() {
        return $this->room_no;
    }
    function get_patient() {
        return $this->patient;
    }
    function get_occupants() {
        return $this->occupants;
    }
    function get_loaners () {
		return $this->loaners;
	}
	function get_linked_room() {
        return $this->linked_room;
    }
    function get_date_out() {
        return $this->date_out;
    }
    function get_referred_by() {
        return $this->referred_by;
    }
    function get_hospital() {
        return $this->hospital;
    }
    function get_department() {
        return $this->department;
    }
    function get_payment_arrangement() {
        return $this->payment;
    }
    function get_health_questions() {
        return $this->health_questions;
    }
    function get_health_question($i) { // $i indexes questions 1-11
    	return substr($this->health_questions,$i-1,1);
    }
    function get_mgr_notes() {
        return $this->mgr_notes;
    }
    function get_flag(){
        return $this->flag;
    }
    function overnight_use(){
        return $this->overnight;
    }
    function day_use(){
        return $this->day;
    }
    /*
     *  assign a room to a booking after client has confirmed
     */
    function assign_room ($room_no, $date) {
    	$r = retrieve_dbRooms($room_no);
        if ($r && $r->book_me($this->id)) {  
            $this->room_no = $room_no;
            $this->date_in = $date;	
            $this->status = "active";
            update_dbBookings($this);
            return $this;
        }
        else return false;
    }
    /*
     *  check a client out of the room and update the client's record.
     */
    function check_out ($date){
        $r = retrieve_dbRooms($this->room_no);
        $p = retrieve_dbPersons(substr($this->id,8));
        if ($r && $r->unbook_me($this->id)) {  
            $this->status = "closed";
            $this->date_out = $date;   
            update_dbBookings($this);
            if ($p) {
            	$p->add_prior_booking($this->id);
            	update_dbPersons($p);
            }
            return $this;
        }
        else return false;
    }
    function add_occupant($name, $relationship) {
    	$this->occupants[] = $name . ": " . $relationship;
    	update_dbBookings($this);
    }
    function remove_occupant($name) {
    	for ($i=0; $i<sizeof($this->occupants); $i++)
    	    if (strpos($this->occupants[$i],$name.":")!==false) {
    	        unset($this->occupants[$i]);
    	        return;
    	    }
    }
    function remove_occupants() {
        $this->occupants = array();
    }
    function add_patient($name) {
    	$this->patient = $name;
    	update_dbBookings($this);
    }
    function add_linked_room($room_no) {
    	$this->linked_room = $room_no;
    	update_dbBookings($this);
    }
    function add_loaner ($loaner_id) {
        $l = new Loaner ($loaner_id, null, null, null);
        if ($l->check_out($this->id)) {  
            $this->loaners[] = $loaner_id;
            update_dbBookings($this);
            return true;
        }
        else return false;
    }
    function remove_loaner ($loaner_id) {
        $l = new Loaner ($loaner_id, null, null, null);
        if ($l->check_in($this->id)) {  
            for ($i=0; $i<sizeof($this->loaners); $i++)
    	        if ($this->loaners[$i]==$loaner_id) {
    	            unset($this->loaners[$i]);
    	            update_dbBookings($this);
    	            return true;
    	        }
        }
    	return false;
    }
    function set_status($status) {
        $this->status = $status;
    }
    function set_room_no($room_no) {
        $this->room_no = $room_no;
    }
    function set_linked_room($linked_room) {
        $this->linked_room = $linked_room;
    }
    function set_date_in ($new_date_in) {
    	$this->date_in = $new_date_in;
    }
    function set_date_out($date_out) {
        $this->date_out = $date_out;
    }
    function set_referred_by($referred_by){
        $this->referred_by = $referred_by;
    }
    function set_hospital($hospital){
        $this->hospital = $hospital;
    }
    function set_department($department) {
        $this->department = $department;
    }
    function set_payment_arrangement($payment) {
        $this->payment = $payment;
    }
    function set_health_questions($health_questions) {
        $this->health_questions = $health_questions;
    }
    function set_health_question($i, $value) { // $i indexes questions 1-11
    	$x = $this->health_questions;
    	$this->health_questions = substr($x,0,$i-2).$value.substr($x,$i);
    }
    function set_mgr_notes($mgr_notes) {
        $this->mgr_notes = $mgr_notes;
    }
    function set_flag($f){
        $this->flag = $f;
    }
    function set_overnight_use($u){
        $this->overnight = $u;
    }
    function set_day_use($u){
        $this->day = $u;    
    }

}
?>
