<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class SocialWorker {
    private $socialWorkerProfileId;      // not the user name!!
    private $userId; // username
    private $title; // title to the name
    private $lastName;        // last name - string
    private $firstName;       // first name - string
    private $hospitalAffiliation; // what Hospital the Social Worker is from
    private $phone; //phone number
    private $email;            // email address
    private $emailNotification; //opting in or out of email notifications - boolean
    private $password;         // password for database access: default = username ??

        /**
         * constructor for a SocialWorker
         */
    function __construct($socialWorkerProfileId, $userId, $title, $lastName, $firstName, $hospitalAffiliation,
            $phone, $email, $emailNotification, $password){                
        $this->userId = $userId; //is this first name + phone number or ??
        $this->socialWorkerProfileId = $socialWorkerProfileId; //order of profile in the database
        $this->title = $title; 
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->hospitalAffiliation = $hospitalAffiliation;
        $this->phone = $phone;
        $this->email = $email;
        $this->emailNotification = $emailNotification; //boolean
        
        if ($password=="")
            $this->password = md5($this->id);
        else 
            $this->password = $password;       
    }
    
    
    //getter functions
    function get_userId() {
        return $this->userId;
    }
    
    function get_socialWorkerProfileId(){
        return $this->socialWorkerProfileId;
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
    
    function get_email_notification(){
        return $this->emailNofitication;
    }
    
    function get_password () {
        return $this->password;
    }
    
   
    //setter functions
    function set_userId($id) {
        $this->userId = $id;
    }
    
    function set_socialWorkerProfileId($profileNum){
        $this->socialWorkerProfileId = $profileNum;
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
    
    function set_email_notification($eNot){
        $this->emailNotification= $eNot;
    }

    function set_password ($pass) {
        $this->password = $pass;
    }
}
    


?>
