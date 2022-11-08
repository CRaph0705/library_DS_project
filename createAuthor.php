<?php
require_once('config.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des auteurs</title>
</head>

<body>
    <div>
    </div>
</body>

</html>


<?php






session_start();
require_once('config.php');

if ($_POST) {
    //var_dump('post');
    if (!empty($_POST['firstname']) && !empty($_POST['lastname'])) {
        //var_dump('posted');
        // on nettoie les input envoyés
        $firstname = strip_tags(htmlspecialchars($_POST['firstname']));
        $lastname = strip_tags(htmlspecialchars($_POST['lastname']));
        $fullname = $firstname ." ". $lastname;
        $sql = "INSERT INTO author (`fullname`) VALUES (:fullname);";
        $query = $db->prepare($sql);

        $query->bindValue(":fullname", $fullname, PDO::PARAM_STR);
        $query->execute();


        $_SESSION['message'] = "Auteur ajouté";
        require_once('close.php');
        header('Location: index.php');
    } else {
        $_SESSION['erreur'] = "Merci de renseigner le nom et le prénom de l'auteur.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un auteur</title>
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
                <h2>Ajouter un auteur </h2>
                <form method="post">
                    <div class="form-group">
                        <label for="firstname">Prénom</label>
                        <input type="text" name="firstname" id="firstname" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Nom de famille</label>
                        <input type="text" name="lastname" id="lastname" class="form-control">
                    </div>
                    <div style="margin-top:2%"><a href="indexAuthors.php" class="btn btn-primary">Retour</a><button type="submit" class="btn btn-success" style="margin-left:5%">Ajouter</button></div>
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