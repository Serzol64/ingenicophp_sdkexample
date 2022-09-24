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
			case 'settings': break;
			case 'payment': break;
		}
	}
	public function execute(){
		
	}
}
?>
