<?php
namespace SimpleMvC\controllers;

use Exception; // Since SimpleMvC uses Namespaces we have to tell the current NS to use these global objects
use SimpleMvC\system\Controller_Exception;


class index_page_controller implements \SimpleMvC\system\controller_interface
{

 private $view_template=array('header'=>'index_header','body'=>'index_body','footer'=>'index_footer');
 private $object_factory;
 private $model;
 private $view;

 public function __construct($factory)
 {
 	
 	$this->object_factory=$factory; // Store object factory
	$this->object_factory->build_model('authentication', 'localhost', 'mydb'); // Create a model
	
 }
  
  
  public function _execute()  // Core function to run
  {
  	
  	$this->view=$this->object_factory->build_view($this->view_template, array());
  	$this->view->render();
	
  }

}

?>