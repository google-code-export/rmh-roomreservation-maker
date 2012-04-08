<?php

include_once(dirname(__FILE__).'/../domain/UserProfile.php');
include_once(dirname(__FILE__).'/../domain/Famiily.php');
class Requests  {
   
    private $roomReservationActivityID;
    private $roomReservationRequestID;
    private $socialWorkerProfileId;
    private $rmhStaffProfileId;
    private $familyProfileId;
    private $activityType;
    private $status;
    private $swDateStatusSubmitted;
    private $rmhDateStatusSubmitted;
    private $beginDate;
    private $endDate;
    private $patientDiagnosis;
    private $roomnote;
    
    function __constuct($roomReservationActivityID, $roomReservationRequestID, $socialWorkerProfileId, $rmhStaffProfileId,
            $familyProfileId,$activityType, $status, $swDateStatusSubmitted, $rmhDateStatusSubmitted, $beginDate, $endDate, 
            $patientDiagnosis, $roomnote){
            $this->roomReservationActivityID = $roomReservationActivityID;
            $this->roomReservationRequestID = $roomReservationRequestID;
            $this->socialWorkerProfileId = $socialWorkerProfileId;
            $this->rmhStaffProfileId = $rmhStaffProfileId;
            $this->familyProfileId = $familyProfileId;
            $this->activityType = $activityType;
            $this->status = $status;
            $this->swDateStatusSubmitted = $swDateStatusSubmitted;
            $this->rmhDateStatusSubmitted = $rmhDateStatusSubmitted;
            $this->beginDate = $beginDate;
            $this->endDate = $endDate;
            $this->patientDiagnosis = $patientDiagnosis;
            $this->roomnote = $roomnote;
    }
    
    //getters
    function get_roomReservationActivityID(){
         return $this->roomReservationActivityID;
    }
    function get_roomReservationRequestID(){
        return $this->roomReservationRequestID;
    }
    function get_socialWorkerProfileId(){
        return $this->socialWorkerProfileId;
    }
    function get_rmhStaffProfileId(){
        return $this->rmhStaffProfileId;
    }
    function get_familyProfileId(){
        return $this->familyProfileId;
    }
    function get_activityType(){
        return $this->activityType;
    }
    function get_status(){
        return $this->status;
    }
    function get_swDateStatusSubmitted(){
        return $this->swDateStatusSubmitted;
    }
     function get_rmhDateStatusSubmitted(){
        return $this->swdateStatusSubmitted;
    }
    function get_beginDate(){
        return $this->beginDate;
    }
    function get_endDate(){
        return $this->endDate;
    }
    function get_patientdiagnosis(){
        return $this->patientDiagnosis;
    }
    function get_roomnote(){
        return $this->roomnote;
    }
    
    
      //setters
    function set_roomReservationActivityID($roomResId){
         $this->roomReservationActivityID = $roomResId;
    }
    function set_roomReservationRequestID($roomRequestId){
        $this->roomReservationRequestID = $roomRequestId;
    }
    function set_socialWorkerProfileId($sid){
        $this->socialWorkerProfileId = $sid;
    }
    function set_rmhStaffProfileId($rid){
        $this->rmhStaffProfileId = $rid;
    }
    function set_familyProfileId($famId){
        $this->familyProfileId = $famId;
    }
    function set_activityType($actTy){
        $this->activityType = $actTy;
    }
    function set_status($stat){
        $this->status = $stat;
    }
    function set_swDateStatusSubmitted($swDateSubm){
        $this->swDateStatusSubmitted = $swDateSubm;
    }
    function set_rmhDateStatusSubmitted($rmhDateSubm){
        $this->rmhDateStatusSubmitted = $rmhDateSubm;
    }
    function set_beginDate($dateBegin){
        $this->beginDate = $dateBegin;
    }
    function set_endDate($dateEnd){
        $this->endDate = $dateEnd;
    }
    function set_patientdiagnosis($patDiagnosis){
        $this->patientDiagnosis = $patDiagnosis;
    }
    function set_roomnote($rnote){
        $this->roomnote = $rnote;
    }
    
    
  
    //is this cancel request supposed to be in the domain ? (question from Geri)
   // function cancel_request($roomReservationRequestID){ 
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
       /* if (selection == 2){
            $retrieve = retrieve_dbRoomRequest($roomReservationRequestID); // needs retrieve function from database group
            if ($retrieve->status == "apply-confirmed"){
                //email function ? 
                update_roomreservationactivity($this); //needs update_roomreservation function database group to log a record
                                                       //change status to "applied" 
            }
            else 
                return false;
               
        }
   
     
 } //close cancel_request*/
 //
 
        
    }//close class Request
?>
