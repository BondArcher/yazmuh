<?php
    include "db.php";
    if(isset($_GET['id'])&& isset($_GET['value'])) {
        $id = $_GET['id'];
        $value = $_GET['value'];
        $query = $db->prepare('UPDATE expences SET component_id = ? WHERE expence_id= ?');
        $query->execute(array($value,$id));
    }

?>