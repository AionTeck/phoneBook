<!DOCTYPE html>
<html>
<head>
    <title>PhoneBook</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<?php
if (isset($_GET["id"])) {
    try {
        $connection = new PDO("mysql:host=localhost;port=3306;dbname=phonebook_bd", "root", "");

        $sql = "SELECT * FROM contacts WHERE id = :id";

        $statement = $connection->prepare($sql);

        $statement->bindValue(":id", $_GET["id"]);

        $statement->execute();
        if ($statement->rowCount() > 0) {
            foreach ($statement as $row) {
                $name = $row["name"];
                $phone_number = $row["phone_number"];

                echo "<div>
                    <h3>Контакт:</h3>
                    <p>Имя: $name</p>
                    <p>Номер: $phone_number</p>
                    <p><a href='update.php?id=" . $row["id"] . "'>Изменить</a></p>
                    <p><a href='index.php'>Назад</a></p>
                    <p><a href='delete.php?id=" . $row["id"] . "'>Удалить</a></p>
                </div>";
            }
        } else {
            echo "Пользователь не найден";
        }
    } catch (PDOException $exception) {
        echo "Database error: " . $exception->getMessage();
    }
}
?>

</body>
</html>