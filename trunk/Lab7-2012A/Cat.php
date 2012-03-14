<?php
// this represents one cat
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
