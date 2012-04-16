<?php
/*
 * Activation domain object for RMH Reservation Maker
 * @author Gergana Stoykova
 * @version April 15, 2012
 */
class Activation{
    private $activationId; //integer
    private $userProfileId; //integer
    private $activationCode; //text
    private $resetTime; //datetime
    private $resetStatus; //1 character
    
    /**
         * constructor for an Activation
         */
    
    function __construct($activationId, $userProfileId, $activationCode, $resetTime, $resetStatus){
        $this->activationId = $activationId;
        $this->userProfileId = $userProfileId;
        $this->activationCode = $activationCode;
        $this->resetTime = $resetTime;
        $this->resetStatus = $resetStatus;
    }
    
    //getters
    function get_activationId(){
        return $this->activationId;
    }
    function get_userProfileId(){
        return $this->userProfileId;
    }
    function get_activationCode(){
        return $this->activationCode;
    }
    function get_resetTime(){
        return $this->resetTime;
    }
    function get_resetStatus(){
        return $this->resetStatus;
    }
    
    
    //setters
    function set_activationId($actId){
        $this->activationId = $actId;
    }
    function set_userProfileId($userId){
        $this->userProfileId=$userId;
    }
    function set_activationCode($actCode){
        $this->activationCode = $actCode;
    }
    function set_resetTime($resTime){
        $this->resetTime = $resTime;
    }
    function set_resetStatus($resStatus){
        $this->resetStatus = $resStatus;
    }
}

?>
