<?php
/*
 * @current author Bruno Constantino
 * @current author Kristen Gentle
 * 
 * @past author Jessica Cheong
 * @past co-author William Lodise
 * 
 * current authors modidied past authors code
 * 
 * @version December 12, 2012
 *
 *  Family Profile Detail
 * 
 * This page allows SW to search a family profile by First Name or Last Name.
 * If the SW chooses to search by First Name, The family with the name requested is displayed.
 * Like wise happen if the SW choosees so search by Last Name.
 * 
 * two options are given to the SW:
 * 
 * 1. Search First Name.
 * 2. Search Last Name.
  * 
 */

session_start();
session_cache_expire(30);

$title = "Family Profile in Detail"; 
$helpPage = "RoomRequest.php";

include('../header.php'); 
include(ROOT_DIR .'/domain/Family.php');
include(ROOT_DIR . '/database/dbFamilyProfile.php');


if(isset($_POST['form_token']) && validateTokenField($_POST) && ( isset( $_POST['firstName'] ) || isset( $_POST['lastName'] ) ) )
    {
       //Write a better code to all these validations!!!
        $fn = ( (isset( $_POST['firstName'] ) )?sanitize( $_POST['firstName']):""); //if firstName isset, sanitize it, else empty string
        if($fn == "First Name" )
            $fn = "";
        $ln = ( (isset( $_POST['lastName'] ) )?sanitize( $_POST['lastName']):"");
        if($ln == "Last Name" )
            $ln = "";
       
        $families = retrieve_FamilyProfileByName($fn, $ln);//calls db receives an array of family objs
        if($families)
            echo "";
        else
            echo("<div style='margin-left:260px; margin-top:30px;'><font color='red'><b>ERROR: Family not found, however, you may <a href='./newProfile.php'>create one.</a></b></font></div>"); //DON'T DIE!! Messes up the layout!!
        
        //TODO: BAD idea to just output errors wherever you want!!!! Organize this better. Use an error class or something!
        
        $familyprofileID=NULL; 
         $_SESSION['familyID']= $familyprofileID;
         
        
        if( is_array( $families ) )
        {
        //TODO: start table with tags
            $table = "\n<table cellpadding='20' style=\"margin-left:250px;\">\n<thead>\n<tr>\n";
            $table .= "<th>Patient Name</th><th>Parent Name</th><th>Parent City</th><th>Patient Date Of Birth</th><th>Patient Diagnosis</th>\n</tr></thead>";
            $numFamilies = 1;
            //create an array, 
        foreach( $families as $family )
        {
          
          //echo "<script type=\"text/javascript\">document.getElementById(\"searchResults\").innerHTML = \"A family has been returned\";</script>"; 
          //echo "<script type=\"text/javascript\">$(\"#searchResults\").html(\"A family is returned!\");</script>";
          //echo "<script type=\"text/javascript\">alert(\"OMG\");</script>";//This works
          //
          // TODO : Create array for familyProfileId
          //
          //create a row with a td for lname, fname, town, dob
           $table .= "<tr>\n\t<td><a style = 'color:blue; font-weight:bold;' href=\"?id=";//TODO: DYNAMIC LINK CREATION
           $table .= $family->get_familyProfileId();
           $table .= "\">";
           $table .= $family->get_patientlname();
           $table .= ", ";
           $table .= $family->get_patientfname();
           $table .= "</a></td>";
           $table .= "<td>";
           $table .= $family->get_parentlname() . ", " . $family->get_parentfname();
           $table .= "</td>";
           $table .= "<td>";
           $table .= $family->get_parentcity(); 
           $table .= "</td>";
           $table .= "<td>";
           $table .= $family->get_patientdob(); // TODO : Get rid of birthday time
           $table .= "</td>";
           $table .= "<td>";
           $table .= $family->get_patientnotes();
           $table .= "</td>";
           $table .= "</td>\n</tr>";
            // TODO : put familyProfileId into the elements of the array created above
            //var_dump($family);
            
           $numFamilies++;
        }
      
        
        $table .= "</table>";
        echo $table;
        }//end if is_array
    }
    else if(isset($_POST["form_token"]) && !validateTokenField($_POST))
    {
        //if the security validation failed. display/store the error:
        //'The request could not be completed: security check failed!'
        echo "<div style='margin-left:260px; margin-top:30px;'><font color='red'><b>ERROR: Security check failed, please go back and try again.</b></font></div>";

    }
    else
    {
        //there was no POST DATA  
    }
    
    //
   // function displayProfile( $familyProfile )//should this be pass by ref and set as const?
    if(isset($_GET['id']) )
    {   //gets the familyid passed down by the family profile search and when the profile is selected(clicked)
            $familyID = sanitize( $_GET['id'] );
            //echo $familyID;
            
            $familyProfile = retrieve_FamilyProfile ($familyID);
            if($familyProfile){
                //$content = '<'.$familyProfile->get_familyProfileStatus().'</li>';
                /*
                $content = '<b><font size=\'5\'>Parent Information</font></b><br />';
                $content .= '<li> <b>First Name:</b> '.$familyProfile->get_parentfname().'</li>';
                $content .= '<li> Last Name: '.$familyProfile->get_parentlname().'</li>';
                $content .= '<li> Email: '.$familyProfile->get_parentemail().'</li>';
                $content .= '<li> Phone Number 1: '.$familyProfile->get_parentphone1().'</li>';
                $content .= '<li> Phone Number 2:'.$familyProfile->get_parentphone2().'</li>';
                $content .= '<li> Address:'.$familyProfile->get_parentaddress().'</li>';
                $content .= '<li> City: '.$familyProfile->get_parentcity().'</li>';
                $content .= '<li> State: '.$familyProfile->get_parentstate().'</li>';
                $content .= '<li> Zipcode: '.$familyProfile->get_parentzip().'</li>';
                $content .= '<li> Country: '.$familyProfile->get_parentcountry().'</li>';
                 * 
                 */
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
                                    <td><b>Diagnosis</b></td>
                                    <td>" . $familyProfile->get_patientnotes() . "</td>
                            </tr>	
                    </table>";
                /*
                $content .= '<br /> <b>Patient Information</b>';
                $content .= '<li> First Name: '.$familyProfile->get_patientfname().'</li>';
                $content .= '<li> Last Name:'.$familyProfile->get_patientlname().'</li>';
                $content .= '<li> Parent\'s relationship to Patient: '.$familyProfile->get_patientRelation().'</li>';
                $content .= '<li> DOB: '.$familyProfile->get_patientdob().'</li>';
                $content .= '<li> Form: '.$familyProfile->get_patientformpdf().'</li>';
                $content .= '<li> Diagnosis: '.$familyProfile->get_patientnotes().'</li>';
                 */
                
            //    $familyprofileID = $familyProfile->get_familyProfileId();
        
               // $content .= '<a href="'.BASE_DIR.'/family/profileChange.php?family='.$familyID.'">Modify Profile</a>';
               // $content .= '<a href="'.BASE_DIR.'/referralForm.php?family='.$familyID.'">Create Room Reservation</a>';
            }
            else 
            {
                $content = "not found";
            }
                    
        }//end function
        
        
?>

<div id="container">    
    
    <div id="content" style="margin-left: 250px; margin-top: 13px;">
        
        <div id="searchForm"> <!--this div should be hidden when search results are displayed-->
        
        <form name="searchForm" method="POST" action="<?php echo BASE_DIR;?>/family/profileDetail.php">
            <?php echo generateTokenField(); ?>
           
        </form>
        
        </div>
    
        <div id="searchResults"><!--this div will receive content after a search is performed-->

        
          
          <div style="margin-top: 60px" >  
            
            <?php 
            //TODO looks crazy make it organized -.-           
            $buttonEdit = "<a href='../family/EditFamilyProfile.php' style='color: white' <input type='submit' name='edit' class='formsubmit' /> Edit </a>";
            $buttonDelete = " <input class='formsubmit' id='php_button' type='submit' value='Delete' >";
            $buttonCreateRoomReservation = "<a href='../referralForm.php' style='color: white' <input type='submit' name='CreateRoomReservation' class='formsubmit' /> Create Room Reservation </a>";
            $space = "&nbsp";
            $newparagraph = "<p>";
            if( isset( $content ) ){ echo "<font size = 4pt>$content</font>";
            echo $newparagraph;
            echo $newparagraph;
            echo $buttonEdit;
            echo $space;
            echo $buttonDelete;
            echo $space;
            echo $buttonCreateRoomReservation;
            
            } ?>
              
  
          </div>    

               
            
            

            
        </div>
             

    </div>
    
</div>
<?php 
include (ROOT_DIR.'/footer.php');
?>