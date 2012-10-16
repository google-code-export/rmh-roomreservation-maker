<?php
class Cat {
    private $name;
    private $color;
    private $breed;

    function setBreed($br){
        $this->breed=$br;
    }
    
    function getBreed(){
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
    

}
?>
