<?php
session_start();
require 'core/init.php';

include 'layout/head.php';
include 'layout/header.php';


/* put code to process contact */

if(Input::exists()) {

	
    $validate = new Validate();
    $validate->check($_POST, array( 
        'name' => array(
                'required'      => true,
                'min'           => 2,
                'max'           => 50
                ),
        'human' => array(
                'required'      => true,
                'min'           => 1,
                'max'           => 2
                ),
        'comment' => array(
                'required'      => true,
                'min'           => 2,
                'max'           => 2000
                ),
        'email' => array(
                'required' 	=> true,
                'max' 	        => 60,
                'email' 	=> true			
                )
        )
    );
    
    if(Input::get('human') != $_SESSION['sum']) {
        $_SESSION['flash'] = '<p style="color:red">You got the sum wrong. Are you a spambot?</p>';
        unset($_SESSION['sum']);
    }else{
        if($validate->passed()) {
            $email = new EmailHandler();
            $message = Input::get('name') . "\n" . Input::get('email') . "\n" . Input::get('comment');
            $email->sendEmail("citeitnow@gmail.com", "Contact us submitted", $message);
            $_SESSION['flash'] = '<p style="color:red">Thanks for the message. If needed, we\'ll be in touch soon.</p>';
            unset($_SESSION['sum']);
        }
    }
    
    
} 


$num1 = rand(1,4);
$num2 = rand(3,7);
$_SESSION['sum'] = $num1 + $num2;


?>

<h1>Contact us</h1>
<?php

if(isset($_SESSION['flash'])) {
    echo $_SESSION['flash'];
    unset($_SESSION['flash']);
}

?>
<!-- form to put somewhere -->
<form action="" method="POST">
	<label for="name">Name:</label><br>
	<input type="text" name="name" size="34" <?php if($_SESSION['login']->isLoggedIn()) {echo 'readonly value="'.$_SESSION['name'].'"';} ?>"><br>
	<label for="email">E-mail:</label><br>
	<input type="email" name="email" size="34" <?php if($_SESSION['login']->isLoggedIn()) {echo 'readonly value="'.$_SESSION['email'].'"';} ?>"><br>
	<label for="comment">Comment:</label><br>
	<textarea name="comment"></textarea><br>
	<label for="human">What is <?=$num1?> + <?=$num2?>?</label><br>
	<input type="text" name="human"><br>
	<input type="submit" name="submit" value="Send">
</form>	
	
<?php
include 'layout/footer.php';
?>