<?php
namespace SimpleMvC\models; // This is the namespace used to hold SimpleMvC NS used to hold objects in this folder

use PDO; // Since we are in a NS we need to tell this NS to use these global objects
use Exception; // Since we are in a NS we need to tell this NS to use these global objects

class authentication_model
{
	
	// A simple string to return for example
	private $string;
	
	// The constructor can take as many arguments as you want
	public function __construct($host, $db)
	{
		$this->string = "Hi your database settings are as follows host :".$host."and your db name is:  ".$db;
		
	}
	
	public function talk()
	{
		return $this->string;
	}
	
}	
?>
