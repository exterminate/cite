<div class="ultimatewrap">
	<header>
		<div class="headerwrap">
			<?php
				if(!isset($_SESSION['name'])) {
			?>
					<div class="loginForm">
						<form action="dashboard/" method="post">
							<label for="email">E-mail: </label><br>
							<input type="email" name="email"><br>
							<label for="password">Password: </label><br>
							<input type="password" name="password"><br>
							<input type="submit" name="submit" value="login">
						</form>
					</div>
			
			<?php
				} else {
					
				}
			?>
					<a href="<?php echo $rootURL; ?>">
						<h1 class="header">Cite</h1>
					</a>
					
					<nav>
						<a href="<?php echo $rootURL; ?>">Home</a>
						<a href="<?php echo $rootURL; ?>about/">About</a>
						<a href="<?php echo $rootURL; ?>submit/">Submit stub</a>
						<a href="<?php echo $rootURL; ?>search/">Search</a>
						<a href="<?php echo $rootURL; ?>faq/">FAQ</a>
			<?php
				if(isset($_SESSION['name'])) {
					echo '<a href="'.$rootURL.'dashboard/">Dashboard</a>';
					echo '<a href="'.$rootURL.'logout.php">Logout</a>';
				}
			?>
			</nav>
			
		</div>
	</header>

	<div class="wrapper">
