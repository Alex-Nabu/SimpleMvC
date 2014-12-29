<?php
namespace SimpleMvC\plugins;

function setup_composer($data)
{
	$composer_autoloader = core_directory.'/vendor/autoload.php';
	require_once($composer_autoloader);
}

?>