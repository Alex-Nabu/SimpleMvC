<?php

/**
 * @package plugin_manager
 * 
 * The Simple MvC plugin manager
 */
 
class plugin_manager_core
{
	
	private $hooks;
	private $plugin_in_progress;
	
	
	public function __construct()
	{
		include(core_directory.'/plugins/plugins.php');
		$this->hooks=& $plugins;	
	}
	
	
	// Accept a callback name and options
	// Add it to the hooks property
	public function add_plugin($plugin_name, array $callback_options)
	{
		$this->hooks[$plugin_name]=$callback_options;
	}
	
	
	// Resolve callback options to run callback(s)
	// public function load_plugin();
	
	
	// Call load_plugn to reslolve callback
	// Run_user_func($this->hook['URI_REWRITE']['callback'])
	public function _plugin($hook_name)
	{
		
		if(!isset($this->hooks[$hook_name]))
		{
			exit('The plugin '.$hook_name.' was not loaded into the plugin manager');
		}
		
		$plugin_name=$hook_name;
		$plugin_path=$this->hooks[$hook_name]['path'];
		$plugin_function=$this->hooks[$hook_name]['function'];
		$plugin_arguments=$this->hooks[$hook_name]['arguments'];
		$plugin_class=isset($this->hooks[$hook_name]['class'])?$this->hooks[$hook_name]['class']:NULL;
		
		include(core_directory.$plugin_path);
		
		if($plugin_class && class_exists($plugin_class))
		{
			
		}
		
		return call_user_func($this->hooks[$hook_name]['function'],$this->hooks[$hook_name]['arguments']);
		
	}

}

?>