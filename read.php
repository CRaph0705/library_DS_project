<?php
//on démarre une session ici
session_start();


// Est-ce que l'id existe et n'est pas vide dans l'url
if(!empty($_GET['id'])){
    require_once('config.php');
    // on nettoie l'id envoyé
    $id = strip_tags($_GET['id']);
    $sql = 'SELECT book.*, author.lastname, author.firstname, category.name FROM `book` INNER JOIN author ON author.id=book.author_id INNER JOIN category ON category.id=book.category_id WHERE book.`id`= :id;';
    // On prépare la requête 
    $query = $db->prepare($sql);
    // On accroche les parametres 
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    //exec requete
    $query->execute();
    //Récup le resultat de la requete
    $bookPage = $query->fetch();

    if (!$bookPage) {
        $_SESSION['erreur'] = "URL invalide";
        header('Location: index.php');
        exit;
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h2>Détails du livre <?= $bookPage['title'] ?></h2>
                <p>ID : <?= $bookPage['id'] ?></p>
                <p>Titre : <?= $bookPage['title'] ?></p>
                <p>Auteur : <?= $bookPage['firstname']. " " .$bookPage['lastname'] ?></p>
                <p>Catégorie : <?=$bookPage['name']  ?></p>
                <p>Description : <?= $bookPage['description'] ?></p>
                <p>Date de parution : <?= $bookPage['release_year'] ?></p>
                <p style="margin-top:2%"><a href="index.php" class="btn btn-primary"> Retour </a><a href="update.php?id=<?= $bookPage['id']?>" class="btn btn-warning" style="margin : 0 5% 0 5%"> Modifier </a><a href="delete.php" class="btn btn-danger"> Supprimer </a></p>
            </section>
        </div>
    </main>
</body>
</html>