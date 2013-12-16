<?php
require_once("zend_library/Stdlib/ErrorHandler.php");
require_once("zend_library/Stdlib/StringWrapper/StringWrapperInterface.php");
require_once("zend_library/Stdlib/StringWrapper/AbstractStringWrapper.php");
require_once("zend_library/Stdlib/StringWrapper/Intl.php");

require_once("zend_library/Stdlib/StringUtils.php");
require_once("zend_library/Stdlib/StringWrapper/MbString.php");

require_once("zend_library/Filter/FilterInterface.php");
require_once("zend_library/Filter/AbstractFilter.php");
require_once("zend_library/Filter/Digits.php");

require_once("zend_library/Translator/TranslatorAwareInterface.php");

require_once("zend_library/Validator/ValidatorInterface.php");
require_once("zend_library/Validator/AbstractValidator.php");
require_once("zend_library/Validator/StringLength.php");
require_once("zend_library/Validator/Regex.php");
require_once("zend_library/Validator/NotEmpty.php");

require_once("zend_library/Validator/Digits.php");

class Validation {
	private $messages= array();
	
	function __construct($fields=""){
		if( !empty($fields) ){
			$this->fields= $fields;
		}else{
			$error = 'Validation Class need fields variable';
			throw new Exception($error);
		}
	}
	
	public function validate($POST){
		foreach( $this->fields as $field ){
			$field_name= $field['name'];
			foreach( $field['validators'] as $validation ){
				$validation_type= 'Zend\Validator\\' . $validation['name'];
				$validator= new $validation_type($validation['constructor']);
				$validator->setMessage($validation['message']);
				
				// Validation Name
				$all_error= "";		
				if( is_array($POST[$field_name]) ){
					foreach( $POST[$field_name] as $key=>$value ){
						if( !$validator->isValid($value) ){
							$error_msg= current($validator->getMessages());
							$this->messages[$field_name][$key][]= $error_msg;
						}
					}
				}else{
					if( !$validator->isValid($POST[$field_name]) ){
						$error_msg= current($validator->getMessages());
						$this->messages[$field_name]= $error_msg;
					}
				}
			}
		}
		
		return $this->messages;
	}
}
?>