<?php
          $cat1 = new Cat;
          $cat1->setColor("black");
          $cat1->setname("Zoe");
          $cat1->setBreed("Curl");
          $myCats[] = $cat1;
          
          $cat2 = new Cat;
          $cat2->setColor("orange");
          $cat2->setname("Garfield");
          $cat2->setBreed("Longhair");
          $myCats[] = $cat2;
          
          $cat3 = new Cat;
          $cat3->setColor("tabby");
          $cat3->setname("Fluffy");
          $cat3->setBreed("Shorthair");
          $myCats[] = $cat3;
          
         //In progress
         function colorCount($color){
              $count = 0;
              foreach ($myCats as $i){
            //foreach ($myCats as &$i){
                  if ($i.getColor() == color):
                    $count = $count + 1;
                  endif;
              }
              return count;
          }

?>