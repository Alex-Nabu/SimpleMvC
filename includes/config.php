<?php
define("server_root",$_SERVER["DOCUMENT_ROOT"]);
define("site_root",server_root);

function loadClass($class)
{
	$pattern='/[A-Za-z0-9]+(\_(model|view|controller|inc))/';
	$class=strtolower($class);
	preg_match($pattern,$class,$type_match);
	
	switch($type_match[2])
	{
		case "model":
		$file=site_root.'/models/'.$class.'.php';
		if(is_readable($file))
		require_once $file;
		else
		echo " The file:".$file." does not exist on this server";
		break;
		
		case "view":
		$file=site_root.'/views/'.$class.'.php';
		if(is_readable($file))
		require_once $file;
		else
		echo " The file:".$file." does not exist on this server";
		break;
				
		case "controller":
		$file=site_root.'/controllers/'.$class.'.php';
		if(is_readable($file))
		require_once $file;
		else
		echo " The file:".$file." does not exist on this server";

		break;
		
		case "inc":
		$file=site_root.'/includes/'.$class.'.php';
		if(is_readable($file))
		require_once $file;
		else
		echo " The file:".$file." does not exist on this server";
		break;
		
		default:
		echo " The file:".$file." does not exist on this server";
		
	}
	
}

spl_autoload_register('loadClass');
?>