<?php

try
{
	include SABLONLAR."/include/header.php"; 

?>	
	<form action="admin.php?secenek=mailGonder<?php if(isset($veri["alici"])) echo "&alici=" . $veri["alici"]; ?>" method="post" id="makaleFormu">
		
		<div id="girdiBaslik">Alıcı:</div> <br>
		<input type="text" name="alici" required value="<?php 
		if(isset($veri["kullanicilar"])) {
			if($veri["alici"] == "tumKullanicilar") {
				foreach($veri["kullanicilar"] as $kullanici) 
					if (filter_var($kullanici->email, FILTER_VALIDATE_EMAIL)) 
						echo $kullanici->email . ", ";/**/
				
			}
			else{
				if (filter_var($veri["kullanicilar"]->email, FILTER_VALIDATE_EMAIL)) 
					echo $veri["kullanicilar"]->email;
			}
		}
		?>">
		<br><br>

		<div id="girdiBaslik">Konu:</div> <br>
		<input type="text" name="konu" required><br><br>

		<div id="girdiBaslik">Mail İçeriği:</div> <br>
		<textarea name="mailIcerik" id="mailIcerik" cols="80" rows="30" placeholder="E-Mail olarak gönderilecek mesaj.."></textarea><br>

		<input type="submit" name="gonder" value="Gönder">
		<input type="submit" formnovalidate name="iptal" value="İptal">

	</form>


	<script type="text/javascript">
		tinyMCE.init({			
			selector: '#mailIcerik',
			language: 'tr',
			plugins: 'image, link, lists advlist, table',
			toolbar: 'undo redo | link image | code | numlist bullist',
		});	
	</script>
	
<?php
			
	include SABLONLAR."/include/footer.php";
}
catch(PDOException $hata)
{
	"HATA: ".$hata->getMessage();
}

?>
