<?php
session_start();
require_once('config.php');

if ($_POST) {
    //var_dump('post');
    if (!empty($_POST['title']) && !empty($_POST['selected_author']) && !empty($_POST['release_year'])) {
        //var_dump('posted');
        // on nettoie les input envoyés
        $title = strip_tags(htmlspecialchars($_POST['title']));
        $selected_author = strip_tags(intval($_POST['selected_author']));
        $book_description = strip_tags(htmlspecialchars($_POST['book_description']));
        $selected_category = strip_tags(intval($_POST['selected_category']));
        $release_year = strip_tags(intval($_POST['release_year']));

        //var_dump($title, $selected_author, $book_description , $selected_category, $release_year );
        // $selected_author = intval($selected_author);
        // $selected_category = intval($selected_category);
        // $release_year = intval($release_year);
        //var_dump($title, $selected_author, $book_description , $selected_category, $release_year );die;


        $sql = 'INSERT INTO book (`title`, `author_id`, `book_description`, `category_id`, `release_year`) VALUES (:title, :selected_author, :book_description, :selected_category, :release_year);';
        $query = $db->prepare($sql);
        // $query->bindValue(':title', $title, PDO::PARAM_STR);
        // $query->bindValue(':selected_author', $selected_author, PDO::PARAM_INT);
        // $query->bindValue(':book_description', $book_description, PDO::PARAM_STR);
        // $query->bindValue(':category_id', $selected_category, PDO::PARAM_INT);
        // $query->bindValue(':release_year', $release_year, PDO::PARAM_INT);
        $query->bindParam(":title", $title, PDO::PARAM_STR);
        $query->bindParam(":selected_author", $selected_author, PDO::PARAM_INT);
        $query->bindParam(":book_description", $book_description, PDO::PARAM_STR);
        $query->bindParam(":selected_category", $selected_category, PDO::PARAM_INT);
        $query->bindParam(":release_year", $release_year, PDO::PARAM_INT);
        $query->execute();


        $_SESSION['message'] = "Livre ajouté";
        require_once('close.php');
        header('Location: index.php');
    } else {
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
        if (!empty($_SESSION['erreur'])) {
            echo '<div class="alert alert-danger" role="alert">
                    ' . $_SESSION['erreur'] . '
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
                    <div>
                        <div>
                            <label for="selected_author">Auteur</label>
                            <select name="selected_author" id="selected_author">
                                <?php foreach ($authors as $author) {
                                    echo '<option value="' . $author['id'] . '">' . $author['fullname'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="book_description">Description</label>
                        <input type="text" name="book_description" id="book_description" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="category">Catégorie</label>
                        <select name="selected_category" id="selected_category">
                            <?php foreach ($categories as $category) {
                                echo '<option value="' . $category['id'] . '">' . $category['category_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="release_year">Année de parution</label>
                        <input type="int" name="release_year" id="release_year" class="form-control">
                    </div>
                    <div style="margin-top:2%"><a href="index.php" class="btn btn-primary">Retour</a><button type="submit" class="btn btn-success" style="margin-left:5%">Ajouter</button></div>
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