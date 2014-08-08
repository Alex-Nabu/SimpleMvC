<?php

class build_view
{
	private $template;
	private $args;

	public function __construct(array $template, $args=array())
	{
		$this->args=$args;
		$this->template=$template;
	}
	
	public function render()
	{
		require "templates/".$this->template['header'].".php";
		require "templates/".$this->template['body'].".php";
		require "templates/".$this->template['footer'].".php";
	}

}

?>