<?php

class authenticate_model
{
	public $login;
	public $pass;
	private $db;
	public function __construct(array $params)
	{
		$this->login=$params['login'];
		$this->pass=$params['pass'];
		$this->db=new PDO('mysql:host=localhost;dbname=simplemvc;charset=utf8', 'root','', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	
	public function login()
	{
		$stmnt=$this->db->prepare("select*from users where first_name=:name and password=:pass");
		$stmnt->execute(array(":name"=>$this->login,":pass"=>$this->pass));
		$result=$stmnt->fetch(pdo::FETCH_OBJ);
		if(!$result==NULL)
		{
			$_SESSION['loggedin']=true;
			$_SESSION['user']=$result->first_name;
			return true;
		}
		
		else
		{
			return false;
		}
	}
}

?>