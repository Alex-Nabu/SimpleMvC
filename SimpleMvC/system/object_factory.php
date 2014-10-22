<?php 
namespace SimpleMvC\system;

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

// @todo header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); when the controller is not found
// This Correctly tells the client that the resource was not found
// Also include a default 404 message to the client because sending that code alone dosnt do that.
   
class object_factory
{
	
	
	public function build_controller($controller_name)
	{
		
		// Make request case insensitive
		$controller_name=strtolower($controller_name);
		
		// Append '_controller' to abide by system convention of appending file names with '_category'
		$controller_name.='_controller';
		
		// Adding controllers namespace to controller name
		$controller_name = "\\SimpleMvC\\controllers\\".$controller_name;
		
		if(class_exists($controller_name))
		{
			return new $controller_name($this);
		}
		else
		{
			return new \SimpleMvC\controllers\error_page_controller($this,$controller_name); // Request not found (404 error)
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
		// Make model name case insensitive (lowercaps)
		$model_name=strtolower($model_name);
		
		// Append '_model' to abide by ststem convension of appending files names with '_fileType'
		$model_name.='_model';
		
		// Adding models namespace to model name
		$model_name = "\\SimpleMvC\\models\\".$model_name;
				
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
		return new \SimpleMvC\views\build_view($view_templates,$view_data);	
	}
	
	
	/*
	----------------------------------Core Objects-----------------------------------------
	
	THIS SECTION OF THE OBJECT FACTORY WILL DEAL WITH THE BUILDING OF CORE OBJECTS.
	
    ---------------------------------------------------------------------------------------
	*/
	
	public function build_system_object($object_name)
	{
		// Make object name case insensitive (lowercase)
		$object_name=strtolower($object_name);
		
		// Append '_core' to abide by system convention of appending file names with '_category'
		$object_name.='_core';
		
		// Adding controllers namespace to controller name
		$object_name = "\\SimpleMvC\\system\\".$object_name;
		
		
		if(class_exists($object_name))
		{
			return new $object_name($this);
		}
		else
		{
			exit("the core module ".$object_name." couldnt be initialized");
		}
		
	}
	
	
	public function build_router($uri)
	{
		return new \SimpleMvC\system\router($this, $uri);	
	}
	
	
	/*
	----------------------------------Plugin Manager-----------------------------------------
	
	THE PLUGIN MANAGER IS A CORE OBJECT. THE FACTORY WILL RETURN THE SAME INSTANCE
	OF THE PLUGIN MANGER IF THE PLUGIN MANAGER HAS ALREADY BEEN INSTANCIATED ONCE BEFORE
	
    ---------------------------------------------------------------------------------------
	*/
	
	public function build_plugin_manager()
	{
		// If the plugin manager has already been created via this instance of object factory make it static
		static $plugin_manager=null;
		
		if($plugin_manager)
		{
			return $plugin_manager;
		}
		else
		{
			$plugin_manager=new \SimpleMvC\system\plugin_manager();
			return $plugin_manager;
		}	
	}
		
}

?>