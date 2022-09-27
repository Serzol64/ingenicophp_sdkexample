<?php
include '../payment/payment_class.php';
include '../settings/settings_class.php';


class Action{
	protected $service;
	protected $query;
	
	public function __construct($service, $query){
		$this->service = $service;
		$this->query = $query;
	}
	public function exists(){
		switch($this->service){
			case 'settings': 
				if($this->query['meta']['service'] == 'validator'){
					if($this->query['meta']['subService'] == 'auth'){
						$currentAuth = new Login();
						if($currentAuth->validator($this->query['content'])){ return TRUE; }
					}
				}
			break;
			case 'payment': 
				if($this->query['meta']['service'] == 'validator'){
					$isSuccess = TRUE;
					$paymentControl = new Success();
				
					if(!$paymentControl->validator($this->query['content'])){ $isSuccess = FALSE; }
					
					return $isSuccess;
				}
			break;
		}
	}
	public function execute(){
		switch($this->service){
			case 'settings': 
				if($this->query['meta']['service'] == 'send'){
						$currentQuery = new Form();
						return 'https://payment.' . $currentQuery->send($this->query['content']);
				}
			break;
		}
	}
}
?>
