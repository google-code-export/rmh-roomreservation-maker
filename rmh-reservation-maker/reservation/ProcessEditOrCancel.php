<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
session_cache_expire(30);

$title = "ProcessEditOrCancel";
error_log("in ProcessEditOrCancel");
include('../header.php');
include_once (ROOT_DIR . '/domain/Reservation.php');
include_once (ROOT_DIR . '/domain/UserProfile.php');
include_once (ROOT_DIR . '/domain/Family.php');
include_once (ROOT_DIR . '/database/dbReservation.php');
include_once (ROOT_DIR . '/database/dbUserProfile.php');
include_once (ROOT_DIR . '/database/dbFamilyProfile.php');
//include(ROOT_DIR . '/database/dbReservation.php');

 $errors = array();
$messages = array();


     if (isset($_POST['chooseRequestID']))
       {
       
        if (allValsSet())
        {

        $idChosen = $_POST['Request'];
        $actionChosen = $_POST['actionChoice'];


         error_log("Request is $idChosen");
         
         if ($actionChosen == 'edit')
         {
           // editReservation($idChosen);
                   $_SESSION['RequestID'] = $idChosen;
                    header('Location: '.BASE_DIR.'/reservation/EditReservation.php');
                    exit();
         }
         if ($actionChosen == 'cancel')
         {
                  $_SESSION['RequestID'] = $idChosen;
                    header('Location: '.BASE_DIR.'/reservation/CancelReservation.php');
                    exit();
         }
  
        }

        else // some post value was not set
        {
            // put error handling in here
            error_log("needed value not set");
     
        }

   }
include (ROOT_DIR . '/footer.php');


// functions that are used above
function allValsSet()
{
    // note - can't run validateTokenField because it throws an error
    $ok = false;
   if((isset($_POST['Request'])) && (isset($_POST['actionChoice'])))
    {
       if ($_POST['Request'] == 'Request ID')
       {
           error_log("The record was not selected");
     
            displayErrorMsg('You did not select a record. Please go back and choose a record in the dropdown');
       }
       else
          $ok = true;         
    }

    else
    {
        //there was no POST DATA
          error_log('either the request or the action was not posted');
          displayErrorMsg('No action was selected');
   
    }
   
    return $ok;
}  // end allValsSet


 function displayErrorMsg($error)
{
         echo '<section class="content">';
        echo '<div>';
        echo $error;
        echo '</div>';
        echo '</section>';
} 


include (ROOT_DIR . '/footer.php');

?>
