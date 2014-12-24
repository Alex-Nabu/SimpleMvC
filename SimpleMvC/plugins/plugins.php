<?php

/**
 * @todo revise the plugin notation
 */	
	
	
	// $plugins['routing']=array(
	
	// "function"=>"rewrite_uri",
	// "class"=>NULL,
	// "path"=>"/plugins/routing_plugin.php"
	
	// );
	
	
	// A plugin can either be a class object to return or a function to run
	// Both should cover all possibilities
	// EXP. Should you want an object instanciated in a specific way just write a plugin function to do so
	
	$plugins['example']=array(
	
	"function"=>"render", // The function name to run
	"class"=>"twig_templage_engine_plugin",// The class name to instanciate
	"path"=>"/plugins/twig.php" // The literal path of the plugin reletive to the core directory
	
	);
	
?>