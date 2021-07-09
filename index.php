<?php

// LOGS
ini_set( 'log_errors', true );
ini_set( 'error_log',  __DIR__ . '/debug.log' );

// CONFIG
require_once __DIR__ . '/config.php';

// COMPOSER
require_once APP_DIR  . 'vendor/autoload.php';

// GOOGLE
$client = new Google_Client();
$client->setApplicationName('Budget Dashboard');
$client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
$client->setAccessType('offline');
$client->setAuthConfig('credentials.json');
$service = new Google_Service_Sheets( $client );

// DATA
$response = $service->spreadsheets_values->get( SHEET_ID, 'Dashboard!B24:B25' );
$values   = $response->getValues();

$sum = 0;

if ( !empty($values) ) { foreach( $values as $value ) {
	$num = (float) str_replace( '$', '', $value[0] );
	$sum += $num;
}}

?><!DOCTYPE html>

<html lang="en">
<head>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width" />
	<meta name="robots"   content="noindex">

	<title>Budget</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet"> 

	<link rel="shortcut icon" type="image/png" href="<?=APP_URL?>/icon.png">
	<link rel="apple-touch-icon" href="<?=APP_URL?>/icon.png">

	<style>
	
		body {
			background: #5CB85C;
			font-family: 'Roboto', sans-serif;
		}

		.budget-container {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			display: flex;
			align-items: center;
			justify-content: center;
			flex-direction: column;
		}

		.budget-value {
			text-align: center;
			font-weight: bold;
			font-size: 19vw;
			margin: 0;
		}

		.budget-desc {
			margin: .5em 0 0;
			font-weight: bold;
			font-size: 5vw;
		}

	</style>

</head>

<body>

	<div class="budget-container">

		<div class="budget-value">$<?=number_format( $sum, 2 )?></div>

		<div class="budget-desc">remaining in <?=date('F Y')?></div>

	</div>

</body>
</html>
