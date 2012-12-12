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
 * Search Family
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
          foreach( $families as $family )
        {
           //create a row with a td for lname, fname, town, dob
           $table .= "<tr>\n\t<td><a href=\"?id=";// DYNAMIC LINK CREATION
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
    
        if(isset($_GET['id']) )
    {   //gets the familyid passed down by the family profile search and when the profile is selected(clicked)
            $familyID = sanitize( $_GET['id'] );
            
            $familyProfile = retrieve_FamilyProfile ($familyID);
            if($familyProfile){
     
            }
            else 
            {
                $content = "not found";
            }
                    
        }//end function
        

?>
   
    
    <div id="content" style="margin-left: 250px; margin-top: 13px;">
        
        <div id="searchForm"> <!--this div should be hidden when search results are displayed-->
        
        <form name="searchForm" method="POST" action="<?php echo BASE_DIR;?>/family/profileDetail.php">
            <?php echo generateTokenField(); ?>
           
            <input type="text" class="formt formtop" name="firstName" size="20" onfocus="if(this.value == 'First Name') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'First Name'; }" value="First Name"/>
            <input type="text" class="formt formbottom" name="lastName" size="30" onfocus="if(this.value == 'Last Name') { this.value = ''; }" onblur="if(this.value==''){this.value = 'Last Name';}" value="Last Name"/><br />
            <div style="margin-top: 30px" > 
              <input style="margin-top: 40 px" type="submit" class="formsubmit" value="Search" />
              
            </div>
        </form>
            <br><br>
            <input class="helpbutton" type="submit" value="Help" align="bottom" onclick="location.href='../help/SearchingFamilyProfile.php'" />
            
        </div>
        
    
<?php 
include (ROOT_DIR.'/footer.php');
?>
