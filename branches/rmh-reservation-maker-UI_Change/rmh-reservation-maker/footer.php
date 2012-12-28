<?php
/*
* Copyright 2012 by Prayas Bhattarai and Bonnie MacKellar.
* This program is part of RMH-RoomReservationMaker, which is free software,
* inspired by the RMH Homeroom Project.
* It comes with absolutely no warranty.  You can redistribute and/or
* modify it under the terms of the GNU Public License as published
* by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
 
/**
* Footer Script for RMH-RoomReservationMaker. 
* 
* This file includes the ending tags for body and html.
* Also contains, the jQuery script to hide the session message
*
* @author Prayas Bhattarai
* @version May 1, 2012
*/
?>
<script>
$(function(){
    $('.session_message').click(function(evt){
       $(this).slideUp(); 
    });
})
</script>
</body>
</html>
