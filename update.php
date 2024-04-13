<?php
try {
    $connection = new PDO("mysql:host=localhost;port=3306;dbname=phonebook_bd", "root", "");
} catch (PDOException $exception) {
    die("Database error: " . $exception->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>PhoneBook</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<?php

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM contacts WHERE id = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(":id", $id);
    $statement->execute();

    if ($statement->rowCount() > 0) {
        foreach ($statement as $row) {
            $name = $row["name"];
            $phone_number = $row["phone_number"];
        }
        echo "<h3>Обновление контакта</h3>
                <form method='post'>
                    <input type='hidden' name='id' value='$id' />
                    <p>Имя:
                    <input type='text' name='name' value='$name' /></p>
                    <p>Номер:
                    <input type='text' name='phone_number' value='$phone_number' /></p>
                    <input type='submit' value='Сохранить' />
                </form>";
    } else {
        echo "Пользователь не найден";
    }
} elseif (isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["phone_number"])) {
    try {
        $sql = "UPDATE contacts SET name = :name, phone_number = :phone_number WHERE id = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(":id", $_POST["id"]);
        $statement->bindValue(":name", $_POST["name"]);
        $statement->bindValue(":phone_number", $_POST["phone_number"]);

        $statement->execute();
        header("Location: show.php?id=" . $_GET["id"]);
    } catch (PDOException $exception) {
        if ($exception->getCode() === '23000') {
            echo "Такой номер уже записан";
        } elseif ($exception->getCode() === 'HY000' || '22003') {
            echo "Введите корректный номер";
        } else echo "Database error: " . $exception->getMessage();
    }
}
?>
</body>
</html>