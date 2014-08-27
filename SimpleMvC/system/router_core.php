<?php

class router_core
{
	
	private $request;
	
	private $controller;
	private $object_factory;
	private $plugin_manager;

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
		
		if($this->plugin)
		{
			$this->controller=plugin("controller_rewrite");
		}
		else
		{
			$this->request=ltrim($this->request,'/');
			$this->request=rtrim($this->request,'/');
			
			switch ($_SERVER['REQUEST_METHOD'])
			{
				case'GET' :
					
				$this->request.='_page';
				break;
				
				case'POST':
					
				$this->request.='_form';
				break;
				
				default:
				
				$this->request.='_page';
				break;
			}
			
			$this->controller=$this->request;
		}
			
	}
	
}

?>