<?php
/*
* Copyright 2011 by Gergana Stoykova and Bonnie MacKellar.
* This program is part of RMH-RoomReservationMaker, which is free software,
* inspired by the RMH Homeroom Project.
* It comes with absolutely no warranty.  You can redistribute and/or
* modify it under the terms of the GNU Public License as published
* by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
 
/*
* Profile Activity Domain Object for RMH-RoomReservationMaker. 
* Specifies attributes for tracking the modifications to the family profile by Social worker
* @author Gergana Stoykova
* @version 5/2/2012
*/

/*include_once(ROOT_DIR.'/domain/Family.php');
include_once(ROOT_DIR.'/domain/UserProfile.php');
include_once(ROOT_DIR.'/database/dbProfileActivity.php');*/


class ProfileActivity {
    private $profileActivityId; //primary key for the profile activity table
    private $profileActivityRequestId; //request key number for the profile activity table
    private $familyProfileId; //family id for the family whose profile is being created or changed
    private $socialWorkerProfileId; //social worker id for the social worker who is making the change
    private $swLastName;
    private $swFirstName; 
    private $rmhStaffProfileId; //rmh staff id for the rmh staff who is making the change
    private $rmhStaffLastName;
    private $rmhStaffFirstName;
    private $swDateStatusSubm; //date of profile change request by the social worker
    private $rmhDateStatusSubm;  //date of profile change request by the rmh staff 
    private $activityType; //string: utilized by the social worker for the profile activity request: 'Apply','Modify','Cancel'
    private $profileActivityStatus; //string: utilized by the rmh staff for the profile activity request: 'Unconfirmed','Confirm','Deny'
    private $parentFirstName;
    private $parentLastName;
    private $parentEmail;
    private $parentPhone1;
    private $parentPhone2;
    private $parentAddress;
    private $parentCity;
    private $parentState;
    private $parentZip;
    private $parentCountry;
    private $patientFirstName;
    private $patientLastName;
    private $patientRelation;
    private $patientDOB;
    private $formPdf;
    private $familyNotes;
    private $profileActivityNotes; //(optional) notes from the rmh staff/social worker
    
    /**
         * constructor for profile activity
         */
    function __construct($profileActivityId, $profileActivityRequestId, $familyProfileId, $socialWorkerProfileId, $swLastName, $swFirstName,         
 $rmhStaffProfileId, $rmhStaffLastName, $rmhStaffFirstName, $swDateStatusSubm, $rmhDateStatusSubm, $activityType, $profileActivityStatus,
 $parentFirstName, $parentLastName, $parentEmail, $parentPhone1, $parentPhone2, $parentAddress, $parentCity, $parentState, $parentZip, 
 $parentCountry, $patientFirstName, $patientLastName, $patientRelation, $patientDOB, $formPdf, $familyNotes, $profileActivityNotes){                
        $this->profileActivityId = $profileActivityId;
        $this->profileActivityRequestId = $profileActivityRequestId;
        $this->socialWorkerProfileId = $socialWorkerProfileId;  
        $this->swLastName = $swLastName;
        $this->swFirstName = $swFirstName; 
        $this->rmhStaffProfileId = $rmhStaffProfileId; 
        $this->rmhStaffLastName = $rmhStaffLastName;
        $this->rmhStaffFirstName = $rmhStaffFirstName;
        $this->familyProfileId = $familyProfileId;
        $this->swDateStatusSubm= $swDateStatusSubm; 
        $this->rmhDateStatusSubm = $rmhDateStatusSubm;
        $this->activityType = $activityType;  
        $this->profileActivityStatus = $profileActivityStatus;  
        $this->parentFirstName = $parentFirstName;
        $this->parentLastName = $parentLastName;
        $this->parentEmail = $parentEmail;
        $this->parentPhone1 = $parentPhone1;
        $this->parentPhone2 = $parentPhone2;
        $this->parentAddress = $parentAddress;
        $this->parentCity= $parentCity;
        $this->parentState = $parentState;
        $this->parentZip = $parentZip;
        $this->parentCountry = $parentCountry;
        $this->patientFirstName = $patientFirstName;
        $this->patientLastName = $patientLastName;
        $this->patientRelation = $patientRelation;
        $this->patientDOB = $patientDOB;
        $this->formPdf = $formPdf;
        $this->familyNotes = $familyNotes;
        $this->profileActivityNotes = $profileActivityNotes; 
 }
    //getter functions
       
    function get_profileActivityId(){
        return $this->profileActivityId;
    }
    
    function get_profileActivityRequestId(){
        return $this->profileActivityRequestId;
    }
    
    function get_familyProfileId(){
        return $this->familyProfileId;
    }
    
    function get_socialWorkerProfileId(){
        return $this->socialWorkerProfileId;
    }
    
    function get_swLastName(){ 
        return $this->swLastName;
    }
    
    function get_swFirstName(){
        return $this->swFirstName;   
    }
    
    function get_rmhStaffProfileId(){
        return $this->rmhStaffProfileId;
    }
    
    function get_rmhStaffLastName(){
        return $this->rmhStaffLastName;
    }
   
    function get_rmhStaffFirstName(){
        return $this->rmhStaffFirstName;
    }
    
    function get_swDateStatusSubm(){
        return $this->swDateStatusSubm;
    }
    
    function get_rmhDateStatusSubm(){
        return $this->rmhDateStatusSubm;
    }
    
    function get_activityType(){
        return $this->activityType;
    }
    
    function get_profileActivityStatus(){
        return $this->profileActivityStatus;
    }
    
    function get_parentFirstName(){
        return $this->parentFirstName;
    }
    
    function get_parentLastName(){
        return $this->parentLastName;
    }
    
    function get_parentEmail(){
        return $this->parentEmail;
    }
    
    function get_parentPhone1(){
        return $this->parentPhone1;
    }
    
    function get_parentPhone2(){
        return $this->parentPhone2;
    }
    
    function get_parentAddress(){
        return $this->parentAddress;
    }
    
    function get_parentCity(){
        return $this->parentCity;
    }
    
    function get_parentState(){
        return $this->parentState;
    }
    
    function get_parentZip(){
        return $this->parentZip;
    }
    
    function get_parentCountry(){
        return $this->parentCountry;
    }
    
    function get_patientFirstName(){
        return $this->patientFirstName;    
    }
    
    function get_patientLastName(){
        return $this->patientLastName;
    }
    
    function get_patientRelation(){
        return $this->patientRelation;
    }
    
    function get_patientDOB(){
        return $this->patientDOB;
    }
    
    function get_formPdf(){
        return $this->formPdf;
    }
    
    function get_familyNotes(){
        return $this->familyNotes;
    }
    
    function get_profileActivityNotes(){
        return $this->profileActivityNotes;
    }
    
    //setter functions
    
    function set_profileActivityId($profActivityId){
        $this->profileActivityId = $profActivityId;
    }
    
    function set_profileActivityRequestId($profActivityReqId){
        $this->profileActivityRequestId = $profActivityReqId;
    }
    
    function set_familyProfileId($famId){
        $this->familyProfileId = $famId;
    }
    
    function set_socialWorkerProfileId($sId){
        $this->socialWorkerProfileId = $sId;
    }
    
    function set_swLastName($sLname){ 
        $this->swLastName = $sLname;
    }
    
    function set_swFirstName($sFname){
        $this->swFirstName = $sFname;   
    }
    
    function set_rmhStaffProfileId($rId){
        $this->rmhStaffProfileId = $rId;
    }
    
    function set_rmhStaffLastName($rLname){
        $this->rmhStaffLastName = $rLname;
    }
   
    function set_rmhStaffFirstName($rFname){
        $this->rmhStaffFirstName = $rFname;
    }
    
    function set_swDateStatusSubm($swDateStatSubm){
        $this->swDateStatusSubm = $swDateStatSubm;
    }
    
    function set_rmhDateStatusSubm($rmhDateStatSubm){
        $this->rmhDateStatusSubm = $rmhDateStatSubm;
    }
    
    function set_activityType ($actType){
        $this->activityType = $actType;
    }
    
    function set_profileActivityStatus($profActivityStat){
        $this->profileActivityStatus = $profActivityStat;
    }
     
    function set_parentFirstName($parFirstName){
        $this->parentFirstName = $parFirstName;    
    }
    
    function set_parentLastName($parLastName){
        $this->parentLastName = $parLastName;    
    }
    
    function set_parentEmail($parEmail){
        $this->parentEmail = $parEmail;
    }
    
    function set_parentPhone1($parPhone1){
        $this->parentPhone1 = $parPhone1;
    }
    
    function set_parentPhone2($parPhone2){
        $this->parentPhone2 = $parPhone2;
    }
    
    function set_parentAddress($parAddr){
        $this->parentAddress = $parAddr;
    }
    
    function set_parentCity($parCity){
        $this->parentCity = $parCity;
    }
    
    function set_parentState($parState){
        $this->parentState = $parState;
    }
    
    function set_parentZip($parZip){
        $this->parentZip = $parZip;
    }
    
    function set_parentCountry($parCountry){
        $this->parentCountry = $parCountry;
    }
    
    function set_patientFirstName($patFirstName){
        $this->patientFirstName = $patFirstName;
    }
    
    function set_patientLastName($patLastName){
        $this->patientLastName = $patLastName;
    }
    
    function set_patientRelation($patRel){
        $this->patientRelation = $patRel;
    }
    
    function set_patientDOB($patDOB){
        $this->patientDOB = $patDOB;
    }
    
    function set_formPdf($pdfForm){
        $this->formPdf = $pdfForm;
    }
    
    function set_familyNotes($famNotes){
        $this->familyNotes=$famNotes;
    }
    
    function set_profileActivityNotes($profActivityNotes) {
        $this->profileActivityNotes = $profActivityNotes;
    }
 
}

?>
