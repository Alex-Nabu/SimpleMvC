<?php

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
 * This is ground zero for the framework. After the htcaccess file routes the user
 * to this file it initializes sessions and gets the main config file. after 
 * which the users action is parsed by our router it then continues to create
 * an instance of our object factory to build whatever controller was initiated 
 * by the users request
 * ----------------------------------------------------------------------------
 */

 
	session_start();
	
	require_once($main_config);
	
	// Instanciate the object factory
	// Used to create other objects
	$object_factory=new object_factory_core;
	
	// Default uri to index if none provided
	$uri=isset($_GET['action'])?$_GET['action']:'index';
	
	// Instanciate the router
	// Default to index controller if no uri present
	$router=$object_factory->build_router($uri);
	
	// Instanciate the controller
	// Takes a string with the controller name
	$controller=$object_factory->build_controller($router->get_controller());
	
	try
	{
		
		$controller->_varify();
		$controller->_execute();
		
	}
	catch(Controller_Exception  $e)
	{
		
		if($e->return_url() !== '')
		{
			header('location:'.$e->return_url());
		}
		else
		{
			exit($e->getMessage());
		}
		
	}
	
?>