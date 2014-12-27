<?php
namespace SimpleMvC\system\config;

/**
 * @todo Complete this object's interface
 * 
 * @todo figure out a way to allow the methods to be overloaded throught this plugins api
 */

class config
{
	public $object_factory;
	public $autoloader;
	public $plugin_manager;
	public $autoloader_dir;
	
	public function __construct()
	{
		
		// set the directory of the autoloader
		$this->autoloader_dir = core_directory.'/system/autoloader.php';
		
		// start the plugin manager
		$this->init_plugin_manager();
				
		// Set and register our autoloader file
		$this->init_autoloader();
		
		// Create and set and instance of the object factory
		$this->init_object_factory();
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('post_config', array("config"=>$this));
		
	}
	
	
	public function init_plugin_manager()
	{
		
		require_once(core_directory.'/system/plugin_manager.php');
		$this->plugin_manager = new \SimpleMvC\system\plugin_manager();
		
		// Tell all the plugins of the system start event
		$this->plugin_manager->_hook('system_start', array("config"=>$this));
	}
	
	
	public function init_autoloader()
	{
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('pre_autoloader_init', array("config"=>$this));
		
		// Require in the autoloader
		require_once($this->autoloader_dir);
		
		// Register the autoloader function from the system Namespace
		spl_autoload_register('\SimpleMvC\system\autoloader');
		
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('post_autoloader_init', array("config"=>$this));
		
	}
	
	
	public function init_object_factory()
	{
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('pre_factory_init', array("config"=>$this));
		
		// Create and set the object factory
		$this->object_factory = new \SimpleMvC\system\object_factory;
		
		// Tell all the plugins hooked to this event that it occured.
		$this->plugin_manager->_hook('post_factory_init', array("config"=>$this));
		
		
	}
		
}
 

?>