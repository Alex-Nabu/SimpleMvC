<?php
/**
 * 
 * @todo modify plugin to create the composer.json and vendor file and folder automatically if they dont exist.
 * 
 * @todo when done first todo remove that file and folder as its not part of the framework
 * 
 */
namespace SimpleMvC\plugins;

function setup_composer($data)
{
	$composer_autoloader = core_directory.'/vendor/autoload.php';
	require_once($composer_autoloader);
}

?>