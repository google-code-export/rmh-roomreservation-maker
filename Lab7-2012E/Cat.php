<?php
class Cat {
    private $name;
    private $color;
   
    function setName($nm)
    {
       $this->name = $nm;
    }
   
    function getName()
   {
        return $this->name;
    }
    
    function setColor($col)
    {
        $this->color = $col;
    }
   
   function getColor()
    {
        return $this->color;
    }
    
    function meow($name)
    {
        return $name ." says Meow!";
   }
}
    function prod_countCol($col) {
      $result= count($col); //total count of 
      echo $result;
    }

?>
