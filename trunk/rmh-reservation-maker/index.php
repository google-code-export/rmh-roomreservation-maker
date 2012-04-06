<?php
session_start();
session_cache_expire(30);
$title = "Welcome";
include('header.php');?>
		<div id="container">
			
			<div id="content">
				Welcome to RMH Room Reservation Maker<br />
				<p>When you are finished, please remember to <a href="logout.php">logout</a>.</p>

				<?PHP
                                //|| $_SESSION['logged_in'] is added for test purpose, can be removed later
				if (isset($person) || (isset($_SESSION['logged_in']) && $_SESSION['logged_in']))
                                    { 
					/* if this is a person object
					 * Check type of person, and display home page based on that.
					 * level 0: Family Accounts
					 * level 1: Social Workers
					 * level 2: Room Reservation Managers
					 * level 3: Administrators
					*/
                    
					//DEFAULT PASSWORD CHECK
					//if (md5($person->get_id())==$person->get_password()){
						// if(!isset($_POST['_rp_submitted']))
						// 	echo('<div class="warning"><form method="post"><p><strong>We recommend that you change your password, which is currently default.</strong><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="right" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></td></tr></table></p></form></div>');
						/* else{
						 	//they've submitted
						 	if(($_POST['_rp_newa']!=$_POST['_rp_newb']) || (!$_POST['_rp_newa']))
						 		echo('<div class="warning"><form method="post"><p>Error with new password. Ensure passwords match.</p><br /><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="center" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></form></td></tr></table></div>');
						 	else if(md5($_POST['_rp_old'])!=$person->get_password())
						 		echo('<div class="warning"><form method="post"><p>Error with old password.</p><br /><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="center" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></form></td></tr></table></div>');
						 	else if((md5($_POST['_rp_old'])==$person->get_password()) && ($_POST['_rp_newa']==$_POST['_rp_newb'])){
						 		$newPass = md5($_POST['_rp_newa']);
						 		$person->set_password($newPass); 
						 		update_dbPersons($person);
						 	}
						 }
						
					}*/

			    //NOTES OUTPUT
				/*echo('<div class="infobox"><p class="notes"><strong>Notes to/from the manager:</strong><br />');
				echo($person->get_mgr_notes().'</div></p>');*/

				// we have a family authenticated

				//We have an admin authenticated	 
				if($_SESSION['access_level']==3) {
					echo("Welcome admin");
				    
				}

				}
				?>
				
			</div>
		</div>
  <?php include ('footer.php');?>
