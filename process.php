<?php

// Begin the session
session_start();

// If it's correct, echo '1' as a string

if($_GET['captcha'] == $_SESSION['captcha_id'])

	echo 'true';
// Else echo '0' as a string
else
	echo 'false';