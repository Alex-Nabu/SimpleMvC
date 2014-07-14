<?php

/*

--------------------------------INITIAL DOCUMENTATION--------------------------------

THIS IS GROUND ZERO FOR THE FRAMWORK. AFTER THE HTCACCESS FILE ROUTES THE USER TO THIS
FILE IT INITIALISES SESSIONS AND GETS THE MAIN CONFIG FILE. AFTER WHICH THE USERS ACTION
IS PARSED BY OUR ROUTER ACTION IT THEN CONTINUES TO CREATE AN INSTANCE OF OUR OBJECT FACTORY
TO BUILD WHATWEVER CONTROLLER WAS INITIATED BY THE USERS REQUEST

-------------------------------------------------------------------------------------

*/

session_start();
require_once '../SimpleMvC/config/config.php';

	$route=isset($_GET['action'])?new router_controller($_GET['action']):new router_controller($_GET['action']="/index");
	$route->parse_route();
	$object_factory=new object_factory_inc;
	$controller=$object_factory->build_controller($route->get_controller(),$route->get_request_data());
	
?>
