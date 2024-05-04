<?php
    $config = require('config.php');
    // Create a new PDO instance
    $config = $config['database'];
    $pdo = new PDO(
        $config['connection'].';port='.$config['port'].';dbname='.$config['dbname'],
        $config['username'],
        $config['password'],
        $config['options']
      );
    //import books_dataset.csv
    $file = fopen("books_dataset.csv", "r");
    $books = array();
    $i = 0;
    while (!feof($file)) {
        $line = fgetcsv($file);
        $books[$i] = $line;
        $author_name = $books[$i][4];
        $category_name = $books[$i][6];
        $book_title = $books[$i][3];
        $book_image = $books[$i][2];
        $book_isbn = $books[$i][0];
        //insert authors if name not exists
        // Check if author exists
        $stmt = $pdo->prepare("SELECT * FROM authors WHERE name = ?");
        $stmt->bindParam(1, $author_name);  
        $stmt->execute();
        $result = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            // Author exists
            $author = $result;
            $author_id = $author['id'];
        } else {
            // Author does not exist, insert new author
            $stmt = $pdo->prepare("INSERT INTO authors (name) VALUES (?)");
            $stmt->bindParam(1, $author_name);
            $stmt->execute();
            $author_id = $pdo->lastInsertId();
        }
        $stmt->closeCursor();
        //insert categories if name not exists
        // Check if category exists
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE name = ?");
        $stmt->bindParam(1, $category_name);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            // Category exists
            $category = $result;
            $category_id = $category['id'];
        } else {
            // Category does not exist, insert new category
            $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt->bindParam(1, $category_name);
            $stmt->execute();
            $category_id = $pdo->lastInsertId();
        }
        $stmt->closeCursor();
        //price random between 10 and 100
        $price = rand(10, 100);
        // prepared statement with question mark placeholders (marqueurs de positionnement)
        $req = "INSERT INTO books (isbn, title, image, price , author_id, category_id ) VALUES (?, ?, ?,?, ?, ?)";
        $statement = $pdo->prepare($req);
        $statement->bindParam(1, $book_isbn, PDO::PARAM_STR);
        $statement->bindParam(2, $book_title, PDO::PARAM_STR);
        $statement->bindParam(3, $book_image, PDO::PARAM_STR);
        $statement->bindParam(4, $price, PDO::PARAM_INT);
        $statement->bindParam(5, $author_id, PDO::PARAM_INT);
        $statement->bindParam(6, $category_id, PDO::PARAM_INT);
        $statement->execute();
        $statement->closeCursor();
        $i++;
    }
    fclose($file);
    var_export("Data imported successfully!");
?>


    