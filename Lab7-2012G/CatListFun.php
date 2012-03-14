<?php

          $cat1 = new Cat;
          $cat1->setColor("black");
          $cat1->setname("Zoe");
          $cat1->setBreed("Abyssinian");
          $myCats[] = $cat1;
          
          $cat2 = new Cat;
          $cat2->setColor("orange");
          $cat2->setname("Garfield");
          $cat2->setBreed("Cymric");
          $myCats[] = $cat2;
          
          $cat3 = new Cat;
          $cat3->setColor("tabby");
          $cat3->setname("Fluffy");
          $cat3->setBreed("Pixie-bob");
          $myCats[] = $cat3;
         
function countCats($cats, $color)
{
    $count = 0;
    foreach($cats as $cat)
    {
        if($cat->getColor() == $color)
            $count++;
    }
    return $count;
}
?>
