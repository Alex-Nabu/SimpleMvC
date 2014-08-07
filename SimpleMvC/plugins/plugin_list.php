<?php
	
	$plugins['rewrite_controller']=array(
	
	"fucntion"=>"rewrite_uri",
	"class"=>"rewrite_controller_plugin",
	"path"=>"/plugins/rewrite.php",
	
	);
	
	$plugins['twig']=array(
	
	"fucntion"=>"render",
	"class"=>"twig_templage_engine_plugin",
	"path"=>"/plugins/twig.php"
	
	);
	
	

	$plugin_mangaer->add_plugin("rewrite_controller", $plugins);
	$plugin_manager->add_plugin("twig", $plugins);

?>