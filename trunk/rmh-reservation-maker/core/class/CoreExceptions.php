<?php 
class SecurityException extends Exception{
	function __construct($message, $code=null){
		parent::__construct($message, $code);
	}
}

class DuplicateUserException extends Exception{
	function __construct($message, $code=null){
		parent::__construct($message, $code);
	}
}

?>