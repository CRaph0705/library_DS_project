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
    }

    ?>
    <a class="btn btn-primary" href="logout.php">Déconnexion</a>
</header>

<body>

    <main class="container">
        <div class="author">
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
                        <input type="text" id="searchInput" placeholder="Auteur" class="form-control" name="searchInput">
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </form>
                    <thead>
                        <th>Prénom</th>
                        <th>Nom de famille</th>
                    </thead>
                    <tbody>
                        <?php

                        if (!empty($_POST['searchInput'])) {
                            $searchInput = $_POST['searchInput'];

                            $searchQuery = $db->prepare('
                                SELECT author.fullname 
                                FROM author
                                WHERE book.title LIKE :searchInput OR author.fullname 
                                LIKE :searchInput OR category_name LIKE :searchInput
								');
                            $searchQuery->bindValue(':searchInput', '%' . $searchInput . '%', PDO::PARAM_STR);
                            $searchQuery->execute();

                            $searchResults = $searchQuery->fetchAll(PDO::FETCH_ASSOC);

                            if ($searchResults) {

                                foreach ($searchResults as $row) {
                        ?>
                                    <tr>
                                        <td><?= $author['fullname'] ?></td>
                                        <td><a href="readAuthor.php?id=<?= $row['id'] ?>" class="btn btn-success">Voir plus</a></td>
                                        <td><a href="updateAuthor.php?id=<?= $row['id'] ?>" class="btn btn-warning" style="margin:0 5% 0 5%">Modifier</a></td>
                                        <td><a href="deleteAuthor.php?id=<?= $row['id'] ?>" class="btn btn-danger" style="margin-left:10%">Supprimer</a></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <a href="indexAuthors.php" class="btn btn-primary">Retour</a>
                            <?php
                            } else {
                                echo "Nop, auteur inconnu.";
                            ?>
                                <a href="indexAuthors.php" class="btn btn-primary">Ou revenir à l'index</a>
                            <?php
                            }
                        } else {
                            foreach ($authors as $author) {
                            ?>
                                <tr>
                                    <td><?= $author['fullname'] ?></td>
                                    <td><a href="readAuthor.php?id=<?= $author['id'] ?>" class="btn btn-success">Voir plus</a></td>
                                    <td><a href="updateAuthor.php?id=<?= $author['id'] ?>" class="btn btn-warning" style="margin:0 5% 0 5%">Modifier</a></td>
                                    <td><a href="deleteAuthor.php?id=<?= $author['id'] ?>" class="btn btn-danger" style="margin-left:10%">Supprimer</a></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <a href="createAuthor.php" class="btn btn-primary">Ajouter un auteur</a>
                <a href="index.php" class="btn btn-primary">Liste des livres</a>
            </section>
        </div>
    </main>
</body>

</html>