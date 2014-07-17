<?php

function loadClass($class)
{
	$pattern='/[A-Za-z0-9\_]+(\_(model|view|controller|inc))/';
	$class=strtolower($class);
	preg_match($pattern,$class,$type_match);
	
	switch($type_match[2])
	{
		case "model":
		$file=core_directory.'models/'.$class.'.php';
		if(is_readable($file))
		require_once $file;
		else
		echo " The file:".$file." does not exist on this server";
		break;
		
		case "view":
		$file=core_directory.'views/'.$class.'.php';
		if(is_readable($file))
		require_once $file;
		else
		echo " The file:".$file." does not exist on this server";
		break;
				
		case "controller":
		$file=core_directory.'controllers/'.$class.'.php';
		if(is_readable($file))
		require_once $file;
		else
		echo " The file:".$file." does not exist on this server";

		break;
		
		case "plugin":
		$file=core_directory.'plugins/'.$class.'.php';
		if(is_readable($file))
		require_once $file;
		else
		echo " The file:".$file." does not exist on this server";
		break;
		
		default:
		echo " The file:".$class." does not exist on this server";
		
	}
	
}

spl_autoload_register('loadClass');
?>