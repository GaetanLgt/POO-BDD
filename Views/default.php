<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
		integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="https://bootswatch.com/5/sketchy/bootstrap.min.css">


</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container-fluid">
		<a class="navbar-brand" href="/">Mes annonces</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02"
			aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarColor02">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="/">Accueil
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/annonces">Liste des anononces</a>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<?php if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])): ?>
				<li class="nav-item">
					<a class="nav-link" href="/users/profil">Profil</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/users/logout">Déconnexion</a>
				</li>
				<?php
else: ?>
				<li class="nav-item">
					<a class="nav-link" href="/users/login">Connexion
					</a>
				</li>

				<?php
endif; ?>
			</ul>

		</div>
	</div>
</nav>


<body>
	<div class="container">
		<?php
if (!empty($_SESSION['erreur'])): ?>
		<div class="alert alert-dismissible alert-danger">
			<?php
	echo $_SESSION['erreur'];
	unset($_SESSION['erreur']);
?>
		</div>
		<?php
endif; ?>
		<?php
if (!empty($_SESSION['message'])): ?>
		<div class="alert alert-dismissible alert-success">
			<?php
	echo $_SESSION['message'];
	unset($_SESSION['message']);
?>
		</div>
		<?php
endif; ?>
		<?= $contenu; ?>
	</div>



	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
		integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
	</script>
</body>

</html>