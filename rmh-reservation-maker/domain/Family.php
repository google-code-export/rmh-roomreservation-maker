<?php

/*
 * Family class for RMH Reservation Maker
 * @version April 20, 2012
 * @author Gergana Stoykova and Linda Shek
 */

class Family{
    
    private $familyProfileId;
    private $parentFirstName;
    private $parentLastName;
    private $parentEmail;
    private $parentPhone1;
    private $parentPhone2;
    private $parentAddress;
    private $parentCity;
    private $parentState;
    private $parentZIP;
    private $parentCountry;
    private $patientFirstName;
    private $patientLastName;
    private $patientRelation;
    private $patientDateOfBirth;
    private $patientFormPdf;
    private $patientNotes;
    
    /**constructor for Family**/
    
    
    function __construct($familyProfileId, $parentFirstName, $parentLastName, $parentEmail,
            $parentPhone1, $parentPhone2, $parentAddress, $parentCity, $parentState, $parentZIP,
            $parentCountry, $patientFirstName, $patientLastName, $patientRelation,
            $patientDateOfBirth, $patientFormPdf, $patientNotes){
        
    $this->familyProfileId = $familyProfileId;
    $this->parentFirstName= $parentFirstName;
    $this->parentLastName = $parentLastName;
    $this->parentEmail =$parentEmail;
    $this->parentPhone1= $parentPhone1;
    $this->parentPhone2= $parentPhone2;
    $this->parentAddress= $parentAddress;
    $this->parentCity= $parentCity;
    $this->parentState= $parentState;
    $this->parentZIP= $parentZIP;
    $this->parentCountry= $parentCountry;
    $this->patientFirstName= $patientFirstName;
    $this->patientLastName= $patientLastName;
    $this->patientRelation= $patientRelation;
    $this->patientDateOfBirth= $patientDateOfBirth;
    $this->patientFormPdf= $patientFormPdf;
    $this->patientNotes= $patientNotes;   
    }
            
    //getters
    function get_familyProfileId(){
        return $this->familyProfileId;
    }
    
    function get_parentfname(){
        return $this->parentFirstName;
    }
    
    function get_parentlname(){
        return $this->parentLastName;
    }
    
    function get_parentemail(){
        return $this->parentEmail;
    }
    
    function get_parentphone1(){
        return $this->parentPhone1;
    }
    
    function get_parentphone2(){
        return $this->parentPhone2;
    }
    
    function get_parentaddress(){
        return $this->parentAddress;
    }
    
    function get_parentcity(){
        return $this->parentCity;
    }
    
    function get_parentstate(){
        return $this->parentState;
    }
    
    function get_parentzip(){
        return $this->parentZIP;
    }
    
    function get_parentcountry(){
        return $this->parentCountry;
    }
    
    function get_patientfname(){
        return $this->patientFirstName;
    }
    
    function get_patientlname(){
        return $this->patientLastName;
    }
    
    function get_patientrelation(){
        return $this->patientRelation;
    }
    
    function get_patientdob(){
        return $this->patientBirthDate;
    }
    
    function get_patientformpdf(){
        return $this->patientFormPdf;
    }
    
    function get_patientnotes(){
        return $this->patientNotes;
    }
    
    
    //setters
    function set_familyProfileId($famProfId){
        $this->familyProfileId = $famProfId;
    }
    
    function set_parentfname($parFName){
        $this->parentFirstName = $parFName;
    }
    
    function set_parentlname($parLName){
        $this->parentLastName = $parLName;
    }
    
    function set_parentemail($parEmail){
        $this->parentEmail = $parEmail;
    }
    
    function set_parentphone1($parPh1){
        $this->parentPhone1 = $parPh1;
    }
    
    function set_parentphone2($parPh2){
        $this->parentPhone2 = $parPh2;
    }
    
    function set_parentaddress($parAddr){
        $this->parentAddress = $parAddr;
    }
    
    function set_parentcity($parCity){
        $this->parentCity = $parCity;
    }
    
    function set_parentstate($parState){
        $this->parentState = $parState;
    }
    
    function set_parentzip($parZip){
        $this->parentZIP = $parZip;
    }
    
    function set_parentcountry($parCountry){
        $this->parentCountry = $parCountry;
    }
    
    function set_patientfname($patfname){
        $this->patientFirstName = $patfname;
    }
    
    function set_patientlname($patlname){
        $this->patientLastName = $patlname;
    }
    
    function set_patientrelation($patrel){
        $this->patientRelation = $patrel;
    }
    
    function set_patientdob($patdob){
        $this->patientBirthDate = $patdob;
    }
    
    function set_patientformpdf($patPdf){
        $this->patientFormPdf = $patPdf;
    }
    
    function set_patientnotes($patNotes){
        $this->patientNotes = $patNotes;
    }
    
}
?>
