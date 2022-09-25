<?php
require '../vendor/autoload.php';
include_once '../.config.php';

use Ingenico\Connect\Sdk\Client;
use Ingenico\Connect\Sdk\Communicator;
use Ingenico\Connect\Sdk\CommunicatorConfiguration;
use Ingenico\Connect\Sdk\DefaultConnection;
use Ingenico\Connect\Sdk\CallContext;


function paymentSystemConnect(){
	if(connector()){
		if(isset($_SESSION['user'])){
			$currentApi = connector()->prepare("SELECT JSON_UNQUOTE(JSON_EXTRACT(point, '$.key.basic')) as basicKey, JSON_UNQUOTE(JSON_EXTRACT(point, '$.key.secret')) as secretKey FROM :table WHERE phone=:u");
			$currentApi->execute(['table' => $currentColumn['user'], 'u' => $_SESSION['user']]);
			
			$response = $currentApi->fetch(PDO::FETCH_ASSOC);
				
			$communicatorConfiguration = new CommunicatorConfiguration($response['basicKey'], $response['secretKey'], "https://eu.sandbox.api-ingenico.com", NULL);
			$connection = new DefaultConnection();
			$communicator = new Communicator($connection, $communicatorConfiguration);

			return new Client($communicator);
			
		}
		else{	
			$communicatorConfiguration = new CommunicatorConfiguration('73dc760f4cd2a081', '2FSK/31pWLipRXaBHKWlm6HV8/ZNX6J4WxGyLVGjAhE=', "https://eu.sandbox.api-ingenico.com", NULL);
			$connection = new DefaultConnection();
			$communicator = new Communicator($connection, $communicatorConfiguration);

			return new Client($communicator);
		}
	}
	else{ die('Error'); }
}

class Success{
	public $data;
	public $payment;
	
	public function __construct(){
		$this->data = connector();
		$this->payment = paymentSystemConnect();
	}
	public function validator($q){
		$buy = $q['id'];
		
		$currentBuy = $this->data->prepare('SELECT JSON_UNQUOTE(JSON_EXECUTE(payment, "$.hostedCheckoutId")) as checkout FROM :table WHERE id=:cart');
		$currentBuy->execute(['cart' => $buy, 'table' => $currentColumn['cart']]);
		
		$buyResponse = $currentBuy->fetch(PDO::FETCH_ASSOC);
		
		$paymentResponse = $this->payment->merchant("merchantId")->hostedcheckouts()->get($buyResponse['checkout']);
		$readyPaymentResponse = json_decode($paymentResponse, true);
		
		if($readyPaymentResponse['status'] == PAYMENT_CREATED){
			if($this->execute($buy)){ return TRUE; }
		}
		else{ return FALSE; }
	}
	private function execute($q){
		$buy = $q['id'];
		
		$deleteBuy = $this->data->prepare('DELETE FROM :table WHERE id=:cart');
		$deleteBuy->execute(['cart' => $buy, 'table' => $currentColumn['cart']]);
		
		if($deleteBuy){ return TRUE; }
		
	}
}
?>
