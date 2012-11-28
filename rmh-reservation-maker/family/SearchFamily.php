<?php

session_start();
session_cache_expire(30);

$title = "Family Profile in detail"; 

include('../header.php'); 
include(ROOT_DIR .'/domain/Family.php');
include(ROOT_DIR . '/database/dbFamilyProfile.php');


if(isset($_POST['form_token']) && validateTokenField($_POST) && ( isset( $_POST['firstName'] ) || isset( $_POST['lastName'] ) ) )
    {
        $fn = ( (isset( $_POST['firstName'] ) )?sanitize( $_POST['firstName']):""); //if firstName isset, sanitize it, else empty string
        if($fn == "first name" )
            $fn = "";
        $ln = ( (isset( $_POST['lastName'] ) )?sanitize( $_POST['lastName']):"");
        if($ln == "last name" )
            $ln = "";
        
        $families = retrieve_FamilyProfileByName($fn, $ln);//calls db receives an array of family objs
        
        if( is_array( $families ) )
        {
        //TODO: start table with tags
        //    $table = "\n<table style=\"margin-left: 250px; margin-top: 23px;\">\n<thead>\n<tr>\n";
        //    $table .= "<th>Name</th><th>City</th><th>DOB</th>\n</tr></thead>";
        //    $numFamilies = 1;
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
           $table .= "<tr>\n\t<td><a href=\"?id=";//TODO: DYNAMIC LINK CREATION
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
           $table .= $family->get_patientdob(); // TODO : Get rid of birthday time
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
    
    //
   // function displayProfile( $familyProfile )//should this be pass by ref and set as const?
    if(isset($_GET['id']) )
    {   //gets the familyid passed down by the family profile search and when the profile is selected(clicked)
            $familyID = sanitize( $_GET['id'] );
            //echo $familyID;
            
            $familyProfile = retrieve_FamilyProfile ($familyID);
            if($familyProfile){
               // $content = '<li>'.$familyProfile->get_parentfname().'</li>';
               // $content .= '<li>'.$familyProfile->get_parentlname().'</li>';
               // $content .= '<li>'.$familyProfile->get_parentemail().'</li>';
               // $content .= '<li>'.$familyProfile->get_parentphone1().'</li>';
               // $content .= '<li>'.$familyProfile->get_parentphone2().'</li>';
               // $content .= '<li>'.$familyProfile->get_parentcity().'</li>';
               // $content .= '<li>'.$familyProfile->get_parentstate().'</li>';
               // $content .= '<li>'.$familyProfile->get_parentzip().'</li>';
               // $content .= '<li>'.$familyProfile->get_parentcountry().'</li>';
               // $content .= '<li>'.$familyProfile->get_patientfname().'</li>';
               // $content .= '<li>'.$familyProfile->get_patientlname().'</li>';
               // $content .= '<li>'.$familyProfile->get_patientRelation().'</li>';
               // $content .= '<li>'.$familyProfile->get_patientdob().'</li>';
               // $content .= '<li>'.$familyProfile->get_patientformpdf().'</li>';
               // $content .= '<li>'.$familyProfile->get_patientnotes().'</li>';
        

            }
            else 
            {
                $content = "not found";
            }
                    
        }//end function
        

?>
   
    
    <div id="content" style="margin-left: 250px; margin-top: 23px;">
        
        <div id="searchForm"> <!--this div should be hidden when search results are displayed-->
        
        <form name="searchForm" method="POST" action="<?php echo BASE_DIR;?>/family/profileDetail.php">
            <?php echo generateTokenField(); ?>
           
            <input type="text" class="formt formtop" name="firstName" size="20" onfocus="if(this.value == 'first name') { this.value = ''; }" value="first name"/>
            <input type="text" class="formt formbottom" name="lastName" size="30" onfocus="if(this.value == 'last name') { this.value = ''; }" value="last name"/><br />
            <div style="margin-top: 50px" > <input style="margin-top: 50 px" type="submit" class="formsubmit" value="Search" />
            </div>
        </form>
            <br><br><br>
            <input class="helpbutton" type="submit" value="Help" align="bottom" onclick="location.href='../help/SearchingFamilyProfile.php'" />
        </div>
        
    
<?php 
include (ROOT_DIR.'/footer.php');
?>
