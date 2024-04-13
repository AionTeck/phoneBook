<!DOCTYPE html>
<html>
<head>
    <title>PhoneBook</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<h3>Введите данные:</h3>
<?php
if (isset($_POST["name"]) && isset($_POST["phone_number"])) {

    try {
        $connection = new PDO("mysql:host=localhost;port=3306;dbname=phonebook_bd", "root", "");

        $sql = "INSERT INTO contacts (name, phone_number) VALUES (:name, :phone_number)";

        $statement = $connection->prepare($sql);

        $statement->bindValue(":name", $_POST["name"]);
        $statement->bindValue(":phone_number", $_POST["phone_number"]);

        $affectedRowsNumber = $statement->execute();

        if ($affectedRowsNumber > 0) {
            header("Location: index.php");
        }
    } catch (PDOException $exception) {
        if ($exception->getCode() === '23000')
        {
            echo "Такой номер уже записан";
        }
        elseif ($exception->getCode() === 'HY000'||'22003') {
            echo "Введите корректный номер";
        }
        else echo "Database error: " . $exception->getMessage();
    }
}
?>
<form method="post">
    <p>Имя контакта:
        <input type="text" name="name"/></p>
    <p>Номер:
        <input type="text" name="phone_number"/></p>
    <input type="submit" value="Добавить">
</body>
</html>