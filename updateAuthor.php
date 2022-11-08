<?php
session_start();





if (isset($_POST['modify'])) {        //var_dump($_POST); die;

    if ((!empty($_POST['firstname']) && !empty($_POST['lastname']))  && !empty($_POST['id'])) {
        require_once('config.php');
        require_once('close.php');
        $id = strip_tags(intval($_POST['id']));
        $firstname = strip_tags(htmlspecialchars($_POST['firstname']));
        $lastname = strip_tags(htmlspecialchars($_POST['lastname']));
        $fullname = $firstname . " " . $lastname;

        $sql = "UPDATE `author` SET `fullname`=:fullname,  WHERE `id`=:id;";
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(":fullname", $fullname, PDO::PARAM_STR);
        $query->execute();

        $_SESSION['message'] = "Auteur modifié";
        require_once('close.php');
        header('Location: indexAuthors.php');
    } else {
        $_SESSION['erreur'] = "Hmmm... Nope, essaye encore.";
    }
}


// Est-ce que l'id existe et n'est pas vide dans l'url
if (!empty($_GET['id'])) {
    require_once('config.php');

    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `author` WHERE author.`id`= :id;';

    $query = $db->prepare($sql);

    $query->bindValue(':id', $id, PDO::PARAM_INT);

    $query->execute();

    $authorPage = $query->fetch();

    if (!$authorPage) {
        $_SESSION['erreur'] = "URL invalide";
        header('Location: indexAuthors.php');
        exit;
    }
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('Location: indexAuthors.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un auteur</title>
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
                <h2>Modifier l'auteur : <?= $authorPage['fullname'] ?> </h2>
                <form method="post">
                    <div class="form-group">
                        <label for="firstname">Prénom de l'auteur</label>
                        <input type="text" name="firstname" id="firstname" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Nom de l'auteur</label>
                        <input type="text" name="lastname" id="lastname" class="form-control" value="">
                    </div>
        </div>
        <input type="hidden" value="<?= $authorPage['id'] ?>" name="id">
        <div style="margin-top:2%"><a href="indexAuthors.php" class="btn btn-primary">Retour</a><button name="modify" type="submit" class="btn btn-success" style="margin-left:5%">Modifier</button></div>
        </form>
        </section>
        </div>
    </main>
</body>

</html>