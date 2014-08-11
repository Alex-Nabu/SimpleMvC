<?php

/**
 * @package plugin_manager
 * 
 * The Simple MvC plugin manager
 */
 
class plugin_manager_core
{
	
	private $hooks;
	
	public function __construct()
	{
		$this->load_plugins();
	}
	
	
	// Accept a callback name and options
	// Add it to the hooks property
	public function add_plugin($plugin_name, array $callback_options)
	{
		$this->hooks[$plugin_name]=$callback_options;
	}
	
	
	// Load the plugins.php from the plugins dir
	public function load_plugins()
	{
		
		if(is_file(core_directory.'/plugins/plugins.php'))
		{
			include(core_directory.'/plugins/plugins.php');
			
			if(isset($plugins) && is_array($plugins))
			{
				$this->hooks=& $plugins;
			}
			else
			{
				return;
			}
			
		}
		else
		{
			return;
		}
		
	}
	
	
	// Call load_plugn to reslolve callback
	// Run_user_func($this->hook['URI_REWRITE']['callback'])
	public function _plugin($hook_name)
	{
		
		if(!isset($this->hooks[$hook_name]))
		{
			exit('The plugin '.$hook_name.' was not loaded into the plugin manager');
		}
		
		$plugin_name=		$hook_name;
		$plugin_path=		$this->hooks[$hook_name]['path'];
		$plugin_arguments=	$this->hooks[$hook_name]['arguments'];
		$plugin_class=		empty($this->hooks[$hook_name]['class'])?$this->hooks[$hook_name]['class']:NULL;
		$plugin_function=	empty($this->hooks[$hook_name]['function'])?$this->hooks[$hook_name]['function']:NULL;
		
		if(! is_file(core_directory.$plugin_path))
		{
			exit("your ".$hook_name." path directory'".$plugin_path."' is invalid");
		}
		
		include(core_directory.$plugin_path);
		
		if($plugin_class && class_exists($plugin_class))
		{
			return new $plugin_class();
		}
		elseif($plugin_function)
		{
			return call_user_func($this->hooks[$hook_name]['function'],$this->hooks[$hook_name]['arguments']);
		}
		else
		{
			return FALSE;
		}
		
	}

}

?>