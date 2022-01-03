<?php
include_once "config" . DIRECTORY_SEPARATOR . "Database.php";

$database = new Database();
$db = $database->getConnection();

$rsYonetici = mysqli_query($db, "SELECT cat_id FROM category LIMIT 1");
if (!$rsYonetici) {
    $resultYonetici =$database->createDataBase();
    if ($resultYonetici) {
        echo "1) category table created\n";
    } else
        exit();
}

$rsYonetici = mysqli_query($db, "SELECT join_id FROM joins LIMIT 1");
if (!$rsYonetici) {
    $resultYonetici =$database->createDataBase2();
    if ($resultYonetici) {
        echo "2) join table created\n";
    } else
        exit();
}

echo "END";




