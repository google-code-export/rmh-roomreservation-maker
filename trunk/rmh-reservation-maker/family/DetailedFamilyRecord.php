<?php
session_start();
session_cache_expire(30);

$title = "View A Family Profile";
$helpPage = "SearchingFamilyProfile.php";

include('../header.php');
include(ROOT_DIR .'/domain/Family.php');
include(ROOT_DIR . '/database/dbFamilyProfile.php');

error_log("in DetailedFamilyRecord.php");
// if the user clicked on the patient name in the table of family profiles, then a new request
    // is sent with $id set to the family profile id, and this section of code is invoked
   // function displayProfile( $familyProfile )//should this be pass by ref and set as const?
    if (isset($_GET['id']) )
    {   //gets the familyid passed down by the family profile search and when the profile is selected(clicked)
            $familyID = sanitize( $_GET['id'] );

            error_log("family profile id is $familyID");
            $familyProfile = retrieve_FamilyProfile ($familyID);
            if($familyProfile){
            
                //SEPERATE PATIENT FROM PARENT
                $content = "<b><font size='6'><u><div style='margin-top:-45px;'>Parent Information</div></u></font></b>    
                    <table style cellpadding=15 cellspacing=50>
                            <tr>
                                    <td><b>First Name</b></td>
                                    <td>" . $familyProfile->get_parentfname() . "</td>
                            </tr>
                            <tr>
                                    <td><b>Last Name</b></td>
                                    <td>" . $familyProfile->get_parentlname() . "</td>
                            </tr>
                            <tr>
                                    <td><b>Email</b></td>
                                    <td>" . $familyProfile->get_parentemail() . "</td>
                            </tr>	
                            <tr>
                                    <td><b>Phone Number 1</b></td>
                                    <td>" . $familyProfile->get_parentphone1() . "</td>
                            </tr>	
                            <tr>
                                    <td><b>Phone Number 2</b></td>
                                    <td>" . $familyProfile->get_parentphone2() . "</td>
                            </tr>	
                            <tr>
                                    <td><b>Address</b></td>
                                    <td>" . $familyProfile->get_parentaddress() . "</td>
                            </tr>	
                            <tr>
                                    <td><b>City</b></td>
                                    <td>" . $familyProfile->get_parentcity() . "</td>
                            </tr>	
                            <tr>
                                    <td><b>State</b></td>
                                    <td>" . $familyProfile->get_parentstate() . "</td>
                            </tr>	
                            <tr>
                                    <td><b>Zipcode</b></td>
                                    <td>" . $familyProfile->get_parentzip() . "</td>
                            </tr>	
                            <tr>
                                    <td><b>Country</b></td>
                                    <td>" . $familyProfile->get_parentcountry() . "</td>
                            </tr>	

                    </table>";
                
                // this creates the HTML that will be displayed to the user
                $content.= "<br /><b><font size='6'><u>Patient Information</u></font></b><br />
                    <table cellpadding=15>
                            <tr>
                                    <td><b>First Name</b></td>
                                    <td>" . $familyProfile->get_patientfname() . "</td>
                            </tr>
                            <tr>
                                    <td><b>Last Name</b></td>
                                    <td>" . $familyProfile->get_patientlname() . "</td>
                            </tr>
                            <tr>
                                    <td><b>Relationship to Patient</b></td>
                                    <td>" . $familyProfile->get_patientrelation() . "</td>
                            </tr>	
                            <tr>
                                    <td><b>DOB</b></td>
                                    <td>" . $familyProfile->get_patientdob() . "</td>
                            </tr>	
                            <tr>
                                    <td><b>Form</b></td>
                                    <td>" . $familyProfile->get_patientformpdf() . "</td>
                            </tr>	
                            <tr>
                                    <td><b>Notes</b></td>
                                    <td>" . $familyProfile->get_patientnotes() . "</td>
                            </tr>	
                    </table>";

            }
            else 
            {
                error_log("a matching record was not found, id = $familyID ");
                $content = "A matching record was not found";
            }
            
         echo '<section class="content">';
         echo '<div id="searchResults"><!--this div will receive content after a search is performed-->';
         
          echo '<div style="margin-top: 60px" > '; 
            
      
          //  $buttonEdit = "<a href='../family/EditFamilyProfile.php' style='color: white' <input type='submit' name='edit' class='formsubmit' /> Edit </a>";
            $buttonDelete = " <input class='formsubmit' id='php_button' type='submit' value='Delete' >";
         //   $buttonCreateRoomReservation = "<a href='../referralForm.php' style='color: white' <input type='submit' name='CreateRoomReservation' class='formsubmit' /> Create Room Reservation </a>";
            $space = "&nbsp";
            $newparagraph = "<p>";
            if( isset( $content ) ){ echo "<font size = 4pt>$content</font>";
            echo $newparagraph;
           echo $newparagraph;
          //  echo $buttonEdit;
            echo $space;
            echo $buttonDelete;
            echo $space;
          //  echo $buttonCreateRoomReservation;         
            }
    }
    

include (ROOT_DIR.'/footer.php');

?>
