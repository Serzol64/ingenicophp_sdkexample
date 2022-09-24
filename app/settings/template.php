<?php
include_once '../lib/actions_class.php';
$service = 'payment';

if(){
	
?>
<section id="basic" data-operator="form">
	<header>
		<h1>Введите данные о товаре и оплатите заказ</h1>
	</header>
	<footer>
		<form action="index.php" method="post" enctype="multipart/form-data">
		  <input type="text" name="title" value="" class="auth" id="name" placeholder="Название товара" required />
		  <input type="text" name="cost" value="" class="auth" id="cost" placeholder="Стоимость" required />
		  <select name="exchange" required>
		   <option>Выберите валюту</option>
			<option value="USD">USD</option>
			<option value="EUR">EUR</option>
		  </select>
		  <input type="number" name="count" class="auth" id="count" placeholder="Введите или выберите его количество" />
		  <button type="submit">Отправить запрос</button>
	</form>
	</footer>
</section>
<?php 
} 
else { 
	
?>
<section id="basic" data-operator="auth">
	<header>
		<h1>Страница авторизации</h1>
	</header>
	<footer>
		<form action="index.php" method="post" enctype="multipart/form-data">
			<input type="text" name="phone" value="" class="no-auth" id="name" placeholder="Номер телефона" required />
			<input type="text" name="password" value="" class="no-auth" id="cost" placeholder="Пароль" required />
			<button type="submit">Войти в систему</button>
		</form>
	</footer>
</section>
<?php } ?>
