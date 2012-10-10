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
    
    function getBreed()
    {
        return $this->breed;
    }
    
    function setBreed($brd)
    {
        $this->breed = $brd;
    }
    
    function meow()
    {
        return $name . " says Meow!";
    }
}
?>