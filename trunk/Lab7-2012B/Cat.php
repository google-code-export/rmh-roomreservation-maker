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
    
        function count()
    {
        $col = $_POST['color'];
        $count = 0;
        
        $query = "SELECT * FROM cats WHERE color='$col'";
        $result = mysql_query ($query);
        $theCats = array();
        
        while ($result_row = mysql_fetch_assoc($result))
        {
            $count++;
        }
        
        
    }
}
?>
