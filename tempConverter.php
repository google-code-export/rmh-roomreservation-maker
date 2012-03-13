
<html>
<body style="background-color:yellow;" >
<?php
  $temp = $_GET["temp"];
  echo "The original temperature is " . $temp . "<br/>";
  if ($_GET["conversion"] == 1)  //celsius to fahrenheit
      echo "The fahrenheit temperature is " .  ((($temp * 9)/5) + 32);
  elseif ($_GET["conversion"] == 2)  // fahreheit to celsius
      echo "The celsius temperature is " . ((($temp - 32)/9) * 5);
  else 
  echo "Error - you did not select a conversion";
?>
</body>
</html>
