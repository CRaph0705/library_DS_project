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



if($_POST){
    if(!empty($_POST['title']) && !empty($_POST['author']) && !empty($_POST['release_year']) && !empty($_POST['id'])) {
        require_once('config.php');
        require_once('close.php');
        // on nettoie les input envoyés
        $id = strip_tags($_POST['id']);
        $title = strip_tags($_POST['title']);
        $author_firstname = strip_tags($_POST['author_firstname']);
        $author_lastname = strip_tags($_POST['author_lastname']);
        $description = strip_tags($_POST['description']);
        $category = strip_tags($_POST['category']);
        $release_year = strip_tags($_POST['release_year']);
        
        $sql = 'UPDATE `book` SET `title`=:title, `author_firstname`=:author_firstname, `author_lastname`=:author_lastname, `description`=:description, `category`=:category, `release_year`=:release_year) WHERE `id`=:id;';
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':title', $title, PDO::PARAM_STR);
        $query->bindValue(':author_firstname', $author_firstname, PDO::PARAM_STR);
        $query->bindValue(':author_lastname', $author_lastname, PDO::PARAM_STR);
        $query->bindValue(':description', $description, PDO::PARAM_STR);
        $query->bindValue(':category', $category, PDO::PARAM_STR);
        $query->bindValue(':release_year', $release_year, PDO::PARAM_INT);
        $query->execute();

        $_SESSION['message']= "Livre modifié";
        require_once('close.php');
        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Merci de renseigner à minima le titre, nom et prénom de l'auteur et l'année de parution.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <?php
        if(!empty($_SESSION['erreur'])){
            echo '<div class="alert alert-danger" role="alert">
                    '. $_SESSION['erreur'].'
                </div>';
                $_SESSION['erreur'] = "";
        }
        ?>
        <div class="row">
            <section class="col-12">
                <h2>Ajouter un livre </h2>
                <form method="post">
                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" name="title" id="title" class="form-control" value=<?= $bookPage['title'] ?>>
                    </div>
                    <div class="form-group">
                        <label>Auteur</label><br>
                        <label for="author_firstname">Prénom</label>
                        <input type="text" name="author_firstname" id="author_firstname" class="form-control" value=<?= $bookPage['firstname'] ?>>
                        <label for="author_lastname">Nom</label>
                        <input type="text" name="author_lastname" id="author_lastname" class="form-control" value=<?= $bookPage['lastname'] ?>>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control" value=<?= $bookPage['description'] ?>>
                    </div>
                    <div class="form-group">
                        <label for="category">Catégorie</label>
                        <input type="text" name="category" id="category" class="form-control" value=<?= $bookPage['description'] ?>>
                    </div>
                    <div class="form-group">
                        <label for="release_year">Année de parution</label>
                        <input type="int" name="release_year" id="release_year" class="form-control" value=<?= $bookPage['release_year'] ?>>
                    </div>
                    <input type="hidden" value="">
                    <div style="margin-top:2%"><a href="index.php" class="btn btn-primary">Retour</a><button class="btn btn-success" style="margin-left:5%">Modifier</button></div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>










<?php
//SELECT sur auteur et category
// + add new option

?>