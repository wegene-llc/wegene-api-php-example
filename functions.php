<?php

require_once 'config.php';

function get_access_token()
{
	$token = json_decode(file_get_contents('TOKEN'), true);
	
	return $token['access_token'];
}

function bearer_http_request($url, $method, $post_fields = null)
{
	if ($response = w_http_request($url, $method, $post_fields, 15, array(
		'Authorization: Bearer ' . get_access_token()
	)))
	{
		$response = json_decode($response, true);
		
		if ($response['result'] == 'error')
		{
			die($response['error_message']);
		}
	}
	
	return $response;
}

function bearer_http_request_xml($url, $method, $post_fields = null)
{
	if ($response = w_http_request($url, $method, $post_fields, 15, array(
		'Authorization: Bearer ' . get_access_token()
	)))
	{
		return $response;
	}
}


function api_http_request($url, $method, $post_fields = null, $time_out = 15, $header = null, $cookie = null)
{
	if ($response = w_http_request($url, $method, $post_fields, $time_out, $header, $cookie))
	{		
		$response = json_decode($response, true);
		
		if ($response['result'] == 'error')
		{
			die($response['error_message']);
		}
	}
	
	return $response;
}

function w_http_request($url, $method, $post_fields = null, $time_out = 15, $header = null, $cookie = null)
{
	if (!function_exists('curl_init'))
	{
		die('CURL not support');
	}

	$curl = curl_init();

	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($curl, CURLOPT_TIMEOUT, $time_out);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_HEADER, FALSE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

	switch ($method)
	{
		case 'POST' :
			curl_setopt($curl, CURLOPT_POST, TRUE);

			if ($post_fields)
			{
				curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
			}
		break;

		case 'DELETE' :
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

			if ($post_fields)
			{
				$url = "{$url}?{$post_fields}";
			}
		break;
	}

	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLINFO_HEADER_OUT, TRUE);

	if (isset($header) AND !is_array($header))
	{
		unset($header);
	}
	
	if ($header)
	{
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	}

	if (substr($url, 0, 8) == 'https://')
	{
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
	}

	curl_setopt($curl, CURLOPT_USERAGENT, 'WeCenter/2015');

	if ($cookie AND is_array($cookie))
	{
		curl_setopt($curl, CURLOPT_COOKIE, urldecode(http_build_query($cookie, '', '; ')));
	}

	$response = curl_exec($curl);

	curl_close($curl);

	return $response;
}