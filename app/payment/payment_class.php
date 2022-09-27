<?php
require '../lib/vendor/autoload.php';
require_once '../.config.php';

use Ingenico\Connect\Sdk\CallContext;
use Ingenico\Connect\Sdk\Domain\Hostedcheckout\Definitions\HostedCheckoutSpecificInput;
use Ingenico\Connect\Sdk\Domain\Definitions\AmountOfMoney;
use Ingenico\Connect\Sdk\Domain\Definitions\Address;
use Ingenico\Connect\Sdk\Domain\Payment\Definitions\Customer;
use Ingenico\Connect\Sdk\Domain\Payment\Definitions\Order;
use Ingenico\Connect\Sdk\Domain\Hostedcheckout\CreateHostedCheckoutRequest;

class Success{
	public $data;
	public $payment;
	
	public function __construct(){
		$this->data = connector();
		$this->payment = paymentSystem();
	}
	public function validator($q){
		$paymentResponse = $this->payment->merchant("1293")->hostedcheckouts()->get($q['checkout']);
		$readyPaymentResponse = $paymentResponse;
		
		if(!$readyPaymentResponse->createdPaymentOutput->payment->statusOutput->errors){
			if($this->execute($q)){ return TRUE; }
		}
		else{ return FALSE; }
	}
	private function execute($q){
		$buy = $q['id'];
		
		$deleteBuy = $this->data->prepare('DELETE FROM testtaskCarts WHERE id=:cart');
		$deleteBuy->execute(['cart' => $buy]);
		
		if($deleteBuy){ return TRUE; }
		
	}
}
?>
