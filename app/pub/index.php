<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru-RU">
	<head>
		<title></title>
	   <meta charset="UTF-8" />
	   <meta name="robots" content="noindex, nofollow" />
	   <style>
	   	body{
		  margin: 0;
		  background-color: #228b22;
		}

		#basic{
		  max-width: 100%;
		  padding: 5%;
		}
		#basic > header{
		  margin-bottom: 3%;
		}
		#basic > header h1{
		  font-size: 200%;
		  color: white;
		}
		#basic[data-operator="form"] > footer form{
		  margin-top: 2%;
		  display: flex;
		}
		#basic[data-operator="form"] > footer form *{
		  margin: 5px;
		  padding: 10px;
		  flex: 2 1 auto;
		}
		#basic > footer form button{
		  background-color: #0a4500;
		  border: solid 2px white;
		  color: white;
		  font-size: 100%;
		}
		#basic[data-operator="auth"] > footer form button{
		  padding: 10px;
		  display: block;
		  margin-top: 2%;
		  float: right;
		  margin-right: 13%;
		}
		#basic[data-operator="auth"] > footer form{
		  width: 30%;
		  margin-left: 32vw;
		  margin-top: 26vh;
		}
		#basic > footer form input.auth, #basic > footer form select{
		  font-size: 100%;
		  background-color: transparent;
		  border: solid 2px white;
		  color: white;
		}
		#basic > footer form select option{
		  color: black;
		}
		#basic > footer form *::placeholder{ 
		  color: white; 
		  opacity: 0.5;
		}
		#basic > footer form input:focus{ 
		  background-color: #0a4500;
		}
		#basic > footer form input.no-auth{
		  font-size: 150%;
		  margin: 5px;
		  padding: 10px;
		  display: block;
		  background-color: transparent;
		  border: solid 2px white;
		  color: white;
		}
	   </style>
	</head>
	<body><?php include '../settings/template.php'; ?></body>
</html>
