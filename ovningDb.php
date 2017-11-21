<?php
$username = "root";
$password = "root";
$db = "WIEG16";
$server = "localhost";

if (isset($_POST['submit'])) {
    try {
        $conn = new PDO("mysql:host=$server;dbname=$db", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stm = $conn->prepare("INSERT INTO curl (name, email, age, occupation) VALUES (:name, :email, :age, :occupation)");
        $name = $_POST['name'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $occupation = $_POST['occupation'];

        $stm->bindParam(':name', $name);
        $stm->bindParam(':email', $email);
        $stm->bindParam(':age', $age);
        $stm->bindParam(':occupation', $occupation);

        $stm->execute();
        echo "Person added";
    }
    catch (PDOException $e){
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}