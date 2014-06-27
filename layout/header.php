<div class="ultimatewrap">
	<header>
		<div class="headerwrap">
			
			<?php
				echo '<div class="loginForm">';
				if($_SESSION['login']->isLoggedIn()) {
					//we are logged in, so show a message and the logout button					
					echo '<a href="'.$rootURL.'logout">Logout</a>';
				} else {
					//we are not logged in so display the login fields
			?>
					
					<form action="" method="post">
						<label for="email">E-mail: </label><br>
						<input type="email" name="email"><br>
						<label for="password">Password: </label><br>
						<input type="password" name="password"><br>
						<input type="submit" name="submit" value="login">
					</form>				
			
			<?php
				}
				echo '</div>';
			?>
					<a href="<?php echo $rootURL; ?>">
						<h1 class="header">Cite</h1>
					</a>
					
					<nav>
						<a href="<?php echo $rootURL; ?>">Home</a>
						<a href="<?php echo $rootURL; ?>about">About</a>
						
						<a href="<?php echo $rootURL; ?>search">Search</a>
						<a href="<?php echo $rootURL; ?>faq">FAQ</a>
			<?php
				if($_SESSION['login']->isLoggedIn()) {
			?>
						<a href="<?php echo $rootURL ?>dashboard">My Stubs</a>					
						<a href="<?php echo $rootURL ?>logout" class="logout">Logout</a>
			<?php
				}
			?>
					</nav>			
		</div>
	</header>

	<div class="wrapper">
