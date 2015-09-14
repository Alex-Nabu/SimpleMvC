<?php
namespace SimpleMvC\system;

class router
{
	
	public $request;
	public $request_method;
	public $controller;
	public $object_factory;
	public $plugin_manager;

	public function __construct($factory, $request)
	{
		
		$this->object_factory=$factory;
		
		$this->request=$request;
		
		$this->plugin_manager=$this->object_factory->build_plugin_manager();
		
		$this->request_method=$_SERVER['REQUEST_METHOD'] == 'POST' ? 'POST' : 'GET';
						
	}
	
	
	// Default router uses uri + http verb to map to a controller that uses naming conventions
	public function _resolve()
	{
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('pre_routing', array("router"=>$this));
		
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
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('post_routing', array("router"=>$this));
		
		return $this->controller;
						
	}
	
}

?>