<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once(dirname(__FILE__).'/../domain/Family.php');
include_once(dirname(__FILE__).'/../domain/UserProfile.php');
class ProfileChange {
    private $profileChangeId;
    private $profileChangeRequestId;
    private $userId;      //user id for the user who is making the change
    private $familyProfileId; //family id for the family whose profile is being changed
    private $profileChangeStatus; //string
    private $dateStatusSubm; //date of profile change request
    private $profileChangeNotes;
        /**
         * constructor for a Family Profile Change
         */
    function __construct($profileChangeId, $profileChangeRequestId, $userId, $familyProfileId,
            $profileChangeStatus, $dateStatusSubm, $profileChangeNotes){                
        
        $this->profileChangeId= $profileChangeId;
    $this->profileChangeRequestId = $profileChangeRequestId;
    $this->userId=$userId;      
    $this->familyProfileId= $familyProfileId;
    $this->profileChangeStatus=$profileChangeStatus; 
    $this->dateStatusSubm=$dateStatusSubm; 
    $this->profileChangeNotes=$profileChangeNotes;
    
    
    //getter functions
       
    function get_profileChangeId(){
    return $this->profileChangeId;}
    
    function get_profileChangeRequestId(){
    return $this->profileChangeRequestId;}
    
    function get_userId(){
    return $this->userId;}
    
    function get_familyProfileId(){
    return $this->familyProfileId;}
    
    function get_profileChangeStatus(){
    return $this->profileChangeStatus;}
    
    function get_dateStatusSubm(){
    return $this->dateStatusSubm;}
    
    function get_profileChangeNotes(){
    return $this->profileChangeNotes;}
    
   
    //setter functions
    
    
    function set_profileChangeId($profChangeId){
    $this->profileChangeId = $profChangeId;}
    
    function set_profileChangeRequestId($profChangeReqId){
    $this->profileChangeRequestId = $profChangeReqId;}
    
    function set_userId($usId){
    return $this->$usId;}
    
    function set_familyProfileId($famId){
    $this->familyProfileId = $famId;}
    
    function set_profileChangeStatus($profChangeStat){
    $this->profileChangeStatus = $profChangeStat;}
    
    function set_dateStatusSubm($dateStatSubm){
    $this->dateStatusSubm = $dateStatSubm;}
    
    function set_profileChangeNotes($profChangeNotes){
    $this->profileChangeNotes = $profChangeNotes;}
}
}

?>
