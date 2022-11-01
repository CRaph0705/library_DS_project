<?php
//on démarre une session ici
session_start();
require_once('config.php');

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Projet bibliothèque</title>
	<link rel="stylesheet" href=<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<header>
	<?php
	if (empty($_POST["user_name"]) && empty($_SESSION["user_name"])) {
		header("location:verification.php");
		exit;
	} else {
		if (!empty($_POST["user_name"])) {
			$userName = $_POST["user_name"];
			$_SESSION["user_name"] = $userName;
		} else {
			$userName = $_SESSION["user_name"];
		}

		header("index.php");
		echo 'Bienvenue ' . $userName . ' !' . "<br>";
	}

	?>
</header>

<body>

	<main class="container">
		<div class="row">
			<section class="col-12">
				<?php
				if (!empty($_SESSION['erreur'])) {
					echo '<div class="alert alert-danger" role="alert">
							' . $_SESSION['erreur'] . '
						</div>';
					$_SESSION['erreur'] = "";
				}
				?>
				<?php
				if (!empty($_SESSION['message'])) {
					echo '<div class="alert alert-success" role="alert">
							' . $_SESSION['message'] . '
						</div>';
					$_SESSION['message'] = "";
				}
				?>




				<h1>Liste des livres</h1>
				<table>
					<thead>
						<th>Titre</th>
						<th>Auteur</th>
						<th>Catégorie</th>
						<th>Année de parution</th>
					</thead>
					<tbody>
						<?php
						foreach ($books as $book) {
						?>
							<tr>
								<td><?= $book['title'] ?></td>
								<td><?= $book['fullname']?></td>
								<td><?= $book['category_name'] ?></td>
								<td><?= $book['release_year'] ?></td>
								<td><a href="read.php?id=<?= $book['id'] ?>" class="btn btn-success">Voir plus</a></td>
								<td><a href="update.php?id=<?= $book['id'] ?>" class="btn btn-warning" style="margin:0 5% 0 5%">Modifier</a></td>
								<td><a href="delete.php?id=<?= $book['id'] ?>" class="btn btn-danger" style="margin-left:10%">Supprimer</a></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
				<a href="create.php" class="btn btn-primary">Ajouter un livre</a>
			</section>
		</div>
	</main>
</body>

</html>