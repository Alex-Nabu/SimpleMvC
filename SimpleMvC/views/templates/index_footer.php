<?php if(isset($_SESSION['error'])): ?>
<?php echo'<p style="color:red;">'.$_SESSION['error'].'</p>'; unset($_SESSION['error']);  ?>
<?php endif;?> 

<div id="footer_container">
	<footer>
		
		<div class="info_section">
			<ul>
			<h2>About</h2>
			<li><a href="/about">Founders</a></li>
			<li><a href="/mission">Mission Statment</a></li>
			<li><a href="/policies">Policies</a></li>
			</ul>
		</div>
		
		<div class="info_section">
			<ul>
			<li><h2>Contact</h2></li>
			<li><p>email:<br />Admin@swatnotes.com</p></li>
            <li><p>Phone:<br/>1-876-580-4694</p></li>
            </ul>
		</div>
		
		<div class="info_section" style="text-align: center">
			<ul style="margin-left: 76px; text-align: left">
		    <li><h2>Support</h2></li>
			<li><a href="/sponsorship">Become a Sponsor</a></li>
			<li><a href="/support">Report a problem</a></li>
			</ul>
		</div>
		
		<div class="info_section" style="text-align: center">
			<ul style="margin-left: 76px; text-align: right">
			<li><h2>Sponsors</h2></li>
			<li><a><p>Nuwebdesinz</a></li>
			<li><a>Nectron Limited</a></li>
			</ul>
		</div>
	</footer>
</div><!--footer container-->