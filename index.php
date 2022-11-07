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
        //header("index.php");
        echo 'Bienvenue ' . $userName . ' !' . "<br>";
    }

    ?>
	<a class="btn btn-primary" href="logout.php">Déconnexion</a>
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
                    <form method="post">
                        <label for="">Recherche</label>
                        <input type="text" id="searchInput" placeholder="Titre, Auteur, Catégorie..." class="form-control" name="searchInput">
                        <button type="submit" class="btn btn-primary" >Rechercher</button>
                    </form>
                    <thead>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Catégorie</th>
                        <th>Année de parution</th>
                    </thead>
                    <tbody>
                        <?php

                        if (!empty($_POST['searchInput'])) {
                            $searchInput = $_POST['searchInput'];

                            $searchQuery = $db->prepare('
                                SELECT book.id, book.title, book.book_description, book.author_id, book.category_id, book.release_year,
                                        category.category_name, author.fullname 
                                FROM book
                                INNER JOIN author 
                                ON author.id=book.author_id
                                INNER JOIN category
                                ON category.id=book.category_id
                                WHERE book.title LIKE :searchInput OR author.fullname LIKE :searchInput OR category_name LIKE :searchInput
								');
                            $searchQuery->bindValue(':searchInput', '%'.$searchInput.'%', PDO::PARAM_STR);
                            $searchQuery->execute();

                            $searchResults = $searchQuery->fetchAll(PDO::FETCH_ASSOC);

                            if($searchResults){

                                foreach ($searchResults as $row) {
                                    ?>
                                    <tr>
                                        <td><?= $row['title'] ?></td>
                                        <td><?= $row['fullname'] ?></td>
                                        <td><?= $row['category_name'] ?></td>
                                        <td><?= $row['release_year'] ?></td>
                                        <td><a href="read.php?id=<?= $row['id'] ?>" class="btn btn-success">Voir plus</a></td>
                                        <td><a href="update.php?id=<?= $row['id'] ?>" class="btn btn-warning" style="margin:0 5% 0 5%">Modifier</a></td>
                                        <td><a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger" style="margin-left:10%">Supprimer</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>                                    
                                <a href="index.php" class="btn btn-primary">Retour</a>
                            <?php
                            } else {
                            echo "Oops, on a rien trouvé de similaire. Essaye autre chose.";
                            ?>
                                <a href="index.php" class="btn btn-primary">Ou revenir à l'index</a>
                                <?php
                            }
                        } else {
                            foreach ($books as $book) {
                            ?>
                                <tr>
                                    <td><?= $book['title'] ?></td>
                                    <td><?= $book['fullname'] ?></td>
                                    <td><?= $book['category_name'] ?></td>
                                    <td><?= $book['release_year'] ?></td>
                                    <td><a href="read.php?id=<?= $book['id'] ?>" class="btn btn-success">Voir plus</a></td>
                                    <td><a href="update.php?id=<?= $book['id'] ?>" class="btn btn-warning" style="margin:0 5% 0 5%">Modifier</a></td>
                                    <td><a href="delete.php?id=<?= $book['id'] ?>" class="btn btn-danger" style="margin-left:10%">Supprimer</a></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <a href="create.php" class="btn btn-primary">Ajouter un livre</a>
                <a href="author.php" class="btn btn-primary">Ajouter un auteur</a>
            </section>
        </div>
    </main>
</body>

</html>