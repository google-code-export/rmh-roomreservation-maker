<?php

          $cat1 = new Cat;
          $cat1->setColor("black");
          $cat1->setname("Zoe");
          $myCats[] = $cat1;
          
        $cat2 = new Cat;
          $cat1->setColor("orange");
          $cat1->setname("Garfield");
          $myCats[] = $cat1;
          
           $cat3 = new Cat;
          $cat1->setColor("tabby");
          $cat1->setname("Fluffy");
          $myCats[] = $cat1;
         
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
