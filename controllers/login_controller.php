<?php
/* stricktly for example purposes or modification. i would have filtered in the model */

class login_controller
{
	private $params=array();
	private $object_factory;
	private $user_name;
	private $password;
	private $model;
	private $model_arguments;
	private $result;
	
	public function __construct(object_factory_inc $factory,array $parameters)
	{
		$this->object_factory=$factory;
		$this->params=$parameters;
		$this->user_name=$_POST['name'];
		$this->password=$_POST['password'];
		try 
		{
			$this->varify();
			$this->execute();
		}
		
		catch(Exception $e)
		{
			header("location:/index");
		}
		
		
	}
	
	private function varify()
	{
		$this->filter_login_name();
		$this->filter_password();
	}
	
	public function filter_login_name()
	
	{
		//just fot examples sake please filter all input properly
		if (!isset($this->user_name))
		throw new Exception("please enter your username");
		else
		return true;
	}
	
	public function filter_password()
	
	{
		//again just for examples sake
		if (!isset($this->password))
		throw new Exception("please enter your password");
		else
		return true;

	}
	
	public function execute()
	{
		$this->model_arguments['login']=$this->user_name;
		$this->model_arguments['pass']=$this->password;
		$this->model=$this->object_factory->build_model('authenticate',$this->model_arguments);
		$this->result=$this->model->login();
		if($this->result)
		{
			header('location:/index');
		}
		else
		{	$_SESSION['error']=true;
			header('location:/index');
		}
	}
}

?>