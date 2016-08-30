<?php

require 'functions.php';

if ($_GET['code'])
{
	// 获取 Access token 并且存起来，一个 Code 只能使用一次
	if ($access_token = api_http_request('https://api.wegene.com/token/', 'POST', array(
		'client_id' => CLIENT_ID,
		'client_secret' => CLIENT_SECRET,
		'grant_type' => 'authorization_code',
		'scope' => 'basic rs1051730 rs28936415 i5012680 i5012679 rs1805137 i3002517 rs111033199 rs4565946 sport health',
		'code' => $_GET['code']
	)))
	{
		file_put_contents('TOKEN', json_encode($access_token));
		
		echo json_encode($access_token);
	}
}