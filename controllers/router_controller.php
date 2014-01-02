<?php

class router_controller
{
	private $controller="index"; //The default controller is set to the index,
	private $request;
	private $request_data=array();

	public function __construct($request)
	{
		$this->request=$request;
	}
	
	public function get_uri()
	{
		return $this->request;
	}
	
	
	public function get_controller()
	{
		return $this->controller;
	}

	
	public function get_request_data()
	{
		return $this->request_data;
	}
	
	
	private function name_array_data($request)
	{
		/*this functions sole purpose is to name the keys in a way that can easily be reffrenced.
		the naming is done dynamically by assigning the key names based on the value*/
		
		
		$named_request_data=array();
		
		foreach($request as $value)
		{
			$named_request_data[$value]=$value;
		}

		return $named_request_data;
	}
	
	
	public function parse_route()
	{
	$this->request=array_filter(explode("/",$this->request));
	$this->controller=array_shift($this->request);
	$this->request_data=$this->name_array_data($this->request);
	
	/*this function upon recieving the request will break it up
	into its relavant parts, the first being the controller and the 
	second being all parameters that are being passed to the relavant controller.
	if there are no parameters it defaults to the index controller*/
	
	}
}
?>