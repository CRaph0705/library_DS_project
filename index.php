<?php
//on démarre une session ici
session_start();
require_once('config.php');
require_once('functionsSQL.php');

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
						<th>ID</th>
						<th>Title</th>
						<th>Description</th>
						<th>Author ID</th>
						<th>Category ID</th>
						<th>Release Year</th>
					</thead>
					<tbody>
						<?php
						foreach ($books as $book) {
						?>
							<tr>
								<td><?= $book['id'] ?></td>
								<td><?= $book['title'] ?></td>
								<td><?= $book['description'] ?></td>
								<td><?= $book['author_id'] ?></td>
								<td><?= $book['category_id'] ?></td>
								<td><?= $book['release_year'] ?></td>
								<td><a href="read.php?id=<?= $book['id'] ?>" class="btn btn-success">Voir plus</a></td>
								<td><a></a></td>
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