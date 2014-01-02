<?php

class index_loggedin_controller extends index_controller
{
	
    protected $parameters=array();
    protected $view_template=array('header'=>'loggedin_header','body'=>'loggedin_body','footer'=>'loggedin_footer');
    protected $object_factory;

	
	public function __construct(object_factory_inc $factory, array $params)
	{
		$this->object_factory=$factory;
		$this->parameters=$params;
		
		try 
		{
		$this->varify_controller();	
		$this->execute();
		//print_r($params);
		}
		
		catch(Exception $e)
		{
			echo $e->getMessage();
		}

	}
	
	private function varify_controller()
	{
		if(!isset($_SESSION['loggedin']))//not logged on
		{
			throw new Exception ("you are not logged on and need to login to acess this page <br/>");
		}
		
	}
	
  private function execute()
  
  { 
    $view=$this->object_factory->build_view($this->view_template,$args=array());
	$view->render();
  }
  
}

/*
stands with the other variations of the index controller to show how easily a relationship
between controllers may be defined
*/

?>