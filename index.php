<!DOCTYPE html>
<html>
<head >
    <title>PhoneBook</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<h3>Контакты:</h3>
<?php
try {
    $connection = new PDO("mysql:host=localhost;port=3306;dbname=phonebook_bd", "root", "");

    $sql = "SELECT id, name FROM contacts;";

    $result = $connection->query($sql);

    echo "<table><tr><th></th></tr>";
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td><a href='show.php?id=" . $row["id"] . "'> " . $row["name"] . " </a> </td>";
        echo "</tr>";
    }
    echo "</table>";
} catch (PDOException $exception) {
    echo "Database error: " . $exception->getMessage();
}
?>
<a href='create.php'>Добавить</a>
</body>
</html>
