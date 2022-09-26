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

class Form{
	public $data;
	public $payment;
	
	public function __construct(){
		$this->data = connector();
		$this->payment = paymentSystem();
	}
	public function send($q){
		$currentApi = $this->data->prepare("SELECT JSON_UNQUOTE(JSON_EXTRACT(contact, '$.lang')) as language, JSON_UNQUOTE(JSON_EXTRACT(contact, '$.region')) as region FROM :table WHERE phone=:u");
		$currentApi->execute(['table' => $currentColumn['user'], 'u' => $q['user']]);
		
		$contactResponse = $currentApi->fetch(PDO::FETCH_ASSOC);
		
		$query = [
			'u' => $q['user'],
			'table' => $currentColumn['cart'],
			'name' => $q['title'],
			'data' => json_encode(['cost' => $q['cost'], 'count' => $q['count'], 'exchange' => $q['exchange']])
		];
		
		$processing = $this->data->prepare('INSERT INTO :table (user, title, data) VALUES (:u, :name, :data)');
		$processing->execute($query);
		
		$buyId = $this->data->lastInsertId();
		
		$hostedCheckoutSpecificInput = new HostedCheckoutSpecificInput();
		$hostedCheckoutSpecificInput->locale = $contactResponse['language'];
		$hostedCheckoutSpecificInput->returnUrl = "http://" . $_SERVER['SERVER_NAME'] . "/app/pub/payment.php";
		$hostedCheckoutSpecificInput->variant = "100";

		$amountOfMoney = new AmountOfMoney();
		$amountOfMoney->amount = (float) $query['cost'];
		$amountOfMoney->currencyCode = $query['exchange'];

		$billingAddress = new Address();
		$billingAddress->countryCode = $contactResponse['region'];

		$customer = new Customer();
		$customer->billingAddress = $billingAddress;
		$customer->merchantCustomerId = "1293";

		$order = new Order();
		$order->amountOfMoney = $amountOfMoney;
		$order->customer = $customer;

		$body = new CreateHostedCheckoutRequest();
		$body->hostedCheckoutSpecificInput = $hostedCheckoutSpecificInput;
		$body->order = $order;

		$paymentResponse = $this->payment->merchant("merchantId")->hostedcheckouts()->create($body);
		$readyPaymentResponse = json_decode($paymentResponse, true);
		
		
		$paymentData = $this->data->prepare('UPDATE :table SET payment=:query WHERE id=:cart');
		$paymentData->execute(['cart' => $buyId, 'query' => $paymentResponse, 'table' => $currentColumn['cart']]);
		
		if($paymentData){ $_SESSION['cart'] = $buyId; }
		
		return $readyPaymentResponse['partialRedirectUrl'];
	}
}
class Login{
	public $data;
	public $payment;
	
	public function __construct(){
		$this->data = connector();
		$this->payment = paymentSystem();
	}
	public function validator($q){
		$user = $q['user'];
		$pass = $q['password'];
		
		$auth = $this->data->prepare("SELECT * FROM :table WHERE phone=:u AND password=:p");
		$auth->execute(['table' => $currentColumn['user'], 'u' => $user, 'p' => $pass]);
		
		$validProccess = !$auth->fetchAll() ? TRUE : NULL;
		return $validProccess;
	}
}
?>
