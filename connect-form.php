<?php 
	if(ine($_GET, 'error_message')) {
		echo $_GET['error_message'];
	} 
?>
<form method="get" action="<?php echo JOBPRGRESS_AUTHORIZATION_URL ?>" class="jp-btn-connect">
<input type="hidden" name="domain" value="<?php echo $domain; ?>">
<input type="hidden" name="redirect_uri" value="<?php echo $redirect_url; ?>">
<input type="hidden" name="client_id" value="<?php echo JOBPROGRESS_CLIENT_ID ?>"/>
<input type="hidden" name="client_secret" value="<?php echo JOBPROGRESS_CLIENT_SECRET ?>"/>
<input type="hidden" name="grant_type" value="password"/>
<input class="btn btn-blue" type="submit" value="Connect">
</form>