<?php
namespace SimpleMvC\system;

class SimpleMvC
{
	
	public $config;
	public $plugin_manager;
	public $object_factory;

	public $route;	
	public $router;
	public $default_route = 'index';
	
	public $controller;
	
	
	
	public function __construct($config)
	{
		
		// Set the config
		$this->config = $config;
		
		// Set the object_factory
		$this->object_factory = $config->object_factory;
		
		// Set the plugin manager
		$this->plugin_manager = $config->plugin_manager;
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('app_init', array("app"=>$this));
		
		// Enable sessions
		session_start();
		
		// Initialize the router
		$this->init_router();
				
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('post_app_init', array("app"=>$this));
		
	}
	
	
	public function init_router()
	{
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('pre_router_init', array("app"=>$this));
		
		// Set the route that the app got
		$this->route = isset($_GET['action'])?$_GET['action']:$this->default_route;		
		
		// Build the router
		$this->router = $this->object_factory->build_router($this->route);
	
		// Resolve the controller
		$this->controller = $this->router->_resolve();
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('post_router_init', array("app"=>$this));
		
	}
	
	
	public function init_controller()
	{
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('pre_controller_init', array("app"=>$this));
				
		// Build the controller. This method takes a string with the name of a controller
		$this->controller = $this->object_factory->build_controller($this->controller);
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('post_controller_init', array("app"=>$this));
		
	}
	
	
	public function _run()
	{
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('app_start',array("app"=>$this));
		
		try
		{
			// Initialize the controller
			$this->init_controller();
			
			// Run the controller
			$this->controller->_execute(); // can this method name be hookible?? try to arraange that
			
			// Tell all the plugins hooked to this event that it occured.
			$this->plugin_manager->_hook('app_end',array("app"=>$this));
		}
		catch(Controller_Exception $exception)
		{
			// Tell all the plugins hooked to this event that it occured.
			$this->plugin_manager->_hook('controller_exception',array("exception"=>$exception));
			
			if($exception->return_url() !== '') header('location:'.$exception->return_url());
			
			error_log($exception->__toString());
			exit;	
		}
		
	}
	
}

?>