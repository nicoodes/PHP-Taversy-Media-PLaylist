<?php

	// Create variables for message feedback
	$msg = "";
	$msgClass = ""; // used for Bootstrap alert class (alert-success / alert-danger)

	// Preserve field values across validation failures
	$formName    = "";
	$formEmail   = "";
	$formPhone   = "";
	$formSubject = "";
	$formMessage = "";

	// 01. Check for form submission
	if (filter_has_var(INPUT_POST, 'submit')) {

		// 02. Honeypot spam check – bots fill hidden fields; humans leave them blank
		if (!empty($_POST['website'])) {
			// Silently reject spam submissions
			$msg      = 'Your message could not be sent. Please try again.';
			$msgClass = 'alert-danger';
		} else {

			// 03. Sanitize & retrieve posted values
			$formName    = htmlspecialchars(trim($_POST['name']));
			$formEmail   = htmlspecialchars(trim($_POST['email']));
			$formPhone   = htmlspecialchars(trim($_POST['phone']));
			$formSubject = htmlspecialchars(trim($_POST['subject']));
			$formMessage = htmlspecialchars(trim($_POST['message']));

			// 04. Validate required fields
			if (empty($formName) || empty($formEmail) || empty($formSubject) || empty($formMessage)) {
				$msg      = 'Please fill in all required fields (Name, Email, Subject and Message).';
				$msgClass = 'alert-danger';

			// 05. Validate name length
			} elseif (strlen($formName) < 2 || strlen($formName) > 100) {
				$msg      = 'Name must be between 2 and 100 characters.';
				$msgClass = 'alert-danger';

			// 06. Validate email address
			} elseif (filter_var($formEmail, FILTER_VALIDATE_EMAIL) === false) {
				$msg      = 'Please enter a valid email address.';
				$msgClass = 'alert-danger';

			// 07. Validate optional phone number (digits, spaces, +, -, () allowed)
			} elseif (!empty($formPhone) && !preg_match('/^[0-9\s\+\-\(\)]{7,20}$/', $formPhone)) {
				$msg      = 'Please enter a valid phone number (7–20 digits, spaces, +, - and () allowed).';
				$msgClass = 'alert-danger';

			// 08. Validate subject length
			} elseif (strlen($formSubject) < 2 || strlen($formSubject) > 150) {
				$msg      = 'Subject must be between 2 and 150 characters.';
				$msgClass = 'alert-danger';

			// 09. Validate message length
			} elseif (strlen($formMessage) < 10 || strlen($formMessage) > 2000) {
				$msg      = 'Message must be between 10 and 2000 characters.';
				$msgClass = 'alert-danger';

			} else {
				// All validation passed – build and send the email

				$toEmail = 'example@gmail.com';
				$subject = 'Contact: ' . $formSubject . ' (from ' . $formName . ')';
				$body    = '<h2>Contact Request</h2>'
				         . '<h4>Name</h4><p>'    . $formName    . '</p>'
				         . '<h4>Email</h4><p>'   . $formEmail   . '</p>'
				         . (!empty($formPhone) ? '<h4>Phone</h4><p>' . $formPhone . '</p>' : '')
				         . '<h4>Subject</h4><p>' . $formSubject . '</p>'
				         . '<h4>Message</h4><p>' . nl2br($formMessage) . '</p>';

				// Email headers
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
				$headers .= 'From: ' . $formName . ' <' . $formEmail . '>' . "\r\n";

				if (mail($toEmail, $subject, $body, $headers)) {
					$msg      = 'Thank you, ' . $formName . '! Your message has been sent successfully.';
					$msgClass = 'alert-success';
					// Clear fields on success
					$formName = $formEmail = $formPhone = $formSubject = $formMessage = "";
				} else {
					$msg      = 'Sorry, your message could not be sent. Please try again later.';
					$msgClass = 'alert-danger';
				}
			}
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Contact Us – My Website</title>
	<link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.min.css">
	<style>
		body { background-color: #f5f5f5; }
		.contact-card {
			background: #fff;
			border-radius: 6px;
			padding: 30px 40px;
			box-shadow: 0 2px 8px rgba(0,0,0,.12);
			margin-top: 30px;
			margin-bottom: 40px;
		}
		.contact-card h2 { margin-bottom: 20px; }
		.required-note { font-size: 0.85em; color: #777; margin-bottom: 15px; }
		label .req { color: #d9534f; margin-left: 2px; }
		textarea.form-control { resize: vertical; }
		.char-count { font-size: 0.8em; color: #888; text-align: right; }
	</style>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<a href="index.php" class="navbar-brand">My Website</a>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="contact-card">
					<h2>Contact Us</h2>

					<?php if ($msg !== ''): ?>
						<div class="alert <?php echo $msgClass; ?>" role="alert">
							<?php echo $msg; ?>
						</div>
					<?php endif; ?>

					<p class="required-note">Fields marked with <span class="req">*</span> are required.</p>

					<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

						<!-- Honeypot field: hidden from real users, attracts bots -->
						<div style="display:none;" aria-hidden="true">
							<label for="website">Leave this field blank</label>
							<input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
						</div>

						<div class="form-group">
							<label for="name">Name <span class="req">*</span></label>
							<input type="text" id="name" name="name" class="form-control"
							       placeholder="Your full name"
							       maxlength="100"
							       value="<?php echo $formName; ?>">
						</div>

						<div class="form-group">
							<label for="email">Email Address <span class="req">*</span></label>
							<input type="email" id="email" name="email" class="form-control"
							       placeholder="you@example.com"
							       value="<?php echo $formEmail; ?>">
						</div>

						<div class="form-group">
							<label for="phone">Phone Number <small class="text-muted">(optional)</small></label>
							<input type="tel" id="phone" name="phone" class="form-control"
							       placeholder="+1 555 000 0000"
							       maxlength="20"
							       value="<?php echo $formPhone; ?>">
						</div>

						<div class="form-group">
							<label for="subject">Subject <span class="req">*</span></label>
							<input type="text" id="subject" name="subject" class="form-control"
							       placeholder="What is this about?"
							       maxlength="150"
							       value="<?php echo $formSubject; ?>">
						</div>

						<div class="form-group">
							<label for="message">Message <span class="req">*</span></label>
							<textarea id="message" name="message" class="form-control"
							          rows="6" maxlength="2000"
							          placeholder="Write your message here (10–2000 characters)…"><?php echo $formMessage; ?></textarea>
							<div class="char-count"><span id="msgCount">0</span> / 2000 characters</div>
						</div>

						<button type="submit" name="submit" class="btn btn-primary btn-block">
							Send Message
						</button>

					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		// Live character counter for the message textarea
		(function () {
			var textarea = document.getElementById('message');
			var counter  = document.getElementById('msgCount');
			function update() {
				counter.textContent = textarea.value.length;
			}
			textarea.addEventListener('input', update);
			update(); // initialize on page load (handles preserved values)
		}());
	</script>
</body>
</html>