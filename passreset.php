<?php
session_start();
require 'core/init.php';
include 'layout/head.php';
include 'layout/header.php';


if($_SESSION['login']->isLoggedIn()) {
    // change password
    if(Input::exists()) {
        $validate = new Validate();
	$validate->check($_POST, array( 
            'oldPassword' => array(
                'required' 	=> true,
                'min' 		=> 6,
                'max' 		=> 20	
                ),
            'newPassword' => array(
               'required' 	=> true,
               'min' 		=> 6,
               'max' 		=> 20	
                ),
            'newPasswordAgain' => array(
                'required' 	=> true,
                'min' 		=> 6,
                'max' 		=> 20	
			
                )
            )
	);
	
	if($validate->passed()) {
            // does this user exist?
            $stub = $dbHandler->getUser('email', $_SESSION['email']);
            
            //does the user exist? he should cos he's logged in
            if($stub ==  null) {
                // no
                $_SESSION['error'] = "Sorry, this user doesn't exist. Something went really wrong!";
            } else {
                // yes
                // does the old password match
                if($stub->password == md5(Input::get('oldPassword'))) {
                    // yes, the old password matches
                    // do the new passwords match?
                    if(Input::get('newPassword') == Input::get('newPasswordAgain')) {
                        // yes, the new passwords match
                        // update the database
                        $dbHandler->updateNew('users', 'password', md5(Input::get('newPasswordAgain')), 'email', $stub->email);
                        $_SESSION['error'] = "Success! Your password has been reset";
                    } else {
                        // the new passwords don't match
                        $_SESSION['error'] = "Your new passwords don't match";
                    }
                } else {
                    // no, you've entered the wrong old password
                    $_SESSION['error'] = "You got your old password wrong";
                }
            }
        } else {
            $_SESSION['error'] = "Something went wrong, try again";
        }
    }
    
} else {
    //password reset
    if(Input::exists()) {
        $validate = new Validate();
        $validate->check($_POST, array( 
                'email' => array(
                        'required' 	=> true,
                        'email' 	=> true			
                        )
                )
        );
        if($validate->passed()) {
            if($_SESSION['sum'] == Input::get('human')) {
                unset($_SESSION['sum']);
                
                // does this user exist?
                $stub = $dbHandler->getUser('email', Input::get('email'));
                //check the above returns a user
                if($stub ==  null) {
                    // no
                    $_SESSION['error'] = "Sorry, this user doesn't exist";
                } else {
                    // yes
                    $newPassword = $dbHandler->getUniqueCode('stubId', 'links');
                    
                    $dbHandler->updateNew('users', 'password', md5($newPassword), 'email', Input::get('email'));
                    
                    $email = new EmailHandler();
                    $email->sendEmail(
                            'to',
                            'subject',
                            'message'
                    );
                }            
                $_SESSION['error'] = "Success! Please check your email";
                
            } else {
                $_SESSION['error'] = "You got didn't answer the sum correctly. Try again";
            }
        } else {
                $_SESSION['error'] = "Sorry, this email isn't valid";
        }           
    }
}

?>


<?php
if(isset($_SESSION['error'])) {
	echo "<p class='errorMessage'>" . $_SESSION['error'] . "</p>";
	unset($_SESSION['error']);
}

$num1 = rand(1,4);
$num2 = rand(1,4);
$_SESSION['sum'] = $num1 + $num2;

if (isset($_SESSION['error'])) {
    echo "<p>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}

if($_SESSION['login']->isLoggedIn()) {
    // change password
?>
<h2>Change password</h2>
<form action="" method="POST">
    <label for="oldPassword">Enter current password:</label><br>
    <input type="password" name="oldPassword"><br><br>
    <label for="newPassword">Enter new password:</label><br>
    <input type="password" name="newPassword"><br><br>
    <label for="newPasswordAgain">Enter new password again:</label><br>
    <input type="password" name="newPasswordAgain"><br><br>
    <input type="submit" name="reset" value="Change password"><br>
</form>	

<?php
} else {
    //password reset
?>
<h2>Reset password</h2>
<p>We will e-mail you with a new password.</p>
<form action="" method="POST">
    <label for="email">Enter e-mail address:</label><br>
    <input type="email" name="email"><br><br>
    <label for="human">What is <?=$num1?> + <?=$num2?>?</label><br>
    <input type="text" name="human" size="2"><br><br>
    <input type="submit" name="reset" value="Reset"><br>
</form>	

<?php
}
include 'layout/footer.php';
?>