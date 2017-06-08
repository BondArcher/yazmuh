<?php
    include "db.php";
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = $db->prepare('UPDATE expences SET confirmed =1 WHERE expence_id=?');
        $query->execute(array($id));
    }

?>