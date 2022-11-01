<?php
//on démarre une session ici
session_start();


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
    $sql = 'DELETE FROM `book` WHERE `id`= :id;';
    // On prépare la requête 
    $query = $db->prepare($sql);
    // On accroche les parametres 
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    //exec requete
    $query->execute();
    $_SESSION['message'] = "Livre supprimé";
    header('Location: index.php');

}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
    exit;
}





?>

