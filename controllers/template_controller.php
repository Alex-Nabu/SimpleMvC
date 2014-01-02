<?php
class template_controller
{
	
protected $parameters=array();
protected $view_template=array('header'=>'tpl_header','body'=>'tpl_body','footer'=>'tpl_footer');
protected $object_factory;

public function __construct(object_factory_inc $factory,array $parameters )
 {
	$this->object_factory=$factory;
	$this->parameters=$parameters;
	//..whatever needs to be done before we can varify.not much actually
	
	try
	{
			
	$this->varify_controller();
	$this->execute();
	
	}
	
	catch(Exception $e)

	{
		//whatever should happen if varify throws an exception
		
		switch($e->getMessage())
		{ 
		    /*so simple. if something is wrong we throw a message calling a controller to
		    throw those messages  would be better*/
			
			default:
			echo $e->getMessage();
		}
	}	
	
  }
  
  private function varify_controller()
  {
	  
/*all is good here nothing needs to be done. probly should do something
 tho like check if logged in or something i mean come on a empty function */ 
 
  }
  
  private function execute()
  
  { 
    $view=$this->object_factory->build_view($this->view_template,$args=array());//build our view
	$view->render();//render this page
  }

}

?>