<?php

require 'functions.php';

if ($result = bearer_http_request('https://api.wegene.com/health/risk/54a2ef12515b472e6fd8bed644af87bc', 'POST', array(
	'client_id' => CLIENT_ID,
	'client_secret' => CLIENT_SECRET,
	'report_id' => '80'
)))
{
	echo json_encode($result);
}