<?php
require 'lib/vendor/autoload.php';
use Ingenico\Connect\Sdk\Client;
use Ingenico\Connect\Sdk\Communicator;
use Ingenico\Connect\Sdk\CommunicatorConfiguration;
use Ingenico\Connect\Sdk\DefaultConnection;

$isRemote = $_SERVER['SERVER_NAME'] != 'testtask64.local';
$currentColumn = [
	'user' => $isRemote ? 'users' : 'testtaskUsers',
	'cart' => $isRemote ? 'carts' : 'testtaskCarts'
];

function connector(){
	if($isRemote){ return new PDO('mysql:host=fdb30.awardspace.net;port=3306;dbname=4182102_testtask', '4182102_testtask', 'seriy2000-testtask'); }
	else{ return new PDO('mysql:host=database;port=3306;dbname=aplex', 'developer', '19052000'); }
}

function paymentSystem(){
	if(connector()){
		if(isset($_SESSION['user'])){
			$currentApi = connector()->prepare("SELECT JSON_UNQUOTE(JSON_EXTRACT(point, '$.key.basic')) as basicKey, JSON_UNQUOTE(JSON_EXTRACT(point, '$.key.secret')) as secretKey FROM :table WHERE phone=:u");
			$currentApi->execute(['table' => $currentColumn['user'], 'u' => $_SESSION['user']]);
			
			$response = $currentApi->fetch(PDO::FETCH_ASSOC);
				
			$communicatorConfiguration = new CommunicatorConfiguration($response['basicKey'], $response['secretKey'], "https://eu.sandbox.api-ingenico.com", null);
			$connection = new DefaultConnection();
			$communicator = new Communicator($connection, $communicatorConfiguration);

			return new Client($communicator);
			
		}
		else{	
			$communicatorConfiguration = new CommunicatorConfiguration('73dc760f4cd2a081', '2FSK/31pWLipRXaBHKWlm6HV8/ZNX6J4WxGyLVGjAhE=', "https://eu.sandbox.api-ingenico.com", null);
			$connection = new DefaultConnection();
			$communicator = new Communicator($connection, $communicatorConfiguration);

			return new Client($communicator);
		}
	}
	else{ die('Error'); }
}
?>
