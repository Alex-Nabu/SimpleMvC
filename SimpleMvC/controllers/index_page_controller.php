<?php

/*
---------------------------------INITIAL DOCUMENTATION--------------------------------
THIS IS MY INDEX CONTROLLER AS IT IMPIED IT CONTROLS THE INDEX SECTIONS OF MY 
WEBSITE/APP.IT HAS THE SAME INTERFACE ANY CONTROLLER WITHIN THE FRAMEWORK.


PARAM:$parameters
--------------------------------------------------------------------------------------
AN ASSOCIATIVE ARRAY OF ARGUEMENTS THAT THE IS PASSED TO THE CONTROLLER FROM THE 
ROUTER THROUGH THE OBJECT FACTORY. THE ARRAY KEYS CAN BE THE SAME AS THEIR
VALUES BECAUSE CONTROLLERS EXECUTE IN ONE DIRECTION SO THEY ARE AWARE OF THE VALUES 
THEY HAVE AND NEED TO HAVE. BUT WHAT ABOUT VALUES THE USERES ENTER THAT THEY COULDNT
POSSIBLY KNOW? WELL SIMILARLY YOU ARE INTERPRETING A REQUEST YOU WOULD KNOW THE NAME 
OF THE POST OR GET VARIBALES YOU ASK THE USER TO ENTER A VALUE FOR BUT WHAT ABOUT THOSE 
PASSED IN  BY THE URL BAR? BY INTERPRITING  A URL TO FEED THE END USER SOME RESOURCE(S)
YOU KNOW WHAT AND IN WHAT ORDER PARAMETERS ARE EXPECTED FOR EXAMPLE IN 
THE INDEX_SEARCH CONTROLLER THE THIRD ARGUEMENT AFTER THE "S" ARGUMENT
WHICH INDICTES THE END USER WANTS TO SEARCH IS ALWAYS WHAT THE END USER'S QUERY IS


PARAM:$view_template
----------------------------------------------------------------------------------------
AN ASSOCIATIVE ARRAY PASSED TO THE VIEW BUILDER CONTAINING THE NAMES MINUS ".php" EXTENSIONS
OF THE FILES USED TO BUILD THE HEADER,BODY AND FOOTER OF THE WEBPAGE TO BE DISPLAYED IN THE 
CASE THAT THE CONTROLLER DOES HAVE A VIEW.


PARAM:$object_factory
------------------------------------------------------------------------------------------
AN INSTANCE OF THE OBJECT FACTORY. USED TO INITIANTE THIS AND OTHER POSSIBLE OBJECTS THIS
CONTROLLER MAY WANT TO CREATE


PARAM:$model
------------------------------------------------------------------------------------------
AN INSTANCE OF THE MODEL OR MODELS USED BY THIS CONTROLLER TO DO THE BUSINESS LOGIC.
NOT A PART OF THE INTERFACE BECAUSE NOT ALL CONTROLLERS USE A MODEL


METHOD:constructers
------------------------------------------------------------------------------------------
BECAUSE CONTROLLERS DO ONE THING IN ONE WAY AND THEY DO IT IMMEDIATLY THE CONSTRUCTERS
ESSENTILY EXECUTE THE CONTROLLERS MAIN EXECUTE METHOD. THEY ALSO CHECK TO ENSURE THAT 
THE OBJECT CAN BE EXECUTED.PROPERTIES ARE THE FIRST THING INITIALIZED BY THE CONSTRUCTER


METHOD:varify
------------------------------------------------------------------------------------------
VARFIES THAT THE CONSTROLLER CAN BE EXECUTED SUCESSFULLY AND ENSURES THAT THE RIGHT CONTROLLER
IS BEING EXECUTED. IN THE CASE OF AN ERROR THROWS AN EXCEPTION TO BE CAUGHT IN THE CONSTRUCTER
WHICH THEN DEFINES HOW THAT SHOULD BE HANDLED


METHOD:execute
-------------------------------------------------------------------------------------------
EXECUTES WHATEVER THE CONTROLLER WAS INTENDED TO DO
*/



class index_page_controller
{
		
	protected $parameters=array();
	protected $view_template=array('header'=>'index_header','body'=>'index_body','footer'=>'index_footer');
	protected $object_factory;
	protected $model;
	private $model_args=array();
	protected $view;
	private $view_args=array();

	public function __construct(object_factory_core $factory)
	{
		
		$this->object_factory=$factory;
		
	}
  
   public function _varify()
   {
   	
  	//	throw new controller_exception("Error Processing Request", "http://google.com");
		
   }
  
  public function _execute()  
  {
  	
	$this->view=$this->object_factory->build_view($this->view_template, $this->view_args);
	$this->view->render();
	
  }

}

?>