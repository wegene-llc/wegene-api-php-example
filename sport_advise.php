<?php

require 'functions.php';

if ($result = bearer_http_request_xml('https://api.wegene.com/sport/advise/54a2ef12515b472e6fd8bed644af87bc', 'POST', array(
	'height' => 175,
	'weight' => 80,
	'sex' => 'man',
	'age' => 27,
	'output' => 'xml'
)))
{
	echo $result;
}