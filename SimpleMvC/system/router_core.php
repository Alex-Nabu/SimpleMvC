<?php

class router_core
{
	
	private $controller;
	private $request;
	private $object_factory;

	public function __construct(object_factory_core $factory, $request)
	{
		$this->request=$request;
		$this->parse_route();
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