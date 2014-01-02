<?php
class display_controller
{
	
public function __construct()
{
		if(isset($_POST['name']))
		{
			echo "hello ".$_POST['name'];
		}
		else
		{
			echo "no name is set";
		}
}

}

?>