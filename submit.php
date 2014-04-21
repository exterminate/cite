<?php

require_once 'core/init.php';

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {

		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'email' => array(
				'required' 	=> true,
				'min' 		=> 2,
				'max' 		=> 20
			),
			'orcid' => array(
				'required' 	=> true,
				'min' 		=> 16,
				'max' 		=> 20
			),
			'name' => array(
				'required' 	=> true,
				'min' 		=> 2,
				'max' 		=> 50
			)
		));

		if($validation->passed()) {
			$user = new User();
			$hash = Hash::salt(32);

			try {
				$user->create(array(
					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'). $salt),
					'salt' => $salt,
					'name' => Input::get('name'),
					'joined' => date('Y-m-d H:i:s'),
					'group' => 1
				));

				Session::flash('home', 'You have been registered and can now log in!');
				header('Location: index.php');

			} catch(Exception $e) {
				die($e->getMessage());
			}
		} else {  
			foreach($validation->errors() as $error) {
				echo $error . "<br>";
			}
		}
	}
}

//id, linkid, name, email, orcid (required), datesubmitted, doi, datedoi
?>

<form action="" method="post">
	<div class="field">
		<label for="name">Name</label>
		<input type="text" name="name" id="name" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
	</div>

	<div class="field">
		<label for="email">E-mail</label>
		<input type="text" name="email" id="email">
	</div>

	<div class="field">
		<label for="orcid">ORCID ID</label>
		<input type="text" name="orcid" id="orcid">
	</div>
	<div class="field">
		<label for="description">Describe your work</label>
		<textarea name="description" id="description"></textarea>
	</div>
	<input type="submit" value="Register">
</form>