<!DOCTYPE  html>
<head>
	<meta charset="utf-8">
	<title>swatnotes</title>
	<link href="/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="/stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
    <!--[if IE]>
    <link href="/stylesheets/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <![endif]-->
    <script type="text/javascript" src="/js/jquery-2.1.0.js"></script>
    <script type="text/javascript" src="/js/interactions.js"></script>
    <script type="text/javascript" src="/js/ajax-upload.js" ></script>
    <!--<script type="text/javascript" src="/js/interations.js"></script>-->
    <script type="text/javascript"  src="/js/vote.js"></script>
</head>
<body>
	<div id="head_container">
		<header>
		<div class="nine_sixty_hold">
			<h1>Lets All Learn<br/> Something New</h1>
		</div>
		</header>

		<div id="teir1">
			<div class="nine_sixty_hold">
			<h1><a href="/">swatnotes.<span class="big_curly">com</span></a></h1>
			<div id="header_meta">
				
				<?php if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==TRUE):?>
					<p style="font:18px 'open_sansregular'"><span style="font:18px 'open_sansextrabold'">welcome</span> <?php echo $_SESSION['user']?></p>
					
				<?php else: ?>	
			    <a class="login_button" href="/login" style="">Login</a>
				<a class="register_button" href="/register" style=" margin-left: 40px; ">Register</a>
				<?php endif; ?>
				
			</div><!--end of the header meta bar-->
			</div>
		</div><!--teir 1 end-->
	</div><!--header container end-->

