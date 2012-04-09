<?php
/*
 * ProfileChange class for RMH Reservation Maker
 * @version April 09, 2012
 * @author Linda Shek
 */

include_once(dirname(__FILE__).'/ProfileActivity.php');
include_once(dirname(__FILE__).'/database/dbProfileChange.php');

class ProfileChange {
    private $profileChangeIndex; //unique key for the profile activity change table
    private $profileActivityId; // id of the profile activity 
    private $profileChangeFieldName; //any field name from the FamilyProfile table (ex. ParentLastName, Address, Email, etc.)     
    private $profileChangeFieldChanges;//change information corresponding to the field name selected. 
                                     //(ex. if field name = email, then field change might have "example@email.com")    
        /**
         * constructor for profile change
         */
    function __construct($profileChangeIndex, $profileActivityId, $profileChangeFieldName, $profileChangeFieldChanges)
        {                
        
        $this->profileChangeIndex = $profileChangeIndex;
        $this->profileActivityId = $profileActivityId;
        $this->profileChangeFieldName = $profileChangeFieldName;
        $this->profileChangeFieldChanges = $profileChangeFieldChanges;  
    
    //getter functions
       
    function get_profileChangeIndex(){
    return $this->profileChangeIndex;}
    
    function get_profileActivityId(){
    return $this->profileActivityId;}
    
    function get_profileChangeFieldName(){
    return $this->profileChangeFieldName;}
    
    function get_profileChangeFieldChanges(){
    return $this->profileChangeFieldChanges;}
   
    //setter functions   
    
    function set_profileChangeIndex($profChangeIdx){
    $this->profileChangeIdx = $profChangeIdx;}
    
    function set_profileActivityId($profActId){
    $this->profileActivityId = $profActId;}
    
    function set_profileChangeFieldName($profChangeFldNm){
    $this->profileChangeFieldName = $profChangeFldNm;}
    
    function set_profileChangeFieldChanges($profChangeFldChng){
    return $this->profileChangeFieldChanges = $profChangeFldChng;}
}
}

?>

