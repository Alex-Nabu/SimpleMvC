	<div id="main_container">
		<div id="main">
			<div id="main_content_holder">
				
				<?php if(isset($_SESSION['error'])): ?>
				<span class="error" id="register_form_error"><img src="/images/x.png"><p><?php echo $_SESSION['error']; ?></p></span>
				<?php unset($_SESSION['error']); ?>
				<?php endif; ?>
				
				<?php if(isset($_SESSION['sucess'])): ?>
				<span class="error" id="register_form_error"><img src="/images/check.png"><p><?php echo $_SESSION['sucess']; ?></p></span>
				<?php unset($_SESSION['sucess']); ?>
				<?php endif; ?>
				
				<?php if(empty($this->args['files'])): ?>
						<p style="font:16px 'open_sanssemibold_italic';">sorry no files found</p>
				<?php else:?>
					
				<table id="files">
					<th>Filename</th>
					<th>Category</th>
					<th>UP votes</th>
					<th>Down Votes</th>
					<th>Downloads</th>
					<th>Uploader</th>
<?php
foreach($this->args['files'] as $file)
{

		echo"<tr>";
		echo"<td><a href=/files/".$file['physical_name'].">".$file['logical_name']."</a> </td>";
		echo"<td>".$file['category_name']."</td>";
		echo"<td>".$file['upvoted']."&nbsp;&nbsp;&nbsp; <img class='vote' src='/images/check.png'/ data-vote='/vote/".$file['id']."/upvote'> </td>";
		echo"<td>".$file['downvoted']."&nbsp;&nbsp;&nbsp; <img class='vote' src='/images/x.png' data-vote='/vote/".$file['id']."/downvote' /> </td> ";
		echo"<td>".$file['downloads']."</td>";
		echo"<td>".$file['name']."</td>";
		echo"</tr>";
}
		
		$prev=(isset($_GET['page'])&&$_GET['page']>1)?$_GET['page']-1:1;
		$next=$_GET['page']+1;
		$order=isset($_GET['order'])?$_GET['order']:'latest';
		$prev='<a id="previous" href="/?page=' . $prev . '&order='. $order .'">&lt;&lt;prev</a>';
		$next='<a id="next" href="/?page=' . $next . '&order='. $order .'">next&gt;&gt;</a>';
?>					
				</table>
				<div id="pagination">
				<?php echo $prev;?>
				<?php echo $next;?>
				</div>
<?php endif;?>
			</div><!--main content holder end-->
			
			
	<?php require "index_menu.php"	?>
   </div><!--main  end-->
  </div><!--main container end-->