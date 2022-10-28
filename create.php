<?php
session_start();
if($_POST){
    if(!empty($_POST['title']) && !empty($_POST['author']) && !empty($_POST['release_year'])) {
        require_once('config.php');
        require_once('close.php');
        // on nettoie les input envoyés
        $title = strip_tags($_POST['title']);
        $author_firstname = strip_tags($_POST['author_firstname']);
        $author_lastname = strip_tags($_POST['author_lastname']);
        $description = strip_tags($_POST['description']);
        $category = strip_tags($_POST['category']);
        $release_year = strip_tags($_POST['release_year']);
        
        $sql = 'INSERT INTO `book`(`title`, `author_firstname`, `author_lastname`, `description`, `category`, `release_year`) VALUES (:title, :author_firstname, :author_lastname, :description, :category, :release_year);';
        $query = $db->prepare($sql);
        $query->bindValue(':title', $title, PDO::PARAM_STR);
        $query->bindValue(':author_firstname', $author_firstname, PDO::PARAM_STR);
        $query->bindValue(':author_lastname', $author_lastname, PDO::PARAM_STR);
        $query->bindValue(':description', $description, PDO::PARAM_STR);
        $query->bindValue(':category', $category, PDO::PARAM_STR);
        $query->bindValue(':release_year', $release_year, PDO::PARAM_STR);
        $query->execute();

        $_SESSION['message']= "Livre ajouté";
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
    <title>Ajouter un livre</title>
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
                        <input type="text" name="title" id="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Auteur</label><br>
                        <label for="author_firstname">Prénom</label>
                        <input type="text" name="author_firstname" id="author_firstname" class="form-control">
                        <label for="author_lastname">Nom</label>
                        <input type="text" name="author_lastname" id="author_lastname" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="category">Catégorie</label>
                        <input type="text" name="category" id="category" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="release_year">Année de parution</label>
                        <input type="int" name="release_year" id="release_year" class="form-control">
                    </div>
                    <div style="margin-top:2%"><a href="index.php" class="btn btn-primary">Retour</a><button class="btn btn-success" style="margin-left:5%">Ajouter</button></div>
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