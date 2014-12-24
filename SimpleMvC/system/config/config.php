<?php
namespace SimpleMvC\config;

/**
 * @todo Complete this object's interface
 * 
 * @todo figure out a way to allow the methods to be overloaded throught this plugins api
 */

class config
{
	public $factory;
	public $autoloader;
	public $plugin_manager;
	
	public function __construct()
	{
		
		$this->init_plugin_manager();
		
		
		$this->factory = new \SimpleMvC\system\object_factory;
		
		$this->plugin_manager = $this->factory->build_plugin_manager();
		
		$this->load_controller_exceptions();	
			
	}
	
	
	public function init_plugin_manager()
	{
		require_once(core_directory.'/system/plugin_manager.php');
		$this->plugin_manager = new \SimpleMvC\system\plugin_manager();
		
		// Tell all the plugins of the system start event
		$this->plugin_manager->_hook('system_start', $this);
	}
	
	
	public function init_autoloader()
	{
		// Require in the autoloader
		require_once(core_directory.'/system/autoloader.php');
		
		// Register the autoloader function from the system Namespace
		spl_autoload_register('\SimpleMvC\system\autoloader');
		
		// Tell all the plugins of auto_loader init
		$this->plugin_manager->_hook('init_autoloader', $this);
	}
	
	
	public function load_controller_exceptions()
	{
		// $this->plugin_manager->hook("controller_exceptions");
		
		// Load up controller exceptions file
		require_once(core_directory.'/system/controller_exception.php');
		
	}
	
}
 

?>