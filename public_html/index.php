<?php

/*
 * --------------------------------INITIAL SETUP-------------------------------
 * 
 * The user points to the directory that conatins their files. A simple check
 * is done to varify that the directory is in fact correct and the main config
 * file can be read.
 * ----------------------------------------------------------------------------
 */

 	// Edit only this
	$core_directory='../SimpleMvC/';
	
	// Try to load the config file
	if(!file_exists($core_directory.'config/config.php'))
	exit("Path to main config not set. Please set the path to the  core_directory in the file ".__FILE__);
	

/*
 * -------------------------INITIALISE THE APPLICATION-------------------------
 * 
 * This is ground zero for the framwork. After the htcaccess file routes the user
 * to this file it initialises sessions and gets the main config file. after 
 * which the users action is parsed by our router it then continues to create
 * an instance of our object factory to build whatwever controller was initiated 
 * by the users request
 * ----------------------------------------------------------------------------
 */
 
 
	session_start();
	require_once $core_directory.'config/config.php';

	$route=isset($_GET['action'])?new router_controller($_GET['action']):new router_controller($_GET['action']="/index");
	$route->parse_route();
	$object_factory=new object_factory_inc;
	$controller=$object_factory->build_controller($route->get_controller(),$route->get_request_data());
	
?>
