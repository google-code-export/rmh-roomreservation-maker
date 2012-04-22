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


if(isset($_POST['form_token']) && validateTokenField($_POST) && isset($_POST['firstName']) && isset($_POST['lastName']))
    {
        $fn = sanitize( $_POST['firstName']);
        $ln = sanitize( $_POST['lastName']);
        //echo "Post has been returned\n"; //THIS HAS BEEN REACHED
        $families = retrieve_FamilyProfileByName($fn, $ln);//currently my code dies here
        //an error on dbFamilyProfile.php line 165 unrecognized function connect();
        
        //check if famililes is an array
        //start table
        foreach( $families as $family )
        {
          //create a row with a td for lname, fname, town, dob
          echo "A family must have been returned";//TEST POINT HAS NOT BEEN REACHED 
        }
        //end table
    }
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        //if the security validation failed. display/store the error:
        //'The request could not be completed: security check failed!'

    }
    else
    {
        //there was no POST DATA  
        if(isset($_GET['family']) )
        {
            $familyID = sanitize($_GET['family']);
      
            $familyProfile = retrieve_dbFamilyProfile ($familyID);
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
                $content .= '<li>'.$familyProfile->get_patientrelation().'</li>';
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
                    
        }
        else
        {
            //$content = "bad request";
        }
    }

    //gets the familyid passed down by the family profile search and when the profile is selected(clicked)
?>

<div id="container">

    <?php include(ROOT_DIR.'/navigation.php');?>

    
    
    <div id="content" style="margin-left: 250px; margin-top: 23px;">
        
        <div id="searchForm"> <!--this div should be hidden when search results are displayed-->
        
        <form name="searchForm" method="POST" action="<?php echo BASE_DIR;?>/family/profileDetail.php">
            <?php echo generateTokenField(); ?>
            <input type="text" name="firstName" value="first name" size="50" />
            <input type="text" name="lastName" value="last name" size="60" /><br />
            <input type="submit" value="Lookup" />
        </form>
        
        </div>
    
        <div id="searchResults"><!--this div will receive content after a search is performed-->
        </div>
            <?php echo $content;?>
    </div>
</div>
<?php 
include (ROOT_DIR.'/footer.php');
?>

