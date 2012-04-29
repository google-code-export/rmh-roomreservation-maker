<?php
/*
 * @author Jessica Cheong
 * 
 * This page reflects the complete detail of the family profile after SW have searched the family 
 * based on the first and last name, and when SW has selected the family from the list of result.
 * 
 * Two options would be given to the SW:
 * 1. modify the profile.
 * 2. continue with the room reservation with the selected family profile.
 * 
 */
session_start();
session_cache_expire(30);

$title = "Family Profile in detail"; 

include('../header.php'); 
include(ROOT_DIR .'/domain/Family.php');
include(ROOT_DIR . '/database/dbFamilyProfile.php');


if(isset($_POST['form_token']) && validateTokenField($_POST) && ( isset( $_POST['firstName'] ) || isset( $_POST['lastName'] ) ) )
    {
        $fn = ( (isset( $_POST['firstName'] ) )?sanitize( $_POST['firstName']):""); //if firstName isset, sanitize it, else empty string
        $ln = ( (isset( $_POST['lastName'] ) )?sanitize( $_POST['lastName']):"");
        $families = retrieve_FamilyProfileByName($fn, $ln);
        
        if( is_array( $families ) )
        {
        //TODO: start table with tags
            $table = "\n<table style=\"margin-left: 250px; margin-top: 23px;\">\n<thead>\n<tr>\n";
            $table .= "<th>Name</th><th>City</th><th>DOB</th>\n</tr></thead>";
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
           $table .= "<tr>\n\t<td><a href=\"javascript:void(0);\"id=\"";//TODO: DYNAMIC LINK CREATION
           $table .= $family->get_familyProfileId();
           $table .= "\">";
           $table .= $family->get_parentlname();
           $table .= ", ";
           $table .= $family->get_parentfname();
           $table .= "</a></td>";
           $table .= "<td>";
           $table .= $family->get_parentcity();
           $table .= "</td>";
           $table .= "<td>";
           $table .= $family->get_patientdob();
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

    }
    else
    {
        //there was no POST DATA  
    }
    
    //if(isset($_GET['family']) )
    function displayProfile( $familyProfile )//should this be pass by ref and set as const?
    {   //gets the familyid passed down by the family profile search and when the profile is selected(clicked)
            $familyID = $familyProfile->get_familyProfileId();
      
            //$familyProfile = retrieve_dbFamilyProfile ($familyID);
            if($familyProfile){
                $content = '<li>'.$familyProfile->get_parentfname().'</li>';
                $content .= '<li>'.$familyProfile->get_parentlname().'</li>';
                $content .= '<li>'.$familyProfile->get_parentemail().'</li>';
                $content .= '<li>'.$familyProfile->get_parentphone1().'</li>';
                $content .= '<li>'.$familyProfile->get_parentphone2().'</li>';
                $content .= '<li>'.$familyProfile->get_parentcity().'</li>';
                $content .= '<li>'.$familyProfile->get_parentstate().'</li>';
                $content .= '<li>'.$familyProfile->get_parentzip().'</li>';
                $content .= '<li>'.$familyProfile->get_parentcountry().'</li>';
                $content .= '<li>'.$familyProfile->get_patientfname().'</li>';
                $content .= '<li>'.$familyProfile->get_patientlname().'</li>';
                $content .= '<li>'.$familyProfile->get_patientRelation().'</li>';
                $content .= '<li>'.$familyProfile->get_patientdob().'</li>';
                $content .= '<li>'.$familyProfile->get_patientformpdf().'</li>';
                $content .= '<li>'.$familyProfile->get_patientnotes().'</li>';
        
                $content .= '<a href="'.BASE_DIR.'/family/profileChange.php?family='.$familyID.'">Modify Profile</a>';
                $content .= '<a href="'.BASE_DIR.'/referralForm.php?family='.$familyID.'">Create Room Reservation</a>';
            }
            else 
            {
                $content = "not found";
            }
                    
        }//end function
        

?>

<div id="container">    
    
    <div id="content" style="margin-left: 250px; margin-top: 23px;">
        
        <div id="searchForm"> <!--this div should be hidden when search results are displayed-->
        
        <form name="searchForm" method="POST" action="<?php echo BASE_DIR;?>/family/profileDetail.php">
            <?php echo generateTokenField(); ?>
            Lookup family by parent first and last name:<br />
            <input type="text" name="firstName" size="20" onfocus="if(this.value == 'first') { this.value = ''; }" value="first"/>
            <input type="text" name="lastName" size="30" onfocus="if(this.value == 'last') { this.value = ''; }" value="last"/><br />
            <input type="submit" value="Lookup" />
        </form>
        
        </div>
    
        <div id="searchResults"><!--this div will receive content after a search is performed-->
            search results go here
        </div>
            <?php if( isset( $content ) ){ echo $content;} ?>
    </div>
</div>
<?php 
include (ROOT_DIR.'/footer.php');
?>

