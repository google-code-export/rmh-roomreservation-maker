<?php
include ('Cat.php');

          $cat1 = new Cat;
          $cat1->setColor("black");
          $cat1->setname("Zoe");
          $cat1->setBreed("Scottish Fold");
          $myCats[] = $cat1;
          
          $cat2 = new Cat;
          $cat2->setColor("orange");
          $cat2->setname("Garfield");
          $cat2->setBreed("Persian");
          $myCats[] = $cat2;
          
          $cat3 = new Cat;
          $cat3->setColor("tabby");
          $cat3->setname("Fluffy");
          $cat3->setBreed("Ragamuffin");
          $myCats[] = $cat3;
          
          displayCatInfo($cat1);
          displayCatInfo($cat2);
          displayCatInfo($cat3);
          
function displayCatInfo($theCats)
{
    echo "Name is ".$theCats->getName()."<br>";
    echo "Color is ".$theCats->getColor()."<br>";
    echo "Breed is ".$theCats->getBreed()."<br><br>";    
}
?>