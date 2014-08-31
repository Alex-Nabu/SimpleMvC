<?php

class router_core
{
	
	private $request;
	private $controller;
	private $object_factory;
	private $plugin_manager;

	public function __construct(object_factory_core $factory, $request)
	{
		$this->object_factory=$factory;
		$this->request=$request;
		$this->plugin_manager=$this->object_factory->build_plugin_manager();
	}
	
	
	// Load routing plugin or use default router
	// Default router uses uri name plus http verb to match match controller naming convention
	public function get_controller()
	{
		
		if($this->plugin_manager->plugin_loaded("routing"))
		{
			return $this->controller=$this->plugin_manager->_plugin("routing");
		}
		else
		{
			$this->request=ltrim($this->request,'/');
			$this->request=rtrim($this->request,'/');
			
			switch ($_SERVER['REQUEST_METHOD'])
			{
				case'GET' :
					
				$this->controller=$this->request.'_page';
				break;
				
				case'POST':
					
				$this->controller=$this->request.'_form';
				break;
				
				default:
				
				$this->controller=$this->request.'_page';
				break;
			}
			
			return $this->controller;
		}
			
	}
	
}

?>