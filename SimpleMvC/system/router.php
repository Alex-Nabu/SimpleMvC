<?php
namespace SimpleMvC\system;

class router
{
	
	private $request;
	private $request_method;
	private $controller;
	private $object_factory;
	private $plugin_manager;

	public function __construct($factory, $request)
	{
		
		$this->object_factory=$factory;
		
		$this->request=$request;
		
		$this->plugin_manager=$this->object_factory->build_plugin_manager();
		
		$this->request_method=$_SERVER['REQUEST_METHOD'] == 'POST' ? 'POST' : 'GET';
		
	}
	
	
	// Load routing plugin or use default router
	// Default router uses uri + http verb to match match controller naming convention
	public function get_controller()
	{
		
		if($this->plugin_manager->plugin_loaded("routing"))
		{	
			$plugin_args=array(
			
			"request"=>$this->request,
			"method"=>$this->request_method
			
			);
			
			$this->controller=$this->plugin_manager->_plugin("routing", $plugin_args);	
		}
		else
		{
			$this->controller=$this->request;
			
			switch($this->request_method)
			{
				case 'GET':
				$this->controller.='_page_controller';
				break;
				
				case'POST':
				$this->controller.='_form_controller';
				break;
				
				default:
				$this->controller.='_page_controller';
			}
		}
	
	return $this->controller;	
			
	}
	
}

?>