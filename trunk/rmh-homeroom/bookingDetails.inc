<html>
 <br/>

 <div align="left">
  <fieldset><legend>Booking Information:</legend>
  <b>Primary Guest: 
 <?php
    $current_id = $booking->get_guest_id();
    $current_guest = retrieve_dbPersons($current_id);
 ?>
 </b> <a href = <?php  echo("viewPerson.php?id=".$current_id);?> ><?php echo($current_guest->get_first_name()." ".$current_guest->get_last_name())?> </a>

 <br/>
 <b>Status: </b> <?php echo($booking->get_status()."<br/>");
    if ($booking->get_status()== "pending"){
         echo('<b>Date submitted: </b>'.date_string($booking->get_date_submitted())."<br/>");
    }
    else if($booking->get_status()== "active"){
         echo('<b>Date In: </b>'.date_string($booking->get_date_in()).'<br/>');
         echo('<b>Room Number: </b>'.$booking->get_room_no().'<br/>');     
    } 
    else if($booking->get_status()== "closed")
         echo('<b>Date In: </b>'.date_string($booking->get_date_in()).
              '<br/> <b> Date Out: </b>'.date_string($booking->get_date_out()).'<br/>');
    echo('<b>Referred By: </b>'.$booking->get_referred_by().'<br/>');?> 
    
    <br/>
    <b>Occupants: </b> 
    <?php $occupants = $booking->get_occupants();
    for($i=0 ; $i< sizeof($occupants) ; $i++){
        echo($occupants[$i].'<br/>');
     }?>
        
     <br/>
     <fieldset>
       <legend><b>Patient Info:</b></legend>
         <b>Patient name: </b> <?php echo($booking->get_patient());?> <br/>
         <b>Patient birth date: </b> <?php echo date_string($current_guest->get_patient_birthdate())?> <br/>
         <b>Hospital: </b> <?php echo($booking->get_hospital());?> <br/>
         <b>Department: </b> <?php echo($booking->get_department());?> <br/>
     </fieldset>
     <br/>
     
     <b>Payment Arrangement: </b> <?php echo($booking->get_payment_arrangement());?> <br><br/> 

     <?php 
/*     echo "<b>Loaners: </b> ";
     $loaners = $booking->get_loaners();
     if(sizeof($loaners == 0)) echo("none");
     else{
        for($j = 0 ; $j < sizeof($loaners) ; $j++){
            echo($loaners[j].'<br/>');
        }
     }
     echo "<br/> <br/>";
     */
    echo "<b>Approved Uses: </b>";
     if ($booking->overnight_use() == "yes") echo ('Overnight');
     if ($booking->day_use() == "yes") echo (' Day');
    echo "<br>";
     ?>
     <br/>
     <b>Manager Notes: </b> 
     <?php echo($booking->get_mgr_notes()."<br/><br/>");
     if($booking->get_status() == "pending"){
     	if ($booking->get_date_in() != "" && $booking->get_date_in() != "Will Call")
            $d = date_string($booking->get_date_in());
        else $d = "Will Call";
     	echo('<b> Expected Date of Arrival: </b> '.$d);
     }
     ?>
     
  </fieldset>
<br/><br/>                    
<fieldset><legend>Ronald McDonald House Health Questionnaire Responses:</legend>

Do you currently:
<br>
    1.  Experience flu-like symptoms? <?php if($booking->get_health_question(1) != "0") echo('<b>Yes</b>'); else echo('<b>No </b>')?> 
<br>2.  Have active shingles? <?php if($booking->get_health_question(2) != "0") echo('<b>Yes</b>'); else echo('<b>No </b>')?> 
<br>3.  Have active TB? <?php if($booking->get_health_question(3) != "0") echo('<b>Yes</b>'); else echo('<b>No </b>')?>
<br>4.  Have active conjunctivitis, impetigo, or strep throat? <?php if($booking->get_health_question(4) != "0") echo('<b>Yes</b>'); else echo('<b>No </b>')?>
<br>5.  Have active scabies, head lice, or body lice? <?php if($booking->get_health_question(5) != "0") echo('<b>Yes</b>'); else echo('<b>No </b>')?>
<br>6.  Have whooping cough? <?php if($booking->get_health_question(6) != "0") echo('<b>Yes</b>'); else echo('<b>No </b>')?>
<br><br>Have you:
<br>7.  Been exposed to measles in the last 18 days? <?php if($booking->get_health_question(7) != "0") echo('<b>Yes</b>'); else echo('<b>No </b>')?> 
<br>8.  Elected not to be immunized against measles? <?php if($booking->get_health_question(8) != "0") echo('<b>Yes</b>'); else echo('<b>No </b>')?> 
<br>9.  Had or been exposed to chicken pox in the last 21 days? <?php if($booking->get_health_question(9) != "0") echo('<b>Yes</b>'); else echo('<b>No </b>')?>
<br>10. Been vaccinated against chicken pox in the last 21 days? <?php if($booking->get_health_question(10) != "0") echo('<b>Yes</b>'); else echo('<b>No </b>')?>
<br><br>Do any of the children:
<br>11. Carry the hepatitis B virus? <?php if($booking->get_health_question(11) != "0") echo('<b>Yes</b>'); else echo('<b>No </b>')?>

</fieldset>

  <br/>
  <br/>
<?php if ($booking->get_status()=="pending") {?>
<form method = "POST" action = <?php echo "viewBookings.php?id=update&bookingid=".$booking->get_id()?>>
<input type="hidden" name = "booking_id" value = "<?php echo($id)?>" />
          <b> Flag as:</b> 
            <select name = "flag"> 
                     <option value = "new" <?php if($booking->get_flag() == "new") echo SELECTED?>> new </option>
                     <option value = "viewed"  <?php if($booking->get_flag() == "viewed") echo SELECTED?>> viewed </option>
                     <option value = "confirmed"  <?php if($booking->get_flag() == "confirmed") echo SELECTED?>> confirmed</option>
                     <option value = "requires attention" <?php if($booking->get_flag() == "requires attention") echo SELECTED?>> requires attention </option>
                     <option value = "past arrival date" <?php if($booking->get_flag() == "past arrival date") echo SELECTED?>> past arrival date </option>
                     </select><br/>
<br/>
          <input type ="submit" value = "Update Flag" name = "submit" />              
      <br/>
</form>
<?php }?>   

</html>