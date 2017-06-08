<?php
$dsn = 'mysql:host=localhost;dbname=DATABASE_NAME';
$user = 'USERNAME';
$dbpassword = 'PASSWORD';

try {
    $db = new PDO($dsn, $user, $dbpassword);
    $db->exec('SET NAMES `UTF-8`');
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>