<?php

try
{
	include SABLONLAR."/include/header.php";  
	
	$fontlar = array("Arial", "Times New Roman", "Constantia", "Courier New", "Consolas", "Calibri", "Verdana", "Georgia", "Monospace", "Comic Sans MS");

?>
	
	<form action="admin.php?secenek=stilGuncelle" method="post" id="makaleFormu"> 
		
		<h3>Renk Ayarları</h3>
		<?php 		
		foreach($stiller as $stil) { 					
			if(strpos($stil->ozellik, "color:") || $stil->ozellik == "color:") { ?>	
			  
				<div id="renkSec"><input type="color" value="<?php echo rtrim($stil->deger, ";"); ?>" name="<?php echo $stil->stilId; ?>"></div><?php		
				echo $stil->stilAciklama;
				?> <br> <?php
			}	
		}
		?> 
		<hr>
		<h3>Yazı Tipi Ayarları</h3><?php
		foreach($stiller as $stil) {
			if(strpos($stil->ozellik, "family")) {
				echo $stil->stilAciklama;
				?><select name="<?php echo $stil->stilId; ?>"><?php
				foreach($fontlar as $font) { ?>
					<option style="font-family:<?php echo $font; ?>" <?php  echo ($font == rtrim($stil->deger, ";")) ? " selected" : "" ; ?>><?php echo $font; ?></option>	
			<?php 
				}
				?></select><br><br> <?php			
			}
		}	
		?>			
		<hr>
		<h3>Yazı Boyu Ayarları</h3><?php
		foreach($stiller as $stil) {
			if(strpos($stil->ozellik, "size")) {
				echo $stil->stilAciklama;
				?><select name="<?php echo $stil->stilId; ?>"><?php
				for($i=12; $i<=56; $i+=2) { ?>
					<option <?php echo ($i == rtrim($stil->deger, ";")) ? "selected" : "" ?>><?php echo $i . "pt"; ?></option>
			<?php 
				}
				?></select><br><br> <?php			
			}
		}	
		?>	
		<br>
		
		
		<input type="submit" name="kaydet" value="Kaydet">
		<input type="submit" formnovalidate name="iptal" value="İptal">
		
	</form>

<?php
	
	include SABLONLAR."/include/footer.php";
}
catch(PDOException $hata)
{
	"HATA: ".$hata->getMessage();
}

?>