<?php
require 'lib/vendor/autoload.php';
use Ingenico\Connect\Sdk\Client;
use Ingenico\Connect\Sdk\Communicator;
use Ingenico\Connect\Sdk\CommunicatorConfiguration;
use Ingenico\Connect\Sdk\DefaultConnection;

function connector(){ return new PDO('mysql:host=database;port=3306;dbname=aplex', 'developer', '19052000'); }

function paymentSystem(){
	if(connector()){
		if(isset($_SESSION['user'])){
			$currentApi = connector()->prepare("SELECT JSON_UNQUOTE(JSON_EXTRACT(point, '$.key.basic')) as basicKey, JSON_UNQUOTE(JSON_EXTRACT(point, '$.key.secret')) as secretKey FROM testtaskUsers WHERE phone=:u");
			$currentApi->execute(['u' => $_SESSION['user']]);
			
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
