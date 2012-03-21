<?php
          $cat1 = new Cat;
          $cat1->setColor("black");
          $cat1->setname("Zoe");
          $cat1->setBreed("Curl");
          $myCats[] = $cat1;
          TheCat($cat1);
          
          $cat2 = new Cat;
          $cat1->setColor("orange");
          $cat1->setname("Garfield");
          $cat1->setBreed("Longhair");
          $myCats[] = $cat2;
          TheCat($cat2);
          
          $cat3 = new Cat;
          $cat1->setColor("tabby");
          $cat1->setname("Fluffy");
          $cat1->setBreed("Shorthair");
          $myCats[] = $cat3;
          TheCat($cat3);
          
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

          
          
Function TheCat()
{
                
        echo "My cat's name is " . $cat1->getName() . " and " . $cat1->getName() . " is a " . $cat1->getBreed() . " whose fur is " . $cat1->getColor() . "<br/>";
}
?>
