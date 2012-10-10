<?php

          $cat1 = new Cat;
          $cat1->setColor("black");
          $cat1->setBreed("Calico");
          $cat1->setname("Zoe");
          $myCats[] = $cat1;
          
          $cat2 = new Cat;
          $cat2->setColor("orange");
          $cat2->setBreed("Siamese");
          $cat2->setname("Garfield");
          $myCats[] = $cat2;
          
          $cat3 = new Cat;
          $cat3->setColor("tabby");
          $cat3->setBreed("Lion");
          $cat3->setname("Fluffy");
          $myCats[] = $cat3;

          
          
          function countByColor($color,$myCats)//string,array
          {
              $count;//int
              $size=sizeof($myCats);//int
              for($i=0;i<size;$i++);
              {
                  if($myCats[$i]->getColor()==$color)//if array index at i is same as color
                  {
                      $count++;
                  }
              }
              return $count;              
          }
          

          
          function displayCatInfo($catExample)
          {
              
              foreach ($catExample as $item)
              {
                echo "Name: " . $item->getName();
                echo "<br>";
                echo "Color: " . $item->getColor();
                echo "<br>";
                echo "Breed: " . $item->getBreed();
                echo "<br>";
              }
          }
?>
