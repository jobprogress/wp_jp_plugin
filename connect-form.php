<form method="get" action="<?php echo JOBPRGRESS_AUTHORIZATION_URL ?>">
<input type="hidden" name="domain" value="<?php echo $domain; ?>">
<input type="hidden" name="redirect_uri" value="<?php echo $domain.$_SERVER['REQUEST_URI']; ?>">
<input type="hidden" name="client_id" value="<?php echo JOBPROGRESS_CLIENT_ID ?>"/>
<input type="hidden" name="client_secret" value="<?php echo JOBPROGRESS_CLIENT_SECRET ?>"/>
<input type="hidden" name="grant_type" value="password"/>
<input type="submit" value="Connect">
</form>