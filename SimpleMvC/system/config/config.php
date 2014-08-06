<?php

function loadClass($class)
{
	$pattern='/[A-Za-z0-9\_]+(\_(model|view|controller|plugin|core))/';
	$class=strtolower($class);
	preg_match($pattern,$class,$type_match);
	
	switch($type_match[2])
	{
		
		case "model":
			
		$file=core_directory.'/models/'.$class.'.php';
		if(is_readable($file))
		require($file);
		else
		echo " The file:".$file." does not exist on this server";
		break;
		
		case "view":
			
		$file=core_directory.'/views/'.$class.'.php';
		if(is_readable($file))
		require($file);
		else
		echo " The file:".$file." does not exist on this server";
		break;
				
		case "controller":
			
		$file=core_directory.'/controllers/'.$class.'.php';
		if(is_readable($file))
		require($file);
		else
		echo " The file:".$file." does not exist on this server";
		break;
		
		case "plugin":
			
		$file=core_directory.'/plugins/'.$class.'.php';
		if(is_readable($file))
		require($file);
		else
		echo " The file:".$file." does not exist on this server";
		break;
		
		case "core":
			
		$file=core_directory.'/system/'.$class.'.php';
		if(is_readable($file))
		require($file);
		else
		exit(" The file:".$file." failed to load");
		break;
		
		default:
		echo " The file:".$class." does not exist on this server";
			
	}
	
}

spl_autoload_register('loadClass');

// Dir of controller exceptions
$exceptions=core_directory.'/system/config/controller_exception.php';
require_once($exceptions);

?>