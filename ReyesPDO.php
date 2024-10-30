<?php
$dsn = "mysql:host=localhost;dbname=library";
$username = "root";
$password = ""; // Set your MySQL root password here

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to the database successfully!<br>";

    // INSERT a new book
    function insertBook($pdo, $title, $author, $published_year, $genre) {
        $sql = "INSERT INTO books (title, author, published_year, genre) VALUES (:title, :author, :published_year, :genre)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['title' => $title, 'author' => $author, 'published_year' => $published_year, 'genre' => $genre]);
        echo "New book inserted successfully: '$title' by $author<br>";
    }

    // SELECT and display all books
    function selectBooks($pdo) {
        $sql = "SELECT * FROM books";
        $stmt = $pdo->query($sql);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>";
        print_r($books);
        echo "</pre>";
    }

    // UPDATE a book's details
    function updateBook($pdo, $id, $title, $author, $published_year, $genre) {
        $sql = "UPDATE books SET title = :title, author = :author, published_year = :published_year, genre = :genre WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'title' => $title, 'author' => $author, 'published_year' => $published_year, 'genre' => $genre]);
        echo "Book with ID $id updated successfully!<br>";
    }

    // DELETE a book
    function deleteBook($pdo, $id) {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        echo "Book with ID $id deleted successfully!<br>";
    }

    // Example usage
    insertBook($pdo, "To Kill a Mockingbird", "Harper Lee", 1960, "Fiction");
    selectBooks($pdo);

    // Updating the book's details
    // Assuming the ID of "To Kill a Mockingbird" is 1
    updateBook($pdo, 1, "To Kill a Mockingbird - Updated", "Harper Lee", 1960, "Classic Fiction");

    // Display books after update
    selectBooks($pdo);

    // Deleting the book
    deleteBook($pdo, 1);

    // Display books after deletion
    selectBooks($pdo);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
