<?php

$host = 'mysql';
$username = 'root';
$password = 'ppp';
$database = 'data_master';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $class_id = $_POST["class_id"];

    $name = htmlspecialchars(trim($name));
    $class_id = filter_var($class_id, FILTER_VALIDATE_INT);

    if (empty($name)) {
        die("input name");
    }
    if ($class_id === false) {
        die("input class_id");
    }

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql_max_id = "SELECT MAX(student_id) FROM students";
        $stmt_max_id = $pdo->query($sql_max_id);
        $max_id = $stmt_max_id->fetchColumn();
        $next_student_id = ($max_id === null) ? 1 : $max_id + 1;

        $sql = "INSERT INTO students (student_id, student_name, class_id) VALUES (:student_id, :student_name, :class_id)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':student_id', $next_student_id, PDO::PARAM_INT);
        $stmt->bindParam(':student_name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);

        $stmt->execute();

        echo "regist OK <br>";
        echo "Student ID: " . htmlspecialchars($next_student_id) ;

    } catch(PDOException $e) {
        echo "regist FAILE" . $e->getMessage();
    } finally {
        $pdo = null;
    }

} else {
    echo "request error";
}
?>

