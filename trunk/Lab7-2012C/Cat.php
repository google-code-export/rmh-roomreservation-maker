<?php
class Cat {
    private $name;
    private $color;
    private $breed;

    
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
    
    function meow()
    {
        return $name . " says Meow!";
    }
    
    function getBreed()
    {
        return $this->breed;
    }
    
    function setBreed($bre)
    {
        $this->breed = $bre;
    }
}
?>
