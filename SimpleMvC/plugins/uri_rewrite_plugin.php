<?php

function rewrite_uri($args)
{
	$uri=$args['uri'];
	
	if(preg_match('/index/', $uri))
	{
		return 'index';
	}
	elseif(preg_match('/(\w)/', $uri,$request))
	{
		$_GET['business']=$request[1];
		return 'business';
	}
	else
	{
		return 'error_page';
	}
}

?>