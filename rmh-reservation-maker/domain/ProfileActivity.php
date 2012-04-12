<?php
/*
 * ProfileActivity class for RMH Reservation Maker
 * @version April 09, 2012
 * @author Gergana Stoykova and Linda Shek
 */

include_once(ROOT_DIR .'/domain/Family.php');
include_once(ROOT_DIR .'/domain/UserProfile.php');
include_once(ROOT_DIR .'/database/dbProfileActivity.php');


class ProfileActivity {
    private $profileActivityId; //primary key for the profile activity table
    private $profileActivityRequestId; //request key number for the profile activity table
    private $socialWorkerProfileId; //social worker id for the social worker who is making the change
    private $rmhStaffProfileId; //rmh staff id for the rmh staff who is making the change
    private $familyProfileId; //family id for the family whose profile is being created or changed
    private $swDateStatusSubm; //date of profile change request by the social worker
    private $rmhDateStatusSubm;  //date of profile change request by the rmh staff 
    private $activityType; //string: utilized by the social worker for the profile activity request: 'Apply','Modify','Cancel'
    private $profileActivityStatus; //string: utilized by the rmh staff for the profile activity request: 'Unconfirmed','Confirm','Deny'
    private $profileActivityNotes; //(optional) notes from the rmh staff/social worker
        /**
         * constructor for profile activity
         */
    function __construct($profileActivityId, $profileActivityRequestId, $socialWorkerProfileId,
            $rmhStaffProfileId, $familyProfileId,$swDateStatusSubm,$rmhDateStatusSubm,
            $activityType, $profileActivityStatus,$profileActivityNotes){                
        
        $this->profileActivityId = $profileActivityId;
        $this->profileActivityRequestId = $profileActivityRequestId;
        $this->socialWorkerProfileId = $socialWorkerProfileId;  
        $this->rmhStaffProfileId = $rmhStaffProfileId;  
        $this->familyProfileId = $familyProfileId;
        $this->swDateStatusSubm= $swDateStatusSubm; 
        $this->rmhDateStatusSubm= $rmhDateStatusSubm;
        $this->activityType = $activityType;  
        $this->profileActivityStatus = $profileActivityStatus; 
        $this->profileActivityNotes = $profileActivityNotes;   
    
    //getter functions
       
    function get_profileActivityId(){
    return $this->profileActivityId;}
    
    function get_profileActivityRequestId(){
    return $this->profileActivityRequestId;}
    
    function get_socialWorkerProfileId(){
    return $this->socialWorkerProfileId;}
    
    function get_rmhStaffProfileId(){
    return $this->rmhStaffProfileId;}
    
    function get_familyProfileId(){
    return $this->familyProfileId;}
    
    function get_swDateStatusSubm(){
    return $this->swDateStatusSubm;}
    
    function get_rmhDateStatusSubm(){
    return $this->rmhDateStatusSubm;}
    
    function get_activityType(){
    return $this->activityType;}
    
    function get_profileActivityStatus(){
    return $this->profileActivityStatus;}
    
    function get_profileActivityNotes(){
    return $this->profileActivityNotes;}
    
    //setter functions
    
    function set_profileActivityId($profActivityId){
    $this->profileActivityId = $profActivityId;}
    
    function set_profileActivityRequestId($profActivityReqId){
    $this->profileActivityRequestId = $profActivityReqId;}
    
    function set_socialWorkerProfileId($sId){
    return $this->socialWorkerProfileId = $sId;}
    
    function set_rmhStaffProfileId($rId){
    return $this->rmhStaffProfileId = $rId;}
    
    function set_familyProfileId($famId){
    $this->familyProfileId = $famId;}
    
    function set_swDateStatusSubm($swDateStatSubm){
    $this->swDateStatusSubm = $swDateStatSubm;}
    
    function set_rmhDateStatusSubm($rmhDateStatSubm){
    $this->rmhDateStatusSubm = $rmhDateStatSubm;}
    
    function set_activityType ($actType){
    $this->activityType = $actType;}
    
    function set_profileActivityStatus($profActivityStat){
    $this->profileActivityStatus = $profActivityStat;}
    
    function set_profileActivityNotes($profActivityNotes){
    $this->profileActivityNotes = $profActivityNotes;}
}
}

?>
