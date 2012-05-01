<?php

/*
 * UserProfile class for RMH Reservation Maker
 * @author Linda Shek and Gergana Stoykova
 * @version April 22, 2012
 */


class UserProfile {
    private $userProfileId;       //primary key for the user profile table - number
    private $usernameId;          //username for specific user
    private $userEmail;           //email address
    private $password;            //password
    private $userCategory;
    private $swProfileId;
    private $swTitle;             //title to the name (Mr., Ms., Mrs., etc.)
    private $swLastName;          //last name - string
    private $swFirstName;         //first name - string
    private $hospitalAffiliation; //what Hospital the Social Worker is from; N/A for RMH staff
    private $swPhone;             //phone number
    private $emailNotification;   //opting in or out of email notifications for social worker ONLY
    private $rmhStaffProfileId;
    private $rmhStaffTitle;
    private $rmhStaffLastName;
    private $rmhStaffFirstName;
    private $rmhStaffPhone;
    
    
   function __construct($userCategory, $userProfileId, $usernameId, $userEmail, $password, $rmhStaffProfileId,  $rmhStaffTitle, 
            $rmhStaffFirstName, $rmhStaffLastName, $rmhStaffPhone, $swProfileId, $swTitle, $swFirstName,
            $swLastName, $hospitalAffiliation, $swPhone, $emailNotification){
       
       $this->userCategory = $userCategory; 
       $this->userProfileId = $userProfileId; //order of profile in the database
       $this->usernameId = $usernameId;
       $this->userEmail = $userEmail;
       if ($password=="")
            $this->password = md5($this->id);
        else 
            $this->password = $password; 
       $this->rmhStaffProfileId = $rmhStaffProfileId;
       $this->rmhStaffTitle = $rmhStaffTitle;
       $this->rmhStaffFirstName= $rmhStaffFirstName;
       $this->rmhStaffLastName= $rmhStaffLastName;
       $this->rmhStaffPhone= $rmhStaffPhone;
       $this->swProfileId= $swProfileId;
       $this->swTitle= $swTitle;
       $this->swFirstName= $swFirstName;
       $this->swLastName= $swLastName;
       $this->hospitalAffiliation= $hospitalAffiliation;
       $this->swPhone= $swPhone;
       $this->emailNotification= $emailNotification;       
   }
    
    //getter functions
   
    function get_userProfileId(){
        return $this->userProfileId;
    }
    
    function get_userCategory(){
        return $this->userCategory;
    }
    
    function get_usernameId(){
        return $this->usernameId;
    }
        
    function get_userEmail(){
        return $this->userEmail;
    }
    
    function get_password(){
        return $this->password;
    }
    
    function get_rmhStaffProfileId(){
        return $this->rmhStaffProfileId;
    }
    
    function get_rmhStaffTitle(){
        return $this->rmhStaffTitle;
    }
    
    function get_rmhStaffFirstName(){
        return $this->rmhStaffFirstName;
    }
    
    function get_rmhStaffLastName(){
       return $this->rmhStaffLastName; 
    }
    
    function get_rmhStaffPhone(){
        return $this->rmhStaffPhone;
    }
  
    function get_swProfileId(){
        return $this->swProfileId;
    }
    
    function get_swTitle(){
        return $this->swTitle;
    }
    
    function get_swFirstName() {
        return $this->swFirstName;
    }
    
    function get_swLastName() {
        return $this->swLastName;
    }
    
    function get_hospitalAff(){
        return $this->hospitalAffiliation;
    }
    
    function get_swphone() {
        return $this->swPhone;
    }
   
     function get_email_notification(){
        return $this->emailNotification;
    }
    
    //setter functions
    
    function set_userProfileId($profileNum){
        $this->userProfileId = $profileNum;
    }
    
    function set_userCategory($userCat){
        $this->userCategory = $userCat;
    }
    
    function set_usernameId($userLogin){
        $this->userLoginInfoId = $userLogin;
    }
 
    function set_userEmail($uEm){
        $this->userEmail = $uEm;
    }
    
    function set_password ($pass){
        $this->password = $pass;
    }
    
    function set_rmhStaffProfileId($rmhPrfId){
        $this->rmhStaffProfileId = $rmhPrfId;
    }
    
    function set_rmhStaffTitle($rmhttl){
        $this->rmhStaffTitle = $rmhttl;
    }
    
    function set_rmhStaffFirstName($rmhFn){
        $this->rmhStaffFirstName = $rmhFn;
    }
    
    function set_rmhStaffLastName($rmhLn){
       $this->rmhStaffLastName = $rmhLn; 
    }
    
    function set_rmhStaffPhone($rmhPhNum){
        $this->rmhStaffPhone = $rmhPhNum;
    }
  
    function set_swProfileId($swPrfId){
        $this->swProfileId = $swPrfId;
    }
    
    function set_swTitle($swttl){
        $this->swtitle = $swttl;
    }
    
    function set_swFirstName($swFn) {
        $this->swFirstName = $swFn;
    }
    
    function set_swLastName($swLn) {
        $this->swLastName = $swLn;
    }
    
    function set_hospitalAff($hospAff){
        $this->hospitalAffiliation = $hospAff;
    }
    
    function set_swPhone($swPhNum) {
        $this->swPhone = $swPhNum;
    }
    
    function set_email_notification($eNot){
        $this->emailNotification = $eNot;
    }
}

?>
