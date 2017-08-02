<?php 

	//03B. Create variables for message
	$msg = "";
	$msgClass = ""; // this one os done for the bootstrap class	
	// 01. check for submit
	if (filter_has_var(INPUT_POST, 'submit')) {
		
		// 02. get data from form  //06. use htmlspecialchars for security
		$name = htmlspecialchars($_POST['name']);
		$email = htmlspecialchars($_POST['email']);
		$message = htmlspecialchars($_POST['message']);

		// 03. check required fields -- we check if the data is not empty
		if(!empty($name) && !empty($email) && !empty($message)) {
			//Passed

			// 04. check email validity
			if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				// Failed
				$msg = "Not a valid email";
				$msgClass = 'alert-danger';
			} else {
				// Passed

				//07. send email
				$toEmail = 'nicoodes@hotmail.com';
				$subject = 'Contact request from '.$name;
				$body = '<h2>Contact Request</h2>
						<h4>Name</h4><p>'.$name.'</p>
						<h4>Email</h4><p>'.$email.'</p>
						<h4>Message</h4><p>'.$message.'</p> 
						';
				//07b. email headers
				$headers = 'MIME-Version: 1.0' ."\r\n";
				$headers .= 'Content-Type:text/html;charset=UTF-8' ."\r\n";
				
				//07c. additional headers
				$headers .= 'From: ' . $name . '<' . $email . '>' ."\r\n";

				//08. check if mail is sent correctly -- uses the mail function mail(to, subject, message, header)
				if (mail($toEmail, $subject, $body, $headers)) {
					//email sent
					$msg = 'Your email has been sent';
					$msgClass = 'alert-success';
				} else {
					//email not sent
					$msg = 'Your email has NOT been sent';
					$msgClass = 'alert-danger';
				}
			}

	
		} else {
			//Failed
			$msg = 'Please fill in all fields';
			$msgClass = 'alert-danger'; //this will add the class later on to xxx
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Website 3</title>
	<link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.min.css">
</head>
<body style="background-color: pink">
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header"><a href="index.html" class="navbar-brand">My Website</a></div>
		</div>
	</nav>
	<div class="container">
		<?php if($msg != ''): ?>
			<div class="alert <?php echo $msgClass; ?>"> <!-- xxx class added for botstrap danger/success color -->
				<?php echo $msg; ?>

			</div> 
		<?php endif; ?>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> <!-- added htmlspecialchars for security, no in this video its mentioned but another -->
			<div class="form-group">
				<label for="">Name</label>
				<input type="text" name="name" class="form-control" value="<?php
				
					//05. get the value from the input so when it fails it doesnt go away
					// uses ternary if
					echo isset($_POST['name']) ? $name : ''; 


				?>">
			</div>
			<div class="form-group">
				<label for="">Email</label>
				<input type="text" name="email" class="form-control" value="<?php

				 echo isset($_POST['email']) ? $email : ''; 

				?>">
			</div>
			<div class="form-group">
				<label for="">Message</label>
				<textarea name="message" class="form-control"><?php 

				echo isset($_POST['message']) ? $message : ''; 

				?></textarea>
			</div>
			<br>
			<button type="submit" name="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
</body>
</html>