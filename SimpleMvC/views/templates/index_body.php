<p>To edit these files go to <b>SimpleMvC/controllers/</b> and change how this entire page works</p>

<p> Here is what the model said -> ''<?php echo $this->args['words'] ?>"</p>

<p> Here is a list of all the arguemnts passed to me from the controller</p>

<?php foreach ($this->args as $key => $value)
 {
		echo "key[".$key."] = ".$value;	
 }
?>
