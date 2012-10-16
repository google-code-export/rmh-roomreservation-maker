<?php
          include ('Cat.php');
          
          $cat1 = new Cat;
          $cat1->setColor("black");
          $cat1->setName("Zoe");
          $cat1->setBreed("Burmese");
          
          $cat1->setBreed("Burmese");
          $myCats[] = $cat1;
         
          
          $cat2 = new Cat;
          $cat2->setColor("orange");
          $cat2->setName("Garfield");
          $cat2->setBreed("LaPerm");
          $cat2->setBreed("LaPerm");
          $myCats[] = $cat2;
          
          $cat3 = new Cat;
          $cat3->setColor("tabby");
          $cat3->setName("Fluffy");
          $cat3->setBreed("Tabby");
          
          $cat3->setBreed("Tabby");
          $myCats[] = $cat3;
          
          $count=0;
          
          catCount($myCats, $count);
          
          echo "The count for is ".$count."<br>";
          
          for ($i=0; $i<3;$i++)
          {
              displayCatInfo ($myCats[$i]);
          }
          
          function catCount($cats, &$num)
          {
              for( $i=0;$i<2;$i++)
              {
                  if ($cats[$i]->getColor()=="black")
                  {
                      $num++;
                  }
              }
          }
          function displayCatInfo($theCats)
{       
         echo "Name is: ".$theCats->getName()."<br>";
         echo "Color is: ".$theCats->getColor()."<br>";
         echo "Breed is: ".$theCats->getBreed()."<br><br>";
}                  

?>
