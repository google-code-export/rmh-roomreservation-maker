<?php 
class ErrorHandler{

	private static $errors = array();
	private static $messages = array();
	
	public static function error($message,$line=-1){
		array_push(self::$errors, array('message'=>$message, 'line'=>$line));
	}
	
	public static function info($message){
		array_push(self::$messages, $message);
	}
	
	public static function displayErrors(){
		foreach(self::$errors as $error){
			echo "<li>{$error['message']}</li>";
		}
		self::$errors = array();
	}
	
	public static function displayMessages(){
		foreach(self::$messages as $message){
			echo "<li>$message</li>";
		}
		self::$messages = array();
	}
	
}

?>