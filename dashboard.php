<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
    include 'db.php';
    session_start();
    if(isset($_SESSION['id'])){
        $id=$_SESSION['id'];
        $row= $db->query("SELECT first_name,status,department   FROM employee,departments WHERE id ='{$id}'")->fetch(PDO::FETCH_ASSOC);
        $name=$row['first_name'];
        $status=$row['status'];
        $dep=$row['department'];
    }else{
        header("Location: index.php");
    }

    if (isset($_POST['ucret']) && isset($_POST['kalem']) && isset($_POST['aciklama']) && isset($_POST['tarih'])) {
        $ucret = $_POST['ucret'];
        $kalem = $_POST['kalem'];
        $aciklama = $_POST['aciklama'];
        $tarih = $_POST['tarih'];
        $tmparray = explode("/", $tarih);
        $tarih = $tmparray[2] . "-" . $tmparray[0] . "-" . $tmparray[1];

        $tmp= $db->query("SELECT * FROM components WHERE id ='{$kalem}'")->fetch(PDO::FETCH_ASSOC);
        if($tmp['limit_full']){
            echo "<script>alert('Bu kalemde girdi yapamazsınız');</script>";
        }
        else if($tmp['current_expence']+$ucret>$tmp['budget']){
            if($tmp['current_expence']+$ucret>$tmp['budget']+$tmp['treshold']){
                $ucret=$tmp['budget']+$tmp['treshold']-$tmp['current_expence'];
                echo "<script>alert('Bu kalemde esigi gectiginiz icin sadece ".$ucret." kadar odeme alabilirsiniz.');</script>";
                $query = $db->prepare('UPDATE components SET limit_full=1,current_expence=? WHERE id= ?');
                $query->execute(array($tmp['current_expence']+$ucret,$kalem));
                $query = $db->prepare('INSERT INTO messages (message) VALUES(?)');
                $query->execute(array($tmp['component_type']." kalemine artık girdi yapılmayacaktır."));

            } else{
                $query = $db->prepare('UPDATE components SET limit_full=1,current_expence=? WHERE id= ?');
                $query->execute(array($tmp['current_expence']+$ucret,$kalem));
                $query = $db->prepare('INSERT INTO messages (message) VALUES(?)');
                $query->execute(array($tmp['component_type']." kalemine artık girdi yapılmayacaktır."));
            }
            $query = $db->prepare('INSERT INTO expences (expence_cost,expence_statement,employee_id,component_id, expence_date,collected,confirmed) VALUES(?, ?,?,?,?,?,?)');
            $query->execute(array($ucret, $aciklama, $id, $kalem, $tarih, 0, 0));

            echo "<script>alert('Gider kayıt edildi.')</script>";
        }else{
            $query = $db->prepare('INSERT INTO expences (expence_cost,expence_statement,employee_id,component_id, expence_date,collected,confirmed) VALUES(?, ?,?,?,?,?,?)');
            $query->execute(array($ucret, $aciklama, $id, $kalem, $tarih, 0, 0));
            $query = $db->prepare('UPDATE components SET current_expence=? WHERE id= ?');
            $query->execute(array($tmp['current_expence']+$ucret,$kalem));

            echo "<script>alert('Gider kayıt edildi.')</script>";
        }


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
					<a href="dashboard.php">GiderEkle</a>
				</li>
			</ul>




                <?php

                    echo "  <div class=\"panel panel-primary\">
                               <div class=\"panel-heading\">Gider Ekleme Paneli</div>
                                <div class=\"panel-body\">
                            <form action='' method='post'>
                              <div class=\"control-group\">
								<label class=\"control-label\" for=\"appendedPrependedInput\">Ücret</label>
								<div class=\"controls\">
								  <div class=\"input-prepend input-append\">
									<span class=\"add-on\">$</span><input id=\"appendedPrependedInput\" name='ucret' required size=\"16\" type=\"text\"><span class=\"add-on\">.00</span>
								  </div>
								</div>
							  </div>
							  
							  <div class=\"control-group\">
								<label class=\"control-label\" for=\"selectError3\">Kalem</label>
								<div class=\"controls\">
								  <select id=\"selectError3\" name='kalem'>"; ?>
                <?php
                foreach($db->query('SELECT id,component_type FROM components') as $row) {
                    echo "<option value='".$row['id']."'>".$row['component_type']."</option>" ;
                }

						echo"	  </select>
								</div>
							  </div>
							  
							  <div class=\"control-group\">
								<label class=\"control-label\" for=\"appendedPrependedInput\">Aciklama</label>
								<div class=\"controls\">
								  <div class=\"input-prepend input-append\">
								    <input id=\"appendedPrependedInput\"  required name='aciklama' size=\"48\" type=\"text\">
								  </div>
								</div>
							  </div>
							  
							  <div class=\"control-group\">
							  <label class=\"control-label\" for=\"date01\">Gider Tarihi</label>
							  <div class=\"controls\">
								<input type=\"text\" name='tarih' class=\"input-xlarge datepicker\" id=\"date01\" value=\"05/16/17\">
							  </div>
							</div>
							  
							  <input type=\"submit\" value=\"Formu gönder\" />
							  </form>
					    </div>
							  
				    ";


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
