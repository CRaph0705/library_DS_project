<?php


//on démarre une session ici
session_start();


if(isset($_POST['modify'])){        //var_dump($_POST); die;

    if(!empty($_POST['title']) && !empty($_POST['selected_author']) && !empty($_POST['release_year']) && !empty($_POST['id'])) {
        require_once('config.php');
        require_once('close.php');
        // on nettoie les input envoyés
        $id = strip_tags(intval($_POST['id']));
        $title = strip_tags(htmlspecialchars($_POST['title']));
        $author_id = strip_tags(intval($_POST['selected_author']));
        $book_description = strip_tags(htmlspecialchars($_POST['book_description']));
        $category_id = strip_tags(intval($_POST['selected_category']));
        $release_year = strip_tags(intval($_POST['release_year']));

        
        $sql = "UPDATE `book` SET `title`=:title, `author_id`=:author_id, `book_description`=:book_description, `category_id`=:category_id, `release_year`=:release_year WHERE `id`=:id;";
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':title', $title, PDO::PARAM_STR);
        $query->bindValue(':author_id', $author_id, PDO::PARAM_INT);
        $query->bindValue(':book_description', $book_description, PDO::PARAM_STR);
        $query->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $query->bindValue(':release_year', $release_year, PDO::PARAM_INT);
        $query->execute();

        $_SESSION['message']= "Livre modifié";
        require_once('close.php');
        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Merci de renseigner à minima le titre, l'auteur et l'année de parution.";
    }
}


// Est-ce que l'id existe et n'est pas vide dans l'url
if(!empty($_GET['id'])){
    require_once('config.php');
    // on nettoie l'id envoyé
    $id = strip_tags($_GET['id']);
    $sql = 'SELECT book.*, author.fullname, category.category_name FROM `book` INNER JOIN author ON author.id=book.author_id INNER JOIN category ON category.id=book.category_id WHERE book.`id`= :id;';
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
                <h2>Modifier un livre </h2>
                <form method="post">
                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?= $bookPage['title'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="author">Auteur</label>
                        <select name="selected_author" id="selected_author" value="<?= $bookPage['author_id']?>">
                            <?php 

                            foreach ($authors as $author) {
                                echo '<option value="' . $author['id'] . '"';
                                if($author['id']==$bookPage['author_id']){
                                    echo 'selected';
                                }
                                echo '>'. $author['fullname'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="book_description">Description</label>
                        <input type="text" name="book_description" id="book_description" class="form-control" value="<?= $bookPage['book_description'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="category">Catégorie</label>
                        <select name="selected_category" id="selected_category" value="<?= $bookPage['category_id']?>">
                            <?php 

                            foreach ($categories as $category) {
                                echo '<option value="' . $category['id'] . '"';
                                if($category['id']==$bookPage['category_id']){
                                    echo 'selected';
                                }
                                echo '>'. $category['category_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="release_year">Année de parution</label>
                        <input type="int" name="release_year" id="release_year" class="form-control" value=<?= $bookPage['release_year'] ?>>
                    </div>
                    <input type="hidden" value="<?= $bookPage['id']?>" name="id">
                    <div style="margin-top:2%"><a href="index.php" class="btn btn-primary">Retour</a><button name="modify" type="submit" class="btn btn-success" style="margin-left:5%">Modifier</button></div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>







