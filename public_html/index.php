<?php

/*
 * --------------------------------INITIAL SETUP-------------------------------
 * 
 * The user points to the directory that contains their files. A simple check
 * is done to verify that the directory is in fact correct and the main config
 * file can be read.
 * ----------------------------------------------------------------------------
 */

 	// Edit only this
 	$core_directory='../SimpleMvC/';
		
	// Make absolute path or default to previous value
	$core_directory=(realpath($core_directory))?realpath($core_directory):$core_directory;
	
	// Ensure there's is a trailing slash
	$core_directory=rtrim($core_directory, '/').'/';
	
	// Set core directory constant 
	define('core_directory',$core_directory);
	
	// Try to load the config file
	if(!file_exists(core_directory.'config/config.php'))
	exit("Path to main config not set. Please set the path to the  core_directory in the file ".__FILE__.". \r\n
	      Your Core directory is currently initialized as ".core_directory);
	
	
/*
 * -------------------------INITIALISE THE APPLICATION-------------------------
 * 
 * This is ground zero for the framework. After the htcaccess file routes the user
 * to this file it initializes sessions and gets the main config file. after 
 * which the users action is parsed by our router it then continues to create
 * an instance of our object factory to build whatever controller was initiated 
 * by the users request
 * ----------------------------------------------------------------------------
 */

 
	session_start();
	require_once core_directory.'config/config.php';

	$route=isset($_GET['action'])?new router_controller($_GET['action']):new router_controller($_GET['action']="/index");
	$route->parse_route();
	$object_factory=new object_factory_model;
	$controller=$object_factory->build_controller($route->get_controller(),$route->get_request_data());
	
?>
