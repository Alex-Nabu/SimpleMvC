<?php
namespace SimpleMvC\system;

/**
 * -----------------------------THE EXCEPTIONS CLASS---------------------------
 * 
 * Extending classic php exceptions simply by adding a return url property
 * 
 * ----------------------------------------------------------------------------
 */

class Controller_Exception extends \Exception
{
	/**
	 * The url to return to in case of an error or exception
	 * 
	 * -------------------------CUSTOM VAR-------------------------------------
	 * 
	 * the url to redirect to in the case of a error where error is anything
	 * that disables a controller from executing its action
	 * 
	 * ------------------------------------------------------------------------
	 * 
	 * @var string the url to return to in case of an exception
	 * @access private
	 * 
	 */
	private $return_url;
	
	
	public function __construct($message, $return_url = '', $code = 0, Exception $previous = null)
	{
		$this->return_url=$return_url;
		
		parent::__construct($message, $code, $previous);
	}
	
	public function return_url()
	{
		return $this->return_url;
	}
}


?>