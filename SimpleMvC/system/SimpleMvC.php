<?php
namespace SimpleMvC\system;

class SimpleMvC
{
	
	public $config;
	public $plugin_manager;
	public $object_factory;
	
	public $router;
	public $route;
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
		
		// Set the route that the app got
		$this->route = isset($_GET['action'])?$_GET['action']:$this->default_route;
		
		// Initialize the router
		$this->init_router();
		
		// Initialize the controller
		$this->init_controller();
		
	}
	
	
	public function init_router()
	{
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('pre_router_init', array("app"=>$this));
		
		// Build the router
		$this->router = $this->object_factory->build_router($this->route);
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('post_router_init', array("app"=>$this));
		
	}
	
	
	public function init_controller()
	{
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('pre_controller_init', array("app"=>$this));
		
		// Build the controller
		$this->controller = $this->object_factory->build_controller($this->router->get_controller());
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('post_controller_init', array("app"=>$this));
		
	}
	
	
	public function _run()
	{
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('app_start',array("app"=>$this));
		
		try
		{
			// Instanciate the controller
			// Takes the route property as an arguent
			$this->controller->_execute(); // can this method name be hookible?? try to arraange that
			
			// Tell all the plugins hooked to this event that it occured.
			$this->plugin_manager->_hook('app_end',array("app"=>$this));

		}
		catch(Contoller_Exception $e)
		{
			
			// Tell all the plugins hooked to this event that it occured.
			$this->plugin_manager->_hook('app_exception',array("exception"=>$e));
			
			if($exception->return_url() !== '') header('location:'.$exception->return_url());
			
			error_log($exception->__toString());
			exit;	
			
		}
		
	}
	
}

?>