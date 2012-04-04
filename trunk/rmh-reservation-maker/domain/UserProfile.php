<?php

/*
 * UserProfile class for RMH Reservation Maker
 * @author Linda Shek, Gergana Stoykova
 * @version April 04, 2012
 */


class User {
    private $profileId;      //user id for the unique profile - number
    private $title; // title to the name
    private $lastName;        // last name - string
    private $firstName;       // first name - string
    private $hospitalAffiliation; // what Hospital the Social Worker is from; N/A for RMH staff
    private $phone; //phone number
    private $email;            // email address
    private $emailNotification; //opting in or out of email notifications for social worker ONLY
    private $userLoginInfoId; //username for specific social worker
    private $userCategory;
    private $password;         // password for database access: default = username ??

        /**
         * constructor for a User (social worker and RMH staff member)
         */
    function __construct($profileId, $title, $lastName, $firstName, $hospitalAffiliation,
            $phone, $email, $emailNotification,  $userLoginInfoId, $userCategory, $password){                
        
        $this->profileId = $profileId; //order of profile in the database
        $this->title = $title; 
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->hospitalAffiliation = $hospitalAffiliation;
        $this->phone = $phone;
        $this->email = $email;
        $this->emailNotification = $emailNotification; //boolean
        $this->userLoginInfoId = $userLoginInfoId;
        $this->userCategory = $userCategory;
        
        if ($password=="")
            $this->password = md5($this->id);
        else 
            $this->password = $password;       
    }
    
    
    //getter functions
   
    
    function get_profileId(){
        return $this->profileId;
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
    
    function get_hospitalAff(){
        return $this->hospitalAffiliation;
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
    
    
    function set_profileId($profileNum){
        $this->profileId = $profileNum;
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
    
    function set_hospitalAff($hospAff){
        $this->hospitalAffiliation = $hospAff;
    }
    
    function set_phone($phNum) {
        $this->phone = $phNum;
    }
    
    function set_email($em){
        $this->email = $em;
    }
    
    function set_email_notification($eNot){
        $this->emailNotification = $eNot;
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
