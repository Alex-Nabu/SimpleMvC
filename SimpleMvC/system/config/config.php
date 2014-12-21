<?php
namespace SimpleMvC\config;

class config
{
	public $factory;
	public $autoloader;
	public $plugin_manager;
	
	public function __construct()
	{
		
		// Require in the autoloader
		require_once(core_directory.'/system/autoloader.php');
		
		// Register the autoloader function from the system Namespace
		spl_autoload_register('\SimpleMvC\system\autoloader');
		
		$this->factory = new \SimpleMvC\system\object_factory;
		
		$this->plugin_manager = $this->factory->build_plugin_manager();
		
		$this->load_controller_exceptions();	
			
	}
	
	
	public function load_controller_exceptions()
	{
		// $this->plugin_manager->hook("controller_exceptions");
		
		// Load up controller exceptions file
		require_once(core_directory.'/system/controller_exception.php');
		
	}
	
}
 

?>