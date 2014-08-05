<?php

class router_core
{
	private $controller="index"; //The default controller is set to the index,
	private $request;
	private $request_data=array();

	public function __construct($request)
	{
		$this->request=$request;
	}
	
	public function get_uri()
	{
		return $this->request;
	}
	
	
	public function get_controller()
	{
		return $this->controller;
	}

	
	public function parse_route()
	{
		
		if(isset($plugin['controller_rewrite']))
		{
			$this->controller=plugin("controller_rewrite");
		}
		else
		{
			$this->request=ltrim($this->request,'/');
			$this->request=rtrim($this->request,'/');
			$this->controller=$this->request;
		}
			
	}
	
}

?>