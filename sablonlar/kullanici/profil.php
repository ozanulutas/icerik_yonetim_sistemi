<?php

try
{
	include SABLONLAR."/include/header.php"; 

?>	

	Hoşgeldin <?php echo $veri["kullanici"]->kullaniciAdi; ?>
	
	




<?php
	
	
	include SABLONLAR."/include/footer.php";
}
catch(PDOException $hata)
{
	"HATA: ".$hata->getMessage();
}

?>
