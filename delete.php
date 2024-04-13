<?php
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"]))
{
    try {
        $connection = new PDO("mysql:host=localhost;port=3306;dbname=phonebook_bd", "root", "");

        $id = $_GET["id"];
        $sql = "DELETE FROM contacts WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();

        header("Location: index.php");
    }
    catch (PDOException $exception) {
        echo "Database error: " . $exception->getMessage();
    }
}
?>