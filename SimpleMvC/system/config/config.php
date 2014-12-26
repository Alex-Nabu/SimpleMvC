<?php
namespace SimpleMvC\system\config;

/**
 * @todo consider moving obj_factory here to use plugins at startup
 * 
 */
 
// Require in the autoloader
require_once(core_directory.'/system/autoloader.php');
 
 
// Register the autoloader function from the system Namespace
spl_autoload_register('\SimpleMvC\system\autoloader');


// Load up controller exceptions file
require_once(core_directory.'/system/controller_exception.php');

?>