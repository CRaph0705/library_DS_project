<?php
    $user = "root";
    $pass = "";
    $db = new PDO('mysql:host=localhost;dbname=library_project', $user, $pass);

    $booksQuery = $db->query("SELECT book.id, book.title, book.book_description, book.author_id, book.category_id, book.release_year, category.category_name, author.fullname FROM book INNER JOIN author ON author.id=book.author_id INNER JOIN category ON category.id=book.category_id");
    //$authorsQuery = $pdo->query("SELECT * FROM authors");
    $books = $booksQuery->fetchAll(PDO::FETCH_ASSOC);

    $authorsQuery = $db->query("SELECT * FROM author");
    $authors = $authorsQuery->fetchAll(PDO::FETCH_ASSOC);

    $categoryQuery = $db->query("SELECT * FROM category");
    $categories = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);


    //$author_authorId = $db->query("SELECT `lastname` FROM `author` JOIN `book` ON `author.id` = `book.author_id`");
    
    //$book_category = $db->query("SELECT name FROM category WHERE `category.id` = `book.category_id`");

?>