<?php
namespace SimpleMvC\system;

/*
 * --------------------------------INITIAL SETUP-------------------------------
 * 
 * The user points to the directory that contains their files. A simple check
 * is done to verify that the directory is in fact correct and the main config
 * file can be read.
 * ----------------------------------------------------------------------------
 */

 	// Set core directory
 	$core_directory='../SimpleMvC';
		
	// Make absolute path or default to previous value
	$core_directory=(realpath($core_directory))?realpath($core_directory):$core_directory;
	
	// Ensure there's no trailing slash
	$core_directory=rtrim($core_directory, '/');
	
	// define core directory constant 
	define('core_directory',$core_directory);
	
	// Set path to the main config
	$main_config=core_directory.'/system/config/config.php';
	
	// Try to load the main config 
	if(!file_exists($main_config))
	exit("Path to main config not set. Please set the path  in the file ".__FILE__.". \r\n
	      Your Config file is currently initialized as ".$main_config);
	
		
/*
 * -------------------------INITIALISE THE APPLICATION-------------------------
 * 
 * This is ground zero for the framework.
 * ----------------------------------------------------------------------------
 */

	// Require the main config
	require_once($main_config);
	
	// Instanciate the main configuration object
	$config = new \SimpleMvC\system\config\config();
	 
	// Instanciate the framework
	$app = new SimpleMVC($config);
	
	// Run the app
	$app->_run();
	
	
?>