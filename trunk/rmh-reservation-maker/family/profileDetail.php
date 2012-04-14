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

$title = "Family Detail"; //This should be the title for the page, included in the <title></title>

include('../header.php'); //including this will further include (globalFunctions.php and config.php)
include(ROOT_DIR .'/domain/Family.php');
include(ROOT_DIR .'/database/dbFamilyProfile.php');

/*
 * If your page includes a form, please follow the instructions below.
 * If not, this code block can be deleted
 * 
 * If the page checks for $_POST data then it is important to validate the token that is attached with the form.
 * Attaching token to a form is described below in the HTML section.
 * Include the following check:
 */
    //gets the familyid passed down by the family profile search and when the profile is selected(clicked)
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
                  
      }
      else 
      {
          $content = "not found";
      }
                    
    }
    else
    {
        $content = "bad request";
    }
        

?>

<div id="container">

    <?php include(ROOT_DIR.'/navigation.php');?>

    <div id="content">
            <?php echo $content;?>
        <a href="<?php echo BASE_DIR ?>/family/profileChange.php?family=<?php echo $familyID?>">Modify Profile</a>
        <a href="<?php echo BASE_DIR ?>/referralForm.php?family=<?php echo $familyID ?>">Create Room Reservation</a>
        
       
    </div>
</div>
<?php 
include (ROOT_DIR.'/footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
?>

