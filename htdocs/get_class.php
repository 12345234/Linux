<?php
$host = 'mysql';

$username = 'root';
$password = 'ppp';
$database = 'data_master';

try{
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $class_id = 0;
    if(isset($_GET['class_id'])) {
        $class_id = $_GET['class_id'];
    }
    $stmt = $pdo->query("SELECT * FROM classes where class_id = $class_id");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach (array_keys($results[0]) as $v) {
       echo $v . " ";
    }
    echo "<br>";
    if (count($results) > 0) {
        for ($i=0; $i < count($results); $i++){
            foreach($results[$i] as $k => $v){
                echo $v . " ";
            }
            echo "<br>";
        }
    } else {
        echo "no data";
    }
    exit();

} catch (PDOException $e) {
        echo "データベースエラー: " . $e->getMessage();
}
?>

