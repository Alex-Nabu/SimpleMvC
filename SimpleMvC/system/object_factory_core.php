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
   
   

class object_factory_core
{
	
	
	public function build_controller($controller_name)
	{
		
			$controller_name=strtolower($controller_name);
			
			$controller_build_function="build_".$controller_name."_controller";
			
			if(method_exists($this,$controller_build_function))
			{
				return $this->$controller_build_function($controller_name);
			}
			else
			{
				return $this->controller_dosnt_exist($controller_build_function);
			}
			
	}
	
	
	
	private function build_index_controller($controller_name)
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
		        return new $controller_name($this);
			}
		}
		else
		{
			return $this->controller_dosnt_exist($controller_name);
		}
		
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
	
}

?>