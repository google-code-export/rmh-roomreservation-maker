<?php

// includes Social Worker file 
include_once(dirname(__FILE__).'/../domain/SocialWorker.php');

Class Requests  {
   
    private $roomReservationActivityID;
    private $roomReservationRequestID;
    private $userLoginInfoID;
    private $familyProfileID;
    private $status;
    private $dateStatusSubmited;
    private $beginDate;
    private $endDate;
    private $note;
    
    function __constuct($roomReservationActivityID, $roomReservationRequestID, $userLoginInfoID, $familyProfileID
            $status,$dateStatusSubmited, $beginDate, $endDate, $note){
            $this->roomReservationActivityID = $roomReservationActivityID;
            $this->roomReservationRequestID = $roomReservationRequestID;
            $this->userLoginInfoID = $userLoginInfoID;
            $this->familyProfileID = $familyProfileID;
            $this->status = $status;
            $this->dateStatusSubmited = $dateStatusSubmited;
            $this->beginDate = $beginDate;
            $this->endDate = $endDate;
            $this->note = $note;
    }
    
    //getters
    function get_roomreservationActivityID(){
         return $this->roomReservationActivityID;
    }
    function get_roomReservationRequestID(){
        return $this->roomReservationRequestID;
    }
    function get_userLoginInfoID(){
        return $this->userLoginInfoID;
    }
    function get_familyProfileID(){
        return $this->familyProfileID;
    }
    function get_status(){
        return $this->status;
    }
    function get_dateStatusSubmited(){
        return $this->dateStatusSubmited;
    }
    function get_beginDate(){
        return $this->beginDate;
    }
    function get_endDate(){
        return $this->endDate;
    }
    function get_note(){
        return $this->note;
    }
    
    function cancel_request($roomReservationRequestID){ 
    /* A room needs to be canceled. 
    * SW goes to look up the room request that was made for the family.
    * SW states the reason for cancellation in the note.
    * select cancel room reservation. 
    * A new roomreservationactivity record is logged in the DB table 
    * cancellation email is sent to RMH approvers with the cancellation key
    * RMH approvers receives the key and looks up the room request to approve the cancellation. 
    */
        
        //1 - modify room request
        //2 - cancel room request
        if (selection == 2){
            $retrieve = retrieve_dbRoomRequest($roomReservationRequestID); // needs retrieve function from database group
            if ($retrieve->status == "apply-confirmed"){
                //email function ? 
                update_roomreservationactivity($this); //needs update_roomreservation function database group to log a record
                                                       //change status to "applied" 
            else 
                return false;
             
            }
            
        }
     
 } //close cancel_request
        
    }//close class Request







?>
