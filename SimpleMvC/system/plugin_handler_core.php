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
	
	
	public function __construct();
	
	
	// Accept a callback name and options
	// Add it to the hooks property
	public function add_plugin($plugin_name, array $callback_options)
	{
		$this->hooks[$plugin_name][]=$callback_options;
	}
	
	
	// Resolve callback options to run callback(s)
	public function load_plugin();
	
	
	// Call load_plugn to reslolve callback
	// Run_user_func($this->hook['URI_REWRITE']['callback'])
	private function _plugin($hook_name);
	
}

?>