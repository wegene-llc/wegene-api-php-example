<?php

require 'functions.php';

if ($result = bearer_http_request('https://api.wegene.com/genotypes/54a2ef12515b472e6fd8bed644af87bc', 'POST', array(
	'client_id' => CLIENT_ID,
	'client_secret' => CLIENT_SECRET,
	'locations' => 'rs1051730 rs28936415 i5012680 i5012679 rs1805137 i3002517 rs111033199 rs4565946'
)))
{
	echo json_encode($result);
}