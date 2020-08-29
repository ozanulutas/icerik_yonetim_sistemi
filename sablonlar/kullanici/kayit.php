<?php

try
{
	include SABLONLAR."/include/header.php"; 
	
	if(isset($veri["mesaj"]))
		echo $veri["mesaj"]; 

?>	
	
	
		<div id="girisFormu">
			
			<form action="kullanici.php?secenek=kayit" method="post">			
				Kullanıcı Adı <input type="text" name="kullaniciAdi" placeholder="Kullanıcı adınız.." required><br>		
				Şifre <input type="password" name="sifre" placeholder="Şifreniz.." required><br>
				Email <input type="text" name="email" placeholder="Email adresiniz.." required><br>
				<input type="submit" value="Kaydol" name="kaydol">
			</form>
			
		</div>
	
	
<?php
	
	
	include SABLONLAR."/include/footer.php";
}
catch(PDOException $hata)
{
	"HATA: ".$hata->getMessage();
}

?>