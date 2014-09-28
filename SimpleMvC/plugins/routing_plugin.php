<?php
namespace SimpleMvC\plugins;

// Interface with AltoRouter to map uris to controllers
function rewrite_uri($args)
{
	$request = $args['request'];
	
	$request_method = $args['method'];
	
	$AltoRouter = new AltoRouter_plugin();
	
	// If we have a routes file load them
	if(is_file(core_directory.'/plugins/libs/AltoRouter/routes.php'))
	{
			include(core_directory.'/plugins/libs/AltoRouter/routes.php');
			
			if(isset($routes) && is_array($routes))
			{
				$routes=& $routes;
			}
			else
			{
				exit("Invalid routes file");
			}

	}
	else
	{
		exit("Invalid routes file");
	}
	
	$AltoRouter->addRoutes($routes);
	
	$mathes = $AltoRouter->match($request, $request_method);
	
	if(empty($mathes))
	return '404_page';
	
	// If the we have any params from the url
	if(!empty($mathes['params']))
	{
		foreach ($mathes['params'] as $key => $value) 
		{
			$_GET[$key] = $value;
		}
	}
	
	return $mathes['target'];
	
}

?>