<?php 
require('../core/config.php');

echo "Testing core/config definitions:";
linebr();

echo "Directory Separator: ".DS;
linebr();

echo "Root Dir (server side includes, WITHOUT trailing slash): ".ROOT_DIR;
linebr();

echo "Base Dir (client side includes, WITHOUT trailing slash): ".BASE_DIR;
linebr();

echo "CSS Directory, WITHOUT trailing slash: ".CSS_DIR;
linebr();

echo "JS Directory, WITHOUT trailing slash: ".JS_DIR;
linebr();



function linebr(){
	echo "<br />";
}

?>