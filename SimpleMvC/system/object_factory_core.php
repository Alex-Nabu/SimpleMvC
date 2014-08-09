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
		
		$controller_name.='_controller';
		
		// Name of the method if the controller is build
		// ..using a specific method
		$controller_build_function="build_".$controller_name;
		
		if (method_exists($this,$controller_build_function))
		{
			return $this->$controller_build_function($controller_name);
		}
		elseif(class_exists($controller_name))
		{
			return new $controller_name($this);
		}
		else
		{
			return new error_page_controller($this,$controller_name);
		}
			
	}	
	
	
	/*
	----------------------------------Model Section-----------------------------------------
	
	THIS SECTION OF THE OBJECT FACTORY WILL DEAL WITH THE BUILDING OF MODEL OBJECTS.
	THIS COULD HAVE EASILY BEEN DONE BY CALLING A NEW OBJECT IN THE CALLING CONTROLLER
	BUT IN AN ATTEMPT TO BE CONSISTENT I DECIDED TO BUILD IT HERE.
	
    ---------------------------------------------------------------------------------------
	*/
	
	public function build_model($model_name,array $params=array())
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
	
	public function build_view(array $view_templates, array $view_data=array())
	{
		return new build_view($view_templates,$view_data);	
	}
	
	/*
	----------------------------------Core Objects-----------------------------------------
	
	THIS SECTION OF THE OBJECT FACTORY WILL DEAL WITH THE BUILDING OF CORE OBJECTS.
	
    ---------------------------------------------------------------------------------------
	*/
	
	
	public function build_core($object_name)
	{
		$boject_name=strtolower($bject_name);
		
		$object_name.='_core';
		
		// Name of the method if the object is built
		// ..using a specific method
		$core_object_build_function="build_".$object_name;
		
		if (method_exists($this,$controller_build_function))
		{
			return $this->$core_object_build_function($object_name);
		}
		elseif(class_exists($object_name))
		{
			return new $object_name($this);
		}
		else
		{
			exit("the core module ".$boject_name." couldnt be initialized");
		}
	}
	
	public function build_router($uri)
	{
		$uri=strtolower($uri);
		return new router_core($this, $uri);	
	}
	
	/*
	----------------------------------Plugin Manager-----------------------------------------
	
	THE PLUGIN MANAGER IS A CORE OBJECT. THE FACTORY WILL RETURN THE SAME INSTANCE
	OF THE PLUGIN MANGER IF THE PLUGIN MANAGER HAS ALREADY BEEN INSTANCIATED ONCE BEFORE
	
    ---------------------------------------------------------------------------------------
	*/
	public function build_plugin_manager()
	{
		static $plugin_manager=null;
		
		if($plugin_manager)
		{
			return $plugin_manager;
		}
		else
		{
			$plugin_manager=new plugin_manager_core();
			return $plugin_manager;
		}	
	}
	
	
	/*
	----------------------------------Plugins Section-----------------------------------------
	
	THIS SECTION OF THE OBJECT FACTORY WILL DEAL WITH THE BUILDING OF PLUGINS.
	THIS COULD HAVE EASILY BEEN DONE BY CALLING A NEW PLUGIN IN THE PLUGIN MANAGER
	BUT IN AN ATTEMPT TO BE CONSISTENT I DECIDED TO BUILD IT HERE.
	
    ---------------------------------------------------------------------------------------
	*/
	
	public function build_plugin($plugin_name,$params=array())
	{
		$plugin_name=strtolower($model_name);
		$plugin_name.='_plugin';
		return new $plugin_name($params);
	}
	
	
}

?>