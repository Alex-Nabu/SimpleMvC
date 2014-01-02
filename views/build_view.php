<?php

class build_view
{
	private $template;
	private $args;

	public function __construct(array $template, array $args)
	{
		$this->args=$args;
		$this->template=$template;
	}
	
	public function build_header()
	{
		require "templates/".$this->template['header'].".php";
	}
	
	public function build_body()
	{
		require "templates/".$this->template['body'].".php";
	}

	public function build_footer()
	{
		require "templates/".$this->template['footer'].".php";
	}
	
	public function render()
	{
		$this->build_header();
		$this->build_body();
		$this->build_footer();
	}

}

?>