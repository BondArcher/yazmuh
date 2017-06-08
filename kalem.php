<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <script>
        function degistir(id) {
            var xhttp = new XMLHttpRequest();
            var e = document.getElementById("option"+id);
            var strUser = e.options[e.selectedIndex].value;
            xhttp.open("GET", "degistir.php?id="+id+"&value="+strUser, true);
            xhttp.send();
            location.reload();
            location.reload();

        }
    </script>

    <?php
    include "db.php";
    session_start();
    if(isset($_SESSION['id'])){
        $id=$_SESSION['id'];
        $row= $db->query("SELECT first_name,status,department   FROM employee,departments WHERE id ='{$id}'")->fetch(PDO::FETCH_ASSOC);
        $name=$row['first_name'];
        $status=$row['status'];
        $dep=$row['department'];
        if ($dep!=4){
            header("Location: dashboard.php");
        }
    }else{
        header("Location: index.php");
    }
    ?>

    <!-- start: Meta -->
    <meta charset="utf-8">
    <title>Gider Yönetim Sistemi</title>
    <!-- end: Meta -->

    <!-- start: Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- end: Mobile Specific -->

    <!-- start: CSS -->
    <link id="bootstrap-style" href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link id="base-style" href="css/style.css" rel="stylesheet">
    <link id="base-style-responsive" href="css/style-responsive.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
    <!-- end: CSS -->


    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <link id="ie-style" href="css/ie.css" rel="stylesheet">
    <![endif]-->

    <!--[if IE 9]>
    <link id="ie9style" href="css/ie9.css" rel="stylesheet">
    <![endif]-->

    <!-- start: Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- end: Favicon -->



</head>

<body>
<!-- start: Header -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="dashboard.php"><span>YILDIZ</span></a>


            <!-- start: Header Menu -->
            <div class="nav-no-collapse header-nav">
                <ul class="nav pull-right">
                    <li class="dropdown hidden-phone">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="icon-bell"></i>
                        </a>

                    </li>
                    <!-- start: Notifications Dropdown -->
                    <li class="dropdown hidden-phone">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="icon-calendar"></i>
                        </a>

                    </li>
                    <!-- end: Notifications Dropdown -->
                    <!-- start: Message Dropdown -->
                    <li class="dropdown hidden-phone">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="icon-envelope"></i>
                        </a>

                    </li>

                    <!-- start: User Dropdown -->
                    <li class="dropdown">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="halflings-icon white user"></i> <?php
                            echo $name;
                            ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-menu-title">
                                <span>Hesap</span>
                            </li>
                            <li><a href="logout.php"><i class="halflings-icon off"></i> Çıkış</a></li>
                        </ul>
                    </li>
                    <!-- end: User Dropdown -->
                </ul>
            </div>
            <!-- end: Header Menu -->

        </div>
    </div>
</div>
<!-- start: Header -->

<div class="container-fluid-full">
    <div class="row-fluid">

        <!-- start: Main Menu -->
        <div id="sidebar-left" class="span2">
            <div class="nav-collapse sidebar-nav">
                <ul class="nav nav-tabs nav-stacked main-menu">
                    <li><a href="dashboard.php"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Gider Ekle</span></a></li>
                    <li><a href="messages.php"><i class="icon-envelope"></i><span class="hidden-tablet"> Mesajlar</span></a></li>
                    <?php
                    if($status=="Manager"){
                        echo'<li><a href="gideronay.php"><i class="icon-edit"></i><span class="hidden-tablet"> Gider Onayla</span></a></li>';}
                    if($dep==4){
                        echo'<li><a href="kalem.php"><i class="icon-eye-open"></i><span class="hidden-tablet"> Dogru Kaleme Aktar</span></a></li>';
                    }
                    if($dep==NULL){
                        echo'<li><a href="ustlimit.php"><i class="icon-align-justify"></i><span class="hidden-tablet"> Ust Limit Belirle</span></a></li>';
                    }
                        ?>

                    <li><a href="chart.php"><i class="icon-list-alt"></i><span class="hidden-tablet"> Grafikler</span></a></li>
            </div>
        </div>
        <!-- end: Main Menu -->

        <noscript>
            <div class="alert alert-block span10">
                <h4 class="alert-heading">Warning!</h4>
                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
            </div>
        </noscript>

        <!-- start: Content -->
        <div id="content" class="span10">


            <ul class="breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="dashboard.php">Gider Ekle</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <i class="icon-edit"></i>
                    <a href="">Dogru Kaleme Aktar</a>
                </li>
            </ul>

            <?php
            echo "<div class=\"table-responsive\">          
                                    <table class=\"table\">
                                        <thead>
                                        <tr>
                                        <th>Ad</th>
                                        <th>Soyad</th>
                                        <th>Ucret</th>
                                        <th>Aciklama</th>
                                        <th>Kalem</th>
                                        <th>Tarih</th>
                                        <th>Değiştir</th>
                                        </tr>
                                        </thead>";

            foreach($db->query('SELECT * FROM expences') as $row) {
                $tmp= $db->query("SELECT first_name,last_name FROM employee WHERE id ='{$row['employee_id']}'")->fetch(PDO::FETCH_ASSOC);

                echo "<tbody><tr>
                                        <th>".$tmp["first_name"]."</th>
                                        <th>".$tmp["last_name"]."</th>
                                        <th>".$row['expence_cost']."</th>
                                        <th>".$row['expence_statement']."</th>
                                        <th><select id ='option".$row['expence_id']."'>";
                                        $tmp2=$db->query("SELECT component_type,id FROM components WHERE id='{$row['component_id']}'")->fetch(PDO::FETCH_ASSOC);
                                        echo "<option value='".$tmp2['id']."'>".$tmp2['component_type']."</option>";
                                        foreach($db->query("SELECT component_type,id FROM components WHERE id!='{$row['component_id']}'") as $row2) {
                                            echo "<option value='".$row2['id']."'>".$row2['component_type']."</option>";
                                        }
                echo                    "</select></th>
                                        <th>".$row['expence_date']."</th>
                                        <th><button type='button' onclick='degistir(".$row['expence_id'].")'>Onayla</button></th>
                                        </tr></tbody>";
            }

            echo "</table></div>";

            ?>









            <!-- start: JavaScript-->

            <script src="js/jquery-1.9.1.min.js"></script>
            <script src="js/jquery-migrate-1.0.0.min.js"></script>

            <script src="js/jquery-ui-1.10.0.custom.min.js"></script>

            <script src="js/jquery.ui.touch-punch.js"></script>

            <script src="js/modernizr.js"></script>

            <script src="js/bootstrap.min.js"></script>

            <script src="js/jquery.cookie.js"></script>

            <script src='js/fullcalendar.min.js'></script>

            <script src='js/jquery.dataTables.min.js'></script>

            <script src="js/excanvas.js"></script>
            <script src="js/jquery.flot.js"></script>
            <script src="js/jquery.flot.pie.js"></script>
            <script src="js/jquery.flot.stack.js"></script>
            <script src="js/jquery.flot.resize.min.js"></script>

            <script src="js/jquery.chosen.min.js"></script>

            <script src="js/jquery.uniform.min.js"></script>

            <script src="js/jquery.cleditor.min.js"></script>

            <script src="js/jquery.noty.js"></script>

            <script src="js/jquery.elfinder.min.js"></script>

            <script src="js/jquery.raty.min.js"></script>

            <script src="js/jquery.iphone.toggle.js"></script>

            <script src="js/jquery.uploadify-3.1.min.js"></script>

            <script src="js/jquery.gritter.min.js"></script>

            <script src="js/jquery.imagesloaded.js"></script>

            <script src="js/jquery.masonry.min.js"></script>

            <script src="js/jquery.knob.modified.js"></script>

            <script src="js/jquery.sparkline.min.js"></script>

            <script src="js/counter.js"></script>

            <script src="js/retina.js"></script>

            <script src="js/custom.js"></script>
            <!-- end: JavaScript-->

</body>
</html>