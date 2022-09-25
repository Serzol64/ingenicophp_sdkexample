<?php
include_once '../lib/actions_class.php';
$service = 'settings';


if(isset($_SESSION['user'])){
	if(isset($_POST['title'])){
		$sendQuery = [
			'meta' => [
					'service' => 'send'
				], 
				'content' => [
					'user' => $_SESSION['user'],
					'title' => $_POST['title'],
					'cost' => $_POST['cost'],
					'exchange' => $_POST['exchange'],
					'count' => $_POST['count']
				]
		];
		
		$buyResult = [
			new Action($service, $sendQuery)
		];
		
		$buyResult[0]->execute();
	}
?>
<section id="basic" data-operator="form">
	<header>
		<h1>Введите данные о товаре и оплатите заказ</h1>
	</header>
	<footer>
		<form action="/app/pub/index.php" method="post" enctype="multipart/form-data">
		  <input type="text" name="title" value="" class="auth" id="name" placeholder="Название товара" required />
		  <input type="text" name="cost" value="" class="auth" id="cost" placeholder="Стоимость" required pattern="\-?\d+(\.\d{0,})?" title="Здесь введите только целые числа и числа с плавающей точкой"/>
		  <select name="exchange" required>
		   <option>Выберите валюту</option>
			<option value="USD">USD</option>
			<option value="EUR">EUR</option>
		  </select>
		  <input type="number" name="count" class="auth" id="count" placeholder="Введите или выберите его количество" step="1" min="1"/>
		  <button type="submit">Отправить запрос</button>
	</form>
	</footer>
</section>
<?php 
} 
else { 
	if(isset($_POST['phone'])){
		$authQuery = [
			[
				'meta' => [
					'service' => 'validator',
					'subService' => 'auth'
				], 
				'content' => [
					'user' => $_POST['phone'],
					'password' => $_POST['password']
				]
			]
		];
		
		$authResult = [
			new Action($service, $authQuery[0])
		];
		
		if($authResult[0]->exists()){
			$_SESSION['user'] = $_POST['phone'];
			echo "<script>window.reload(true);</script>"; 
		}
		else{ $validError = 'Номер телефона и пароль, либо одно или другое не существуют в базе. Проверьте правильность введёных данных. Если данные верны, то мы решим проблему в системе авторизации!'; }
	}
?>
<section id="basic" data-operator="auth">
	<header>
		<h1>Страница авторизации</h1>
	</header>
	<footer>
		<form action="/app/pub/index.php" method="post" enctype="multipart/form-data">
			<input type="text" name="phone" value="" class="no-auth" id="login" placeholder="Номер телефона" required />
			<input type="password" name="password" value="" class="no-auth" id="pass" placeholder="Пароль" required />
			<button type="submit">Войти в систему</button>
		</form>
	</footer>
	<?php if($validError){ ?><script>alert('<?php echo $validError; ?>');</script><?php } ?>
</section>
<?php } ?>
