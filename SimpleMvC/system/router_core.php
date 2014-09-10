<?php

class router_core
{
	
	private $request;
	private $request_method;
	private $controller;
	private $object_factory;
	private $plugin_manager;

	public function __construct(object_factory_core $factory, $request)
	{
		$this->object_factory=$factory;
		
		$this->request=$request;
		
		$this->plugin_manager=$this->object_factory->build_plugin_manager();
		
		$this->request_method=$_SERVER['REQUEST_METHOD'] == 'POST' ? 'POST' : 'GET';
	}
	
	
	// Load routing plugin or use default router
	// Default router uses uri, http verb to match match controller naming convention
	public function get_controller()
	{
		
		if($this->plugin_manager->plugin_loaded("routing"))
		{
			$this->controller=$this->plugin_manager->_plugin("routing");
			return $this->controller;
		}
		else
		{
			$this->request=ltrim($this->request,'/');
			$this->request=rtrim($this->request,'/');
			$this->controller=$this->request;
			
			switch($this->request_method)
			{
				case 'GET':
				$this->controller.='_page';
				break;
				
				case'POST':
				$this->controller.='_form';
				break;
				
				default:
				$this->controller.='_page';
			}
			
			return $this->controller;
		}
			
	}
	
}

?>