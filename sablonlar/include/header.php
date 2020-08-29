<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $veri["sayfaBasligi"]; ?></title>
	
	<link rel="stylesheet" type="text/css" href="/stil.css"/>
	
	<?php 
	if(isset($veri["formSecenek"]))
	{
		if($veri["formSecenek"] == "makaleEkle" || $veri["formSecenek"] == "makaleGuncelle" || $veri["formSecenek"] == "menuEkle" || $veri["formSecenek"] == "menuGuncelle" || $veri["formSecenek"] == "footerGuncelle" || $veri["formSecenek"] == "mailGonder")
			echo "<script type='text/javascript' src='/kutuphaneler/tinymce/tinymce.min.js'></script>";
	}	
	try{
	Stil::goster();	
	}catch(PDOException $h) {echo $h->getMessage();}
	
	
	?>	
	
	
</head>
	
<body>
	
	
	<header>
		<?php Header::goster(); ?>			
	</header>
	
	
	
	<div id="menu">		
		<ul class='menu'>
			<li><a href="index.php">Ana Sayfa</a></li>
			<?php Menu::goster(0); ?>
		</ul>		
	</div>
	
	
	<div id="satir">
		
		
		<div id="solSutun">
			<div id="cocukSolSutun">
			<?php	// SOL MENÜLERİN DAHİL EDİLMESİ
			if(isset($_SESSION["oturum"]) && $_SESSION["oturum"] == "admin" && (strpos($_SERVER['SCRIPT_NAME'], "admin") || strpos($_SERVER['SCRIPT_NAME'], "kullanici"))) 
				include SABLONLAR."/include/adminSecenekler.php";
			else if(isset($_SESSION["oturum"]) && $_SESSION["oturum"] == "kullanici" && strpos($_SERVER['SCRIPT_NAME'], "kullanici"))
				include SABLONLAR."/include/kullaniciSecenekler.php";	
			else if(strpos($_SERVER['SCRIPT_NAME'], "index") || empty($_SESSION["oturum"]))
				include SABLONLAR."/include/indexSecenekler.php";
			?>	
			</div>
		</div>
		
		<main id="sagSutun">		

			<?php echo (isset($veri["baslik"]) ? "<h1 id='baslik'>".$veri["baslik"]."</h1><hr>" : "") ?>
	