<?php
          include_once 'Cat.php';
          
          $cat1 = new Cat;
          $cat1->setBreed("Abyssinian");
          $cat1->setColor("black");
          $cat1->setname("Zoe");
          $myCats[] = $cat1;
          $cat1->displayCat();
          
          $cat2 = new Cat;
          $cat2->setBreed("Toyger");
          $cat2->setColor("orange");
          $cat2->setname("Garfield");
          $myCats[] = $cat2;
          $cat2->displayCat();


          $cat3 = new Cat;
          $cat3->setBreed("Sphynx");
          $cat3->setColor("tabby");
          $cat3->setname("Fluffy");
          $myCats[] = $cat3;
          $cat3->displayCat();
          
          function countColor($cats, $color){
              $i=0;
              
              foreach ($cats as $cat)
              {
                  if($cat->getColor() == $color)
                      $i++;
              }
              return $i;
          }

?>
