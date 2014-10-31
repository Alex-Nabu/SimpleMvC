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
	$this->model = $this->object_factory->build_model('authentication', 'localhost', 'mydb'); // Create a model
	
 }
  
  
  public function _execute()  // Core function to run
  {
  	
	// Aloow our model to do something may be a db call or query or whatever
	$words = $this->model->talk();
	
	// Default view takes an array template list and and optional array of params
	// Dont like this view approach? plugin another via the plugin manager
  	$this->view=$this->object_factory->build_view($this->view_template, array("words"=>$words));
  	$this->view->render();
	
  }

}

?>