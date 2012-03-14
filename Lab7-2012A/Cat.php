<?php
// this represents one cat
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
    
    function setBreed()
    {
        $this->breed = $brd;
    }
    
    function getBreed()
    {
        return $this->breed; 
    }
    
    function meow()
    {
        return $name . " says Meow!";
    }
    
    function displayCat()
    {
        echo "My name is " . $this->name . " and my color is " . $this->color . "<br />";
    }
}
?>
