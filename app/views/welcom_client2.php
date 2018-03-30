<?php
 
	if( isset( $_SESSION['login_user']) ){

		$pagetitle = $title;

	} else {
		header("location: UserAuthentication/showLogin");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?= $pagetitle ?></title>
	</head>
	<body>
		<div id="profile">
		<b id="welcome">Welcome : <i><?= $user->nombre; ?></i></b>
		<b id="logout"><a href="logout"> Salir del Sistema </a></b>
		</div>
	</body>
</html>
