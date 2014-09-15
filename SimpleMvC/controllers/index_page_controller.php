<?php

class index_page_controller
{
	
	protected $object_factory;
	protected $view_template=array('header'=>'index_header','body'=>'index_body','footer'=>'index_footer');
	protected $model;
	protected $view;
	protected $plugin_manager;
	protected $plugin_manager2;

	public function __construct(object_factory_core $factory)
	{
		
		$this->object_factory = $factory;
		
		$this->plugin_manager = $this->object_factory->build_plugin_manager();
		
	}
  
   public function _varify()
   {
   	
  	//	throw new controller_exception("Error Processing Request", "http://google.com");
		
   }
  
  public function _execute()  
  {
  	
	$this->view=$this->object_factory->build_view($this->view_template);
	$this->view->render();
	
  }

}

?>