<?php
namespace SimpleMvC\controllers;


/**
 * @todo Update with comments to use for example controller
 * 
 */

use Exception;
use SimpleMvC\system\Controller_Exception;


class index_page_controller implements \SimpleMvC\system\controller_interface
{

 protected $view_template=array('header'=>'index_header','body'=>'index_body','footer'=>'index_footer');
 protected $object_factory;
 protected $model;
 protected $view;

 public function __construct($factory)
 {
 	
 	$this->object_factory=$factory; // Store object factory
	$this->object_factory->build_model('authentication', array()); // Create a model
	
 }
  
  
  public function _execute()  // Core function to run
  {
  	
  	$this->view=$this->object_factory->build_view($this->view_template, $this->view_args);
  	$this->view->render();
	
  }

}

?>