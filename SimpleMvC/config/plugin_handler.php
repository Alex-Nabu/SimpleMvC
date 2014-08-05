<?php

load_plugin("controller_rewrite");
add_plugin("controller_rewrite",function($uri){
	
	// Route the uri to the controller
	return $controller;
})

?>