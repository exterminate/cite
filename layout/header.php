<div class="ultimatewrap">
	<header>
		<div class="headerwrap">
			<a href="<?php echo $rootURL; ?>">
				<h1 class="header">Cite</h1>
			</a>
			<?php
				echo '<div class="loginForm">';
				if(!$_SESSION['login']->isLoggedIn()) {
				
					//we are not logged in so display the login fields
			?>
					<h2>Log in</h2>
					<span id="registerForm" title="close">&times;</span>
					<form action="" method="post">
						<label for="email">E-mail: </label><br>
						<input type="email" name="email" placeholder=someone@example.com><br>
						<label for="password">Password: </label><br>
						<input type="password" name="password" placeholder="********"><br>
						<input type="submit" name="submit" value="Log in">
						<a href='#register' id="registerForm">Register</a><br>
						<a href='passreset'>Can't remember password?</a>	
					</form>		
			<?php
				}
				echo '</div>';
				
			?>
						
					
					<nav>
						 
						<a href="<?php echo $rootURL; ?>">Home</a>
						<a href="<?php echo $rootURL; ?>about">About</a>
						
						<a href="<?php echo $rootURL; ?>search">Search</a>
						<a href="<?php echo $rootURL; ?>faq">FAQ</a>
						<a href="<?php echo $rootURL; ?>contact">Contact us</a>
			<?php
				if($_SESSION['login']->isLoggedIn()) {
			?>
						<a href="<?php echo $rootURL ?>dashboard">My Stubs</a>
						<a href="<?php echo $rootURL ?>logout" class="logout"> | Logout</a>
						<a href="<?php echo $rootURL ?>passreset" class="logout">Change password</a>
			<?php
				} else {
				
			?>
						<a id="loginTrigger" class="logout">Log in</a>
			<?php
				}
			?>
					</nav>			
		</div>
	</header>

	<div class="wrapper">
