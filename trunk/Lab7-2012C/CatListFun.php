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
          
          $cont = 0;
          displayCount($cat1,$cont); // calling the function to count the cats.
          displayCount($cat2,$cont);
          displayCount($cat3,$cont);
          
           echo "The number of cat that the color is orange is ". $cont ;
                    
          displayCatInfo($cat1);
          displayCatInfo($cat2);
          displayCatInfo($cat3);
          

function displayCount($cat,&$cont)  // function the count how many cats with the collor orange
{

            if($cat->getColor() == 'orange')    //comparison to verify the orange collor
                          $cont ++;   //counting the cats
}

function displayCatInfo($theCats)
{
    echo "Name is ".$theCats->getName()."<br>";
    echo "Color is ".$theCats->getColor()."<br>";
    echo "Breed is ".$theCats->getBreed()."<br><br>";    
}

?>
