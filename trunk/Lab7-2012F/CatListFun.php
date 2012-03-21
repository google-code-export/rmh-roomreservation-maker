<?php
include_once(dirname(__FILE__).'\Cat.php');

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
          
         
          function colorCount($color, $arr1){
              $count = 0;
              foreach ($arr1 as $i){
                  if ($i->getColor() == $color):
                    $count = $count + 1;
                  endif;
              }
              return $count;
          }

          
          
Function TheCat()
{
                
        echo "My cat's name is " . $cat1->getName() . " and " . $cat1->getName() . " is a " . $cat1->getBreed() . " whose fur is " . $cat1->getColor() . "<br/>";
}
?>
