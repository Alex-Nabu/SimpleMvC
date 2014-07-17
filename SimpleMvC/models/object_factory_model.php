<?php 

/*
--------------------------------INITIAL DOCUMENTATION-------------------------------------------

   THE PURPOSE OF THIS CLASS IS TO CREATE THE INSTANCE OF A CLASS WHEN NEEDED AND HOW NEEDEED.
   FOR EXAMPLE WE COULD HAVE CREATED THE CONTROLLER OBJECT INLINE BUT IN RECOGITION
   OF THE POLYMORPHIC BEHAVIOR OF CONTROLLERS WE HAVE THE DECIDED TO CREATE IT IN OUR OBJECT-
   FACTORY CLASS(THIS CLASS) WHICH SERVES TO HIDE THE LOGIC OF CREATING THE CORRECT INSTANCE OF
   A SPECIFIED CONTROLLER. 
   
   FOR EXAMPLE THE 'BUILD_INDEX_CONTROLLER' FUNCTION USES THE SECOND PARAMETER
   OF THE PARAMETERS PASSED TO IT TO DECIED ON THE INSTANCE OF THE INDEX TO CALL
   
------------------------------------------------------------------------------------------------
*/
   
   

class object_factory_model
{
	
	
	public function build_controller($controller_name,array $controller_params)
	{
		$indexed_controller_params=array_values($controller_params);
		$controller_name=strtolower($controller_name);

		
			$controller_build_function="build_".$controller_name."_controller";
			
			if(method_exists($this,$controller_build_function))
			{
				return $this->$controller_build_function($controller_name,$controller_params,$indexed_controller_params);
			}
			else
			{
				return $this->controller_dosnt_exist($controller_build_function);
			}
			
	}
	
	
	
	private function build_index_controller($controller_name,array $params,array $indexed_controller_params)
	{
		if(empty($params))
		{
			if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==TRUE)
			{
				$controller_name.="_loggedin_page_controller";
				return new $controller_name($this,$params);
			}
			else
				{
				$controller_name.="_page_controller";
		        return new $controller_name($this,$params);
				}
		}

		else
		return $this->controller_dosnt_exist($controller_name.$indexed_controller_params[0]);
	}
	
	
		private function build_register_controller($controller_name,array $params,array $indexed_params)
	{
		if(!empty($params))
		{
			$this->controller_dosnt_exist($controller_name.$indexed_params[0]);
		}
		if(isset($_POST['register']))
		{
			$controller_name.="_form_controller";
		    return new $controller_name($this,$params);
		}
		
		$controller_name.="_page_controller";
		return new $controller_name($this,$params);
		
	}
	
	
	private function build_account_controller($controller_name,array $params,array $indexed_params)
	{
		if(isset($indexed_params[0]))//we dont accept any more arguments than this
		{
			return $this->controller_dosnt_exist($controller_name.$indexed_params[0]);
		}
		
		if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==TRUE)
		{
			$controller_name.="_page_controller";
			return new $controller_name($this,$params);
		}
		else
			{
				$_SESSION['error']="OOOPS you forgot to login";
				header('location:/login');
			}
	}
	
	private function build_forgot_controller($controller_name,array $params,array $indexed_params)
	{
		
		
		if(isset($_POST['forgot']))
		{
			$controller_name=$controller_name."_form_controller";
		    return new $controller_name($this,$params);
		}
		
		if(isset($indexed_params[0]))//if token is there send it to the reset controller
		{
			if(isset($_POST['change']))
			{
				$controller_name="reset_password_form_controller";
				return new $controller_name($this,$indexed_params);
			}
			$controller_name="reset_password_page_controller";
			return new $controller_name($this,$indexed_params);
		}
		
		if(empty($this->params))
		{
			$controller_name=$controller_name."_page_controller";
		    return new $controller_name($this,$params);
		}
		
		return $this->controller_dosnt_exist($controller_name);
	}
	
	
	
	private function build_login_controller($controller_name,array $params,array $indexed_params)
	{
		if(!isset($indexed_controller_params[0]))
		{
			if(isset($_POST['login']))
			{
				$controller_name.="_form_controller";
				return new $controller_name($this,$params);
			}
			
			if(isset($indexed_params[0]))
			{
				$controller_name="activation_controller";
				return new $controller_name($this,$indexed_params);
			}
			
			$controller_name.="_page_controller";
		    return new $controller_name($this,$params);
		}
	}
	
	
	
	private function build_template_controller($controller_name,array $params,array $indexed_params)
	{
			$controller_name=$controller_name."_page_controller";
		    return new $controller_name($this,$params);
	}
	
	private function build_share_controller($controller_name,array $params,array $indexed_params)
	{
		if(isset($_POST['upload']))//user must have used the form
		{
		
		if(isset($indexed_params[0]))
			{
				$controller_name.="_ajax_controller";
				return new $controller_name($this,$indexed_params);
			}
		
		  $controller_name=$controller_name."_form_controller";
		  return new $controller_name($this,$params);
		
			
		}
		
					
		$_SESSION['error']='OOOPS better try that again';
		header('location:/');

	}
	
	
		private function build_files_controller($controller_name,array $params,array $indexed_params)
	{
			if(isset($indexed_params[0]))
			{
				$controller_name="file_page_controller";
				return new $controller_name($this,$indexed_params);
			}

			$controller_name="index_page_controller";
		    return new $controller_name($this,$params);
	}

	
		private function build_download_controller($controller_name,array $params,array $indexed_params)
	{
			if(isset($indexed_params[0]))
			{
				$controller_name="download_file_controller";
				return new $controller_name($this,$indexed_params);
			}

			$controller_name=$controller_name."_page_controller";
		    return $this->controller_dosnt_exist($controller_name);
	}
	
	
	private function build_search_controller($controller_name,array $params, array $indexed_params)
	{
			
		if(isset($indexed_params[0]))//we dont accept any more arguments than this
		{
			return $this->controller_dosnt_exist($controller_name.$indexed_params[0]);
		}
		
		if(isset($_GET['q'])&&$_GET['q']!='')
		{
			$controller_name.="_form_controller";
			return new $controller_name($this,$indexed_params);
		}
		
		$controller_name.="_page_controller";
		return new $controller_name($this,$params);
	}
	
	private function build_vote_controller($controller_name,array $params,array $indexed_params)
	{
		if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==TRUE)
		{
		$controller_name='vote_controller';
		return new $controller_name($this,$indexed_params);
		}
        else
        {
        	header('Content-Type: application/json');
			echo json_encode(array("error"=>"You have to login to be able to vote"));
        }
	}
	
	private function build_logout_controller($controller_name,array $params, array $indexed_params)
	{
		session_destroy();
		header('location:/');
	}
	
	private function build_pastpapers_controller($controller_name,array $params,array $indexed_controller_params)
	{
		if(empty($params))
		{
	    $controller_name.="_page_controller";
		return new $controller_name($this,$params);
		}

		else
		return $this->controller_dosnt_exist($controller_name.$indexed_controller_params[0]);
	}

	private function build_examples_controller($controller_name,array $params,array $indexed_controller_params)
	{
		if(empty($params))
		{
	    $controller_name.="_page_controller";
		return new $controller_name($this,$params);
		}

		else
		return $this->controller_dosnt_exist($controller_name.$indexed_controller_params[0]);
	}

	private function build_notes_controller($controller_name,array $params,array $indexed_controller_params)
	{
		if(empty($params))
		{
	    $controller_name.="_page_controller";
		return new $controller_name($this,$params);
		}

		else
		return $this->controller_dosnt_exist($controller_name.$indexed_controller_params[0]);
	}

	private function build_collections_controller($controller_name,array $params,array $indexed_controller_params)
	{
		if(empty($params))
		{
	    $controller_name.="_page_controller";
		return new $controller_name($this,$params);
		}

		else
		return $this->controller_dosnt_exist($controller_name.$indexed_controller_params[0]);
	}
	
	
	private function build_policies_controller($controller_name,array $params,array $indexed_controller_params)
	{
		if(empty($params))
		{
	    $controller_name.="_page_controller";
		return new $controller_name($this,$params);
		}

		else
		return $this->controller_dosnt_exist($controller_name.$indexed_controller_params[0]);
	}
	
	
	private function build_about_controller($controller_name,array $params,array $indexed_controller_params)
	{
		if(empty($params))
		{
	    $controller_name.="_page_controller";
		return new $controller_name($this,$params);
		}

		else
		return $this->controller_dosnt_exist($controller_name.$indexed_controller_params[0]);
	}
	
	
	private function build_support_controller($controller_name,array $params,array $indexed_controller_params)
	{
		if(empty($params))
		{
	    $controller_name.="_page_controller";
		return new $controller_name($this,$params);
		}

		else
		return $this->controller_dosnt_exist($controller_name.$indexed_controller_params[0]);
	}
	
	private function build_mission_controller($controller_name,array $params,array $indexed_controller_params)
	{
		if(empty($params))
		{
	    $controller_name.="_page_controller";
		return new $controller_name($this,$params);
		}

		else
		return $this->controller_dosnt_exist($controller_name.$indexed_controller_params[0]);
	}
	
		private function build_sponsorship_controller($controller_name,array $params,array $indexed_controller_params)
	{
		if(empty($params))
		{
	    $controller_name.="_page_controller";
		return new $controller_name($this,$params);
		}

		else
		return $this->controller_dosnt_exist($controller_name.$indexed_controller_params[0]);
	}
	
	
		private function build_settings_controller($controller_name,array $params,array $indexed_params)
	{
		if(isset($indexed_params[1]))//we dont accept any more arguments than this
		{
			return $this->controller_dosnt_exist($controller_name.$indexed_params[0]);
		}
		
		if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==TRUE)
		{
			if(isset($indexed_params[0]))
			{
				if(isset($_POST['change_email']))
				{
					$controller_name="change_email_form_controller";
					return new $controller_name($this,$params);
				}
				
				if(isset($_POST['change_password']))
				{
					$controller_name="change_password_form_controller";
					return new $controller_name($this,$params);
				}
				
				switch ($indexed_params[0]) {
					case 'email':
						$controller_name="email_settings_page_controller";
						return new $controller_name($this,$params);
						break;
						
					case 'password':
						$controller_name="settings_page_controller";
						return new $controller_name($this,$params);
						break;
					
					default:
						return $this->controller_dosnt_exist($controller_name.$indexed_params[0]);
						break;
				}
			}
			$controller_name.="_page_controller";
			return new $controller_name($this,$params);
		}
		else
			{
				$_SESSION['error']="OOOPS you forgot to login";
				header('location:/login');
			}
	}
	
	
	private function build_myfiles_controller($controller_name,array $params,array $indexed_controller_params)
	{
		if(isset($indexed_params[0]))//we dont accept any more arguments than this
		{
			$this->controller_dosnt_exist($controller_name.$indexed_params[0]);
		}
		
		if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==TRUE)
		{
			$controller_name.="_page_controller";
			return new $controller_name($this,$params);
		}
		else
			{
				$_SESSION['error']="OOOPS you forgot to login";
				header('location:/login');
			}
		
	}


	private function build__controller($controller_name,array $params,array $indexed_controller_params)
	{
		if(empty($params))
		{
	    $controller_name.="_page_controller";
		return new $controller_name($this,$params);
		}

		else
		return $this->controller_dosnt_exist($controller_name.$indexed_controller_params[0]);
	}
	
	
	private function controller_dosnt_exist($controller_name)
	{
		
		return new error_page_controller($this,$controller_name);
	}
	
	
	/*
	----------------------------------Model Section-----------------------------------------
	
	THIS SECTION OF THE OBJECT FACTORY WILL DEAL WITH THE BUILDING OF MODEL OBJECTS.
	THIS COULD HAVE EASILY BEEN DONE BY CALLING A NEW OBJECT IN THE CALLING CONTROLLER
	BUT IN AN ATTEMPT TO BE CONSISTENT I DECIDED TO BUILD IT HERE.
	
    ---------------------------------------------------------------------------------------
	*/
	
	public function build_model($model_name,array $params)
	{
		$model_name=strtolower($model_name);
		$model_name.='_model';
		return new $model_name($params);
		
	}
	
	/*
	---------------------------------VIEWS SECTION----------------------------------------
	
	THE IMPLEMENTATION OF THE VIEW IS SUBJECT TO SCRUTENY ON THE PART OF THE DEVELOPER
	AND AS SUCH MAY BE IMPLEMENTED IN ANYWAY THEY SEE FIT. FOR EXAMPLE I AM VERY SURE
	THEIR ARE PHP TEMPLATING ENGINES OUT THEY THAT WERE SPECIALLY DESIGNED FOR A TASK
	SUCH AS IMPLEMTENYING HOW TO RENDER VIEW TEMPLATES. TO NOT IMPLEMENT A WAY TO RENDER
	VIEW TEMPLATES HOWEVER WOULD HAVE LEFT AN HOLE IN THE APPLICATION AND TO SIMPLY 
	REQUIRE THE FILES THAT I WANT IN EACH CONTROLLER SEEMED TO BE A REDUNDANT TASK.
	HENCE AFTER MUCH THAUGHT I HAVE CREATED THE MOST SIMPLE, EFFICIENT IMPLEMTATION OF A
	TEMPLATING ENGINE THAT I COULD THINK OF WHICH IS JUST A CLASS THAT IS CONSTRUCTED 
	BY PASSONG IN THE NAME OF A "HEADER", "BODY" AND "FOOTER" TEMPLATE FILES ALONG WITH AN
	ARRAY OF ARGUMENTS WHICH CAN BE USED IN THE TEMPLATE FILES TO DISPLAY DYNAMIC CONTENT
	
	---------------------------------------------------------------------------------------
	*/
	
	
	public function build_view(array $view_templates, array $view_data)
	{
		return new build_view($view_templates,$view_data);
	}
	
	
	
	
	/*
	--------------------------DATABASE CONFIG OBJECTS-----------------------------------
	
	I WAS THINKING ABOUT PUTTING MY DB CONNECTION HERE TO BUILD BUT I THAUGHT ABOUT IT
	AND SEEING THIS ISNT A CORE SERVIVCE AND THE WAY I WANT TO CONNECT AND YOU WANT
	TO MAY BE DIFFRENT I DECIDDED AGAINST IT BUT WHEN THIS IS RUNNING YOUR CUSTOM 
	WEBSITE/APP PLEASE FEEL FREE TO DO AS YOU PLEASE HERE (CREATE OBJECTS)
	
	-------------------------------------------------------------------------------------
	*/
}
?>