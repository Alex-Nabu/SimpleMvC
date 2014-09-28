<?php
namespace SimpleMvC\system;

interface controller_interface
{
	
	public function __construct($factory); // A controller accpets the object factory as a parameter
	
	public function _execute(); // A controller only executes one method to remain linear in nature
	
}

?>