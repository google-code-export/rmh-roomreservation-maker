<?php
class DataValidator{
	private $validationRules;
	private $cleanData = array();
	private $errorMessages = array();
	
	function __construct($data, $validationRule){
		$this->validationRules = $validationRule;
		$this->validate($data);
	}
	/**
	 * @param array $data
	 * @throws SecurityException
	 */
	public function validate($data){
		$this->validateTokenField($data);
		unset($data['form_token']);
		
		foreach($data as $id=>$value){
			if(isset($this->validationRules[$id])){
				$cleanField = $this->checkField($value, $this->validationRules[$id]);
				
				$this->cleanData[$id] = $cleanField['data'];
				if(isset($cleanField['message'])){
					$this->errorMessages[$id] = $cleanField['message'];
				}
			}else{
				$this->cleanData[$id] = $this->sanitize($value);
				$this->errorMessages[$id] = 'No validation rule found for: '.$id;
			}
		}
	}
	
	private function checkField($value, $rules){
		//sanitize the prevalidation data so that it can be returned as safe
		$value = $this->sanitize($value);
		$retVal = array();
		$retVal['data'] = $value;
		
		if(isset($rules['allow'])){
			$pattern = '/'.preg_quote(implode($rules['allow'])).'/';
			$value = preg_replace($pattern,'',$value);
		}
		unset($rules['allow']);
		$optional = in_array('optional',$rules);
		$notempty = $this->notempty($value);
		if(in_array('notempty',$rules))
			unset($rules[array_search('notempty',$rules)]);
		if($optional){
			if(!$notempty){
				//if it is optional and empty return valid
				return $retVal;
			}else{
				//unset optional key so that we can continue with validation
				unset($rules[array_search('optional', $rules)]);
			}
		}else{
			if(!$notempty){
				//if it is not optional, and it is empty return error
				return array('data'=>$value, 'message'=>'Field cannot be left empty');
			}
			//continue validation if it is not empty
		}
		foreach($rules as $rule){
			switch($rule){
				case 'number':
					if(!$this->number($value))
						return array_merge($retVal, array('message'=>'Only numbers are allowed'));
				break;
				
				case 'alpha':
					if(!$this->alpha($value))
						return array_merge($retVal, array('message'=>'Only alphabets are allowed'));
				break;
				
				case 'alphanumeric':
					if(!$this->alphanumeric($value))
						return array_merge($retVal,array('message'=>'Only numbers and digits are allowed'));
				break;
				
				case 'email':
					if(!$this->email($value))
						return array_merge($retVal,array('message'=>'Valid email is required'));
				break;
				
				case 'ignore':
				break;
				
				default:
					return array_merge($retVal,array('message'=>'Invalid rule: '.$rule));
				break;
			}
		}
		
		return $retVal;
	}
	
	private function notempty($value){
		return (preg_replace('/\s+/', '', $value) != '');
	}
	
	private function number($value){
		return preg_match('/^[0-9]+$/',$value);
	}
	
	private function alpha($value){
		return preg_match('/^[[:alpha:]]+$/',$value);
	}
	
	private function alphanumeric($value){
		return preg_match('/^[[:alnum:]]+$/', $value);
	}
	
	//TODO could we use filter_var?? Test to see if php.ini has the extension installed. If so, using these for validation will be easier and reliable?
	private function email($value){
		//from php_filter_validate_email
		$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
		return preg_match($pattern, $value);
	}
	
	public function getData(){
		return $this->cleanData;
	}
	
	public function getErrors(){
		return $this->errorMessages;
	}
	
	public function isValid(){
		return (count($this->errorMessages) == 0);
	}
	
	public function setError($field, $message){
		$this->errorMessages[$field] = $message;
	}
	
	private function sanitize($data, $mysql=false)
	{
		if($mysql)
		{
			$sanitized = mysql_real_escape_string($data); //in order to use mysql_real_escap_string a db connection is required
		}
		else
		{
			$sanitized = htmlspecialchars(trim($data),ENT_QUOTES);
		}
		return $sanitized;
	}
	
	/**
	 * validateTokenField function that will check the validity of the form data that was submitted depending on the form token
	 *
	 * @return boolean true if validates, false if it does not.
	 */
	private function validateTokenField($postData)
	{
		if(array_key_exists('form_token', $postData))
		{
			if(isset($_SESSION['_token']) && ($_SESSION['_token'] == $postData['form_token']))
			{
				unset($_SESSION['_token']); //remove the token once it's been used, making it invalid for reuse
				return true;
			}
			else
			{
				throw new SecurityException("Invalid token");
			}
		}
		else
		{
			throw new SecurityException("Token not set");
		}
	}
}
?>