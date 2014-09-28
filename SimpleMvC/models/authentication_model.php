<?php
namespace SimpleMvC\models;

use PDO;
use Exception;

class authentication_model
{
	
	// The database connection
	private $conn;
	
	public function __construct(array $params)
	{
		
		try
		{
			$this->conn=new \pdo("mysql:host=localhost;dbname=alex_swatnotes;charset=utf8","alex_swatnotes","swatnotesfeind");
		}
		catch(pdoexception $e)
		{
			error_log($e->__toString());
			exit("sorry the connection to database has failed ");
		}
		
	}
	
	
	public function login ($u_name,$u_password)
	{
		$conn=$this->conn;
		$id_statment=$conn->prepare("select id from user where user.name=? or user.email=?");
		$id_statment->execute(array($u_name,$u_name));
		$id_result=$id_statment->fetch(PDO::FETCH_OBJ);
		$this->user_id=$id_result->id;
		
		// if($this->brute_check($this->user_id))
		// return false; // Comment out to disable retry lock
		
		$this->getsalt($this->user_id);
		$this->user_password=$this->hash_pass($u_password,$this->user_salt);
		$stmnt=$conn->prepare("select*from user where user.id=:uid  and pass=:pass");
		$stmnt->execute(array(":uid"=>$this->user_id,":pass"=>$this->user_password));
		$result=$stmnt->rowcount();
		if($result==1)
		{
			$result=$stmnt->fetch(pdo::FETCH_OBJ);
			$this->user_name=$result->name;
			$this->user_password=$result->pass;
			
			//registers the sessions to be used on the next page
			$_SESSION['loggedin']=true;
			$_SESSION['user']=$this->user_name;
			$_SESSION['id']=$this->user_id;
				
			//deletes the previously failed loggin attempts from table
			$delete_prev_failed_attempts=$conn->prepare("delete from login_attempts where user_id=:id");
			$delete_prev_failed_attempts->execute(array(":id"=>$this->user_id));
				
			return true;			
	      }
		  
		else
		{ 
			if($id_statment->rowcount()==1) //if the user actually exist records attempt on their account
			{
			    $insert=$conn->prepare("insert into `login_attempts` (`user_id`,`time`) values(:id,:time)");
			    $insert->execute(array(":id"=>$this->user_id,":time"=>time()));
			}
			
			return false;
		}
	}
	
	
	/*
	insert the user data into the database
	given their data dosnt already exist 
	*/
	public function register($req_name,$req_email,$req_pass)
	{
		$conn=$this->conn;
		$req_email=htmlentities($req_email, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
		$req_name=htmlentities($req_name, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
		$check=$conn->prepare("select*from user where user.name=:req_name or user.email=:req_email");
		$check->execute(array(":req_name"=>$req_name,":req_email"=>$req_email));
		$rows_check=$check->rowcount();
        $result=$check->fetch(PDO::FETCH_OBJ);
		if($rows_check)
		{
			if(strtolower($result->name)==strtolower($req_name))
			{
			    throw new Exception("user name already in use");
			}
			else
			{
			    throw new Exception("email already in use ");
			}

		  return false;
		}
		else
		{
			try{
			$salt=$this->getToken(17);	
			$pass=$this->hash_pass($req_pass,$salt);
			$token=$this->getToken(37);
			$insert=$conn->prepare("INSERT INTO `user`(`name`, `email`, `pass`, `salt`, `token`) VALUES(:name,:email,:pass,:salt,:token) ");
			
			$insert->execute(array(":name"=>$req_name,":email"=>$req_email,":pass"=>$pass,":salt"=>$salt,":token"=>$token));
			
			return $token;
		}
		
			catch(pdoexception $e)
			{
			//$this->error("error",$e,"badrequest");
			throw new Exception("OOOPS something bad happened. Better try to reload the page");
		    }

		}
	}


	/*
	Gets the user's salt and uses it to 
	hash the required password then reutrns
	true 
	*/	
   public function change_password($uid,$req_pass)
   {
	   $conn=$this->conn;
	   $get_salt=$conn->prepare("select salt from user where user.id=?");
	   $get_salt->execute(array($uid));
	   $salt=$get_salt->fetch(PDO::FETCH_OBJ);
	   $salt=$salt->salt;
	   $req_pass=$this->hash_pass($req_pass,$salt);
	   $change=$conn->prepare("UPDATE `user` SET `pass`=:pass ,`token`=NULL,`tts`=NULL,`status`='activated' WHERE `id`=:uid");
	   $change->execute(array(":pass"=>$req_pass,":uid"=>$uid));
	   return true;
	   
   }
   

	/*
	Takes a given user_id and updates the email
	*/	
   public function change_email($user_id,$req_email)
   {
   	
	   $conn=$this->conn;
	   $change=$conn->prepare("UPDATE `user` SET `email`=:email ,`token`=NULL,`tts`=NULL,`status`='activated' WHERE `id`=:user_id");
	   $change->execute(array(":email"=>$req_email,":user_id"=>$user_id));
	   if($change->rowCount()==1)
	   return true;
	   else
	   throw new Exception("Trying to add existing email address smtn");
	   
   }
   
   
	/*
	takes a given email adress and if the user exists then insert
	a random token and a timestamp and returns the token to be used
	*/
   public function forgot_password($email)
   {
	   $conn=$this->conn;
	   $email_get=$conn->prepare("select id from user where user.email=?");
	   $email_get->execute(array($email));
	   $email_count=$email_get->rowCount();
	   if($email_count==1)
	   {
		   $token=$this->getToken(37);
		   $email_result=$email_get->fetch(PDO::FETCH_OBJ);
		   $update_token=$conn->prepare("update user set user.token=:token, user.tts=:time where user.id=:uid");
		   $update_token->execute(array(":token"=>$token,":time"=>time(),":uid"=>$email_result->id));
		   return $token;
	   }
	   else
	   {
		   return false;
	   }
   }
   

	/* 
	takes a given token and returns 
	the user id of the owner of the token
	*/
   public function token_user($token)
   {
	   $conn=$this->conn;
	   $reset=$conn->prepare("select user.id from user where user.token=?");
	   $reset->execute(array($token));
	   $count=$reset->rowCount();
	   if($count==1)
	   {
	       $result=$reset->fetch(PDO::FETCH_OBJ);
		   return $result->id;
	   }
	   else
	   {
		   return false;
	   }
	   
   }

	/*
	varifies that the token timestamp is valid 
	*/
   public function tts_valid($token)
   {
	 $conn=$this->conn;
	 $tts=$conn->prepare("select tts from user where user.token=?");
	 $tts->execute(array($token));
	 $tts=$tts->fetch(PDO::FETCH_OBJ);
	 $timestamp=$tts->tts;
	 if($timestamp>=time()-(24*60*60))
	 {
		 return $timestamp;
	 }
	 
	 return false;
   }
   
   
   
	/*
	activates the user account
	*/
   public function activate($id)
   {
	 $conn=$this->conn;
	 $tts=$conn->prepare("UPDATE `user` SET `token`=NULL, `status`='activated' WHERE `id`=?");
	 $tts->execute(array($id));
	 return true;
   }
 
   
   
	/*
	combine the given password and the salt
	and return the value of thier sha1 hash
	*/
	protected function hash_pass($pass,$salt)
	{
		$hashed_pass=sha1($pass.$salt);
		return $hashed_pass;
	}
	

	/*
	check amount of login attempts with a hour 
	time period refrence table login attemts
	*/	
	protected function brute_check($u_id)
	{ 
	$conn=$this->conn;
	$now=time();
	$hour_ago=$now-(1*60*60);
	$stmnt=$conn->prepare("select time from login_attempts where user_id=:u_id and time>=:hourAgo");
	$stmnt->execute(array(":u_id"=>$u_id,":hourAgo"=>$hour_ago));
	$rows=$stmnt->rowcount();
	if($rows>=5)
	return true;
	else 
	return false;
	}


	/*
	Queryies the database for the user salt. If the selected user has no salt 
	then it will equate to null  and produce an incorrect hash  
	*/
	public function getsalt($u_id)
	{
		try
		{
			
		    $conn=$this->conn;
		    $get_salt=$conn->prepare("select user.salt from user where user.id=?");
		    $get_salt->execute(array($u_id));
		    
			if($get_salt->rowcount()==1)
			{
		      $result=$get_salt->fetch(PDO::FETCH_OBJ);
		      $this->user_salt=$result->salt;
		      return $result->salt;	
			}
		}
		
		catch(pdoexception $e)
		{
			$this->error("couldnt get user salt",$e);
		}
   }


	/*
	takes a min and a max value breaks then into their bits to
	get a truly random number between the provided values  
	*/
	protected function crypto_rand_secure($min, $max) //move
	{
        $range = $max - $min;
        if ($range <= 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
   }


	/*
	takes an provided length and reutrns a random token that length
	adds a random char from the alphabet each time by running
	it through our ssl random function(crypto_rand_secure)  
	*/
    protected function getToken($length)
	{
		
	    $token = "";
	    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	    $codeAlphabet.= "0123456789";
	    for($i=0;$i<$length;$i++)
	    {
	      $token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet))];
	    }
		
	    return $token;
    }
	 
	 
	 public function check_email($id)
	 {

	    $conn=$this->conn;
	    $check_email=$conn->prepare("select email from user where user.id=?");
	    $check_email->execute(array($id));
		if($check_email->rowcount()==1)
		{
	      $result=$check_email->fetch(PDO::FETCH_OBJ);
	      $current_email=$result->email;
		  return $current_email ;
		}
		else
		{
		 return FALSE;	
		}
			
	 }
	 
	 
	 public function check_password($user_id,$old_password)
	 {
	   $conn=$this->conn;
	   $get_info=$conn->prepare("select salt,pass from user where user.id=?");
	   $get_info->execute(array($user_id));
	   $info=$get_info->fetch(PDO::FETCH_OBJ);
	   $salt=$info->salt;
	   $password=$info->pass;
	   $old_password=$this->hash_pass($old_password,$salt);
	   if($old_password==$password)
	   return TRUE;
	   else
	   return FALSE;
	}
	 
	 
	/**
	 * Checks wheather there is an active session or not
	 * 
	 * @return bool returns true if there is an active session or returns false
	 */	 
	 public function check_login_status()
	 {
	 	
	 	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] = TRUE)
	 	{
	 		return TRUE;
	 	}
		else
		{
			return FALSE;
		}
	 }
	
}

?>
