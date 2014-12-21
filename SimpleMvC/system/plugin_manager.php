<?php
namespace SimpleMvC\system;

use SimpleMvC\plugins;

/**
 * @package plugin_manager
 * 
 * The Simple MvC plugin manager
 * 
 * @todo Add obj factory to controller. Give plugin path a check
 * 
 * @todo If the plugin exits but no method or class return a better indicatior
 */
 
class plugin_manager
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
	
	
	// Check to see if our plugin is loaded  and can be called
	public function plugin_loaded($hook_name)
	{
		
		if(isset($this->hooks[$hook_name]))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}
	
	// Tell all the plugins(event handlers) associated with the event that happend to do their stuff
	// @var data = data needed to manipulate the event based envirolment ect.
	public function _hook($event, $data)
	{
		foreach($this->hooks as $hook)
		{
			if($hook['type'] == $event)
			$this->_plugin($hook); // run the function associated with the event and pass it the data var
		}
	}
	
	
	// Run the plugin and return method value or class instance of plugin
	public function _plugin($hook_name, $plugin_args=array())
	{
		
		if(!isset($this->hooks[$hook_name]))
		{
			exit('The plugin '.$hook_name.' was not loaded into the plugin manager');
		}
		
		$plugin_name=		$hook_name;
		$plugin_path=		$this->hooks[$hook_name]['path'];						
		$plugin_class=		empty($this->hooks[$hook_name]['class'])     ? NULL : "\\SimpleMvC\\plugins\\".$this->hooks[$hook_name]['class']; // Prepend NS
		$plugin_function=	empty($this->hooks[$hook_name]['function'])  ? NULL : "\\SimpleMvC\\plugins\\".$this->hooks[$hook_name]['function'];// Prepend NS
		$plugin_params=		empty($this->hooks[$hook_name]['arguments']) ? $plugin_args : array_merge($this->hooks[$hook_name]['arguments'],$plugin_args);
		
		if(! is_file(core_directory.$plugin_path))
		{
			exit("your ".$hook_name." path directory'".$plugin_path."' is invalid");
		}
		
		include(core_directory.$plugin_path); // Consider making all paths reletive to plugins directory
		
		if($plugin_class && class_exists($plugin_class,FALSE))
		{
			return new $plugin_class();
		}
		else
		{
			return call_user_func($plugin_function,$plugin_params);
		}
		
	}

}

?>