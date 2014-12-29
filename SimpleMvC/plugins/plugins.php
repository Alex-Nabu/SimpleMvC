<?php

/**
 * @todo revise the plugin notation
 */	
	
	
	// $plugins['routing']=array(
	
	// "function"=>"rewrite_uri",
	// "class"=>NULL,
	// "path"=>"/plugins/routing_plugin.php"
	
	// );
	
	
	// A plugin is a function invoked at certain event calls to modify/add functionality

	
	$plugins['example']=array(
	
	"event"=>"post_autoloader_init",
	"function"=>"setup_composer", // The function name to run
	"path"=>"/plugins/composer_init.php" // The literal path of the plugin reletive to the core directory
	
	);
	
?>