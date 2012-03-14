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
    
    function setBreed($br)
    {
        $this->breed = $br;
    }
    
    function getBreed()
    {
        return $this->breed;
    }
    
    function meow()
    {
        return $name . " says Meow!";
    }
}
?>
