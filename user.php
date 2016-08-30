<?php

require 'functions.php';

if ($result = bearer_http_request('https://api.wegene.com/user/', 'POST', array(
	'client_id' => CLIENT_ID,
	'client_secret' => CLIENT_SECRET,	
)))
{
	echo json_encode($result);
}