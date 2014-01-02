<?php if(isset($_SESSION['error'])): ?>
<?php echo'<p style="color:red;"> username or password wrong</p>'; unset($_SESSION['error']);  ?>
<?php endif;?> 

<p><a href="/template/">Here</a> this is a template you can easily play with to understand</p>
</body>
</html>