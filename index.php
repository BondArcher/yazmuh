<!DOCTYPE HTML>
<html lang="tr-TR">
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="css/css.css"/>
    <!-- CSS -->


</head>

<body class="thempOne">

<?php
include 'db.php';

if(isset($_SESSION['id'])){
    header('Location:  dashboard.php');
}

if(isset($_POST['email']) && isset($_POST['password'])) { // form gönderilmiş mi
    $email = $_POST['email'];
    $password = $_POST['password'];

    $row = $db->query("SELECT password,id FROM employee WHERE mail ='{$email}'")->fetch(PDO::FETCH_ASSOC);

    if($row["password"] == $password) { // bilgiler doğru mu
        session_start();
        $_SESSION['id'] = $row["id"];
        header('Location: dashboard.php');
    } else {
        echo '<script>alert("Yanlis sifre")</script>';
    }
}

?>

<section class="container-fluid">


    <article class="thisPanel col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <div class="panelContent col-xs-12 col-sm-4 col-md-3">
            <h2 style="text-align: center" href>Giris Paneli</h2>
            <form action="" method="post">
                <div class="formGr">
                    <input id="email" type="email" name ='email'  placeholder="Mail" class="textCt"/>
                </div>
                <div class="formGr">
                    <input id="password" type="password" name ='password' required placeholder="Şifre" class="textCt"/>
                </div>
                <div class="formGr btnX">
                    <button type="submit" class="login">Giriş Yap</button>
                </div>
                <div class="col-xs-12 p0 copyright">
                    <a href="">Gider Yönetim Sistemi</a>
                </div>
            </form>
        </div>

    </article>



</section>




















<!-- JS -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/js.js"></script>
<!-- JS -->
</body>
</html>