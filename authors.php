<?php
require_once('config.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <form action="" method="post">
            <div>
                <label for=""></label>
                <input type="text">
            </div>
            <div>
                <label for=""></label>
                <select name="selected_author" id="selected_author">
                    <?php foreach($authors as $author){ ?>
                    <option value="<?= $author['id']?>"><?= $author['fullname'];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </form>
    </div>
</body>
</html>


<?php



?>
