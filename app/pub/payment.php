<!DOCTYPE html>
<html lang="ru-RU">
	<head>
		<title></title>
	   <meta charset="UTF-8" />
	   <style type="text/css">
	   	body{
		  margin: 0;
		}

		#success{
		  max-width: 90%;
		  padding: 5%;
		  display: grid; 
		  grid-auto-flow: row dense; 
		  grid-template-columns: 25% 75%; 
		  grid-template-rows: 1fr 1fr; 
		  gap: 1% 2%; 
		  width: 100%; 
		}

		#success > header *{
		  margin-left: 20%;
		  width: 150px;
		  object-fit: cover;
		}
		#success > footer *{
		  margin-top: 2%;
		  display: block;
		}
		#success > footer h2{
		  font-size: 180%;
		}

		#success[data-operator='ok'] > footer h2{ color: #228b22; }
		#success[data-operator='fail'] > footer h2{ color: #ce2029; }
	   </style>
	</head>
	<body><?php include '../payment/template.php'; ?></body>
</html>
