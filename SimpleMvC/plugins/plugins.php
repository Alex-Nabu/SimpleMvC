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
	
?>