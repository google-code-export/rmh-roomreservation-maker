<?php
class Cat {
    private $name;
    private $color;
    private $breed; //Jeremiah P

    function setBreed($bd) { //Jeremiah P
        $this->breed = $bd;
    }
    
    function getBreed()
    {
        return $this->breed;
    }
    
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
}
?>
