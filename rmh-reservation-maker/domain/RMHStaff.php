<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class RMHStaff {
    private $rmhStaffProfileId;      // not the user name!!
    private $userId; // id number for specific RMH Staff member
    private $title; // title to the name
    private $lastName;        // last name - string
    private $firstName;       // first name - string
    private $phone; //phone number
    private $email;            // email address
    private $userLoginInfoId; //username of specific RMH Staff member
    private $userCategory;
    private $password;         

/**
         * constructor for a RMHStaffMember
         */
    function __construct($socialWorkerProfileId, $userId, $title, $lastName, $firstName,
            $phone, $email,  $userLoginInfoId, $userCategory, $password){                
        $this->userId = $userId; //is this first name + phone number or ??
        $this->rmhStaffProfileId = $socialWorkerProfileId; //order of profile in the database
        $this->title = $title; 
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->phone = $phone;
        $this->email = $email;
        $this->userLoginInfoId = $userLoginInfoId;
        $this->userCategory = $userCategory;
        
        if ($password=="")
            $this->password = md5($this->id);
        else 
            $this->password = $password;       
    }
    
    
    //getter functions
    function get_userId() {
        return $this->userId;
    }
    
    function get_rmhStaffProfileId(){
        return $this->rmhStaffProfileId;
    }
    
    function get_title(){
        return $this->title;
    }
    
    function get_firstName() {
        return $this->firstName;
    }
    
    function get_lastName() {
        return $this->lastName;
    }
    
    function get_phone() {
        return $this->phone;
    }
    
    function get_email(){
        return $this->email;
    }
    
    function get_userLoginInfoId(){
        return $this->userLoginInfoId;
    }
    
    function get_userCategory(){
        return $this->userCategory;
    }
    
    function get_password () {
        return $this->password;
    }
    
   
    //setter functions
    function set_userId($id) {
        $this->userId = $id;
    }
    
    function set_rmhStaffProfileId($profileNum){
        $this->rmhStaffProfileId = $profileNum;
    }
    
    function set_title($ttl){
        $this->title = $ttl;
    }
    
    function set_firstName($fn) {
        $this->firstName = $fn;
    }
    
    function set_lastName($ln) {
        $this->lastName = $ln;
    }
    
    function set_phone($phNum) {
        $this->phone = $phNum;
    }
    
    function set_email($em){
        $this->email = $em;
    }
    
    function set_userLoginInfoId($userLogin){
        $this->userLoginInfoId = $userLogin;
    }
    
    function set_userCategory($userCat){
        $this->userCategory = $userCat;
    }

    function set_password ($pass){
        $this->password = $pass;
    }
}
    
    
?>
