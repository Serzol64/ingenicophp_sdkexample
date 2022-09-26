<?php
require '../lib/vendor/autoload.php';
require_once '../.config.php';

use Ingenico\Connect\Sdk\CallContext;


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
