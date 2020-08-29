<?php 

try
{
	include SABLONLAR."/include/header.php"; 
	
	
	echo $veri["menu"]->menuIcerik; 
	
	
	include SABLONLAR."/include/footer.php";
}
catch(PDOException $hata)
{
	echo "HATA:" . $hata->getMessage();
}

?>
