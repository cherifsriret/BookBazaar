<?php

//connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bazaar_books";

$conn = new mysqli($servername, $username, $password, $dbname);



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
        $stmt = $conn->prepare("SELECT * FROM authors WHERE name = ?");
        $stmt->bind_param("s", $author_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Author exists
            $author = $result->fetch_assoc();
            $author_id = $author['id'];
        } else {
            // Author does not exist, insert new author
            $stmt = $conn->prepare("INSERT INTO authors (name) VALUES (?)");
            $stmt->bind_param("s", $author_name);
            $stmt->execute();
            $author_id = $stmt->insert_id;
        }

        $stmt->close();

        //insert categories if name not exists
        // Check if category exists
        $stmt = $conn->prepare("SELECT * FROM categories WHERE name = ?");
        $stmt->bind_param("s", $category_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Category exists
            $category = $result->fetch_assoc();
            $category_id = $category['id'];
        } else {
            // Category does not exist, insert new category
            $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt->bind_param("s", $category_name);
            $stmt->execute();
            $category_id = $stmt->insert_id;
        }

        $stmt->close();

        //price random between 10 and 100
        $price = rand(10, 100);


          // prepared statement with question mark placeholders (marqueurs de positionnement)
        $req = "INSERT INTO books (isbn, title, image, price , author_id, category_id ) VALUES (?, ?, ?,?, ?, ?)";

        $statement = $conn->prepare($req);
        $statement->bind_param("ssssss", $book_isbn, $book_title, $book_image, $price, $author_id, $category_id);
        $statement->execute();
        $statement->close();
        
    }
    fclose($file);

    //close connection
    $conn->close();

    var_export("Data imported successfully!")
?>

    