<?php
 /*
 * @author Bruno Constantino
 * @author Kristen Gentle
 * 
 * @version December 12, 2012
 *
 * Family Profile Menu
 * 
 * This page allows SW to choose between creating family profile or 
  *searching family profile.
 * If the SW chooses create family profile button, they will be able to create a
  * new family profile.
  * If the SW chooses search, they will be able to update, delete or create a new family
  * profile.
 * two options are given to the SW:
 * 
 * 1. Create New Profile.
 * 2. Search for Families.
  * 
 */
        
        
 session_start();
 session_cache_expire(30);

 $title = "Family Profile Menu"; //Title for the page

 include('../header.php');
?>
<section class="content">
<!-- Does this even need a separate page? Try and incorporate this in the menu maybe. Low Priority -->
    <div>
    <ul>
       <li><a href="<?php echo BASE_DIR;?>/family/newProfile.php">Create new profile</a></li>
         <li><a href="<?php echo BASE_DIR;?>/family/SearchFamily.php?act=RES">Create new reservation</a></li>
       <li><a href="<?php echo BASE_DIR;?>/family/SearchFamily.php?act=SEARCH">Search for families</a></li>
    </ul> 
	</div>
</section>
<?php 
include (ROOT_DIR .'/footer.php');
//include the footer file, this contains the proper </body> and </html> ending tag.
?>