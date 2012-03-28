<?php
/*
 * Copyright 2011 by Alex Lucyk, Jesus Navarro, and Allen Tucker.
 * This program is part of RMH Homeroom, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

/*
 * Loaner class for RMH Homeroom.
 * @author Allen
 * @version February 15, 2011
 */
include_once(dirname(__FILE__).'/../database/dbLoaners.php');

class Loaner {
    private $id;          // uniquely identifies this loaner, like "remote1"
    private $type;        // String: "remote", "fan", or "airbed"
    private $status;      // "available", "inuse", or "lost"
    private $booking_id;  // if status == "inuse", link to a particular booking, otherwise null

/*
 * default constructor.  Initializes all features
 */
    function __construct($id, $type, $status, $booking_id) {
        $this->id = $id;
        $this->type = $type;
        $this->status = $status;
        $this->booking_id = $booking_id;
    }
    /*
	 * getters
	 */
    function get_id () {
        return $this->id;
    }
    function get_type () {
        return $this->type;
    }
    function get_status () {
        return $this->status;
    }
    function get_booking_id () {
        return $this->booking_id;
    }
    /*
     * check out the loaner to a particular booking
     */
    function check_out ($booking_id) { 
        $l = retrieve_dbLoaners($this->id);
        if ($l && $l->status == "available") {
            $l->status = "inuse";
            $l->booking_id = $booking_id;
            update_dbLoaners($l);
            return $l;
        }
        else return false;  // can't check out if not available
    }
    /*
     * check in the loaner from a particular booking
     */
    function check_in ($booking_id) {
        $l = retrieve_dbLoaners($this->id);
        if ($l && $l->status == "inuse") {
            $l->status = "available";
            $l->booking_id = null;
            update_dbLoaners($l);
            return $l;
        }
        else return false;  // can't check in if not in use
    }
    // use this only for changing status to "lost" or "available" 
	// when there's no booking involved
    function set_status ($status) {
        $this->status = $status;
    }
}
