<?php
define("SINIFLAR", "siniflar"); // Sınıfların bulunduğu yol
define("SABLONLAR", "sablonlar"); // Şablonların bulunduğu yol
define("RESIMLER", "resimler"); // Şablonların bulunduğu yol

define("DB_HOST", "mysql:host=localhost; dbname=db_iys; charset=utf8");
define("DB_KA", "root");
define("DB_SIFRE", "");

define("GOSTERILEN_MAKALE", 5); // Anasayfadaki gösterilecek makale sayısı

require(SINIFLAR."/Makale.php");
require(SINIFLAR."/Kategori.php");
require(SINIFLAR."/Kullanici.php");
require(SINIFLAR."/Menu.php");
require(SINIFLAR."/Footer.php");
require(SINIFLAR."/Header.php");
require(SINIFLAR."/Resim.php");
require(SINIFLAR."/Stil.php");
require(SINIFLAR."/Mesaj.php");


define("BASLIK", Header::headerCek()->headerBaslik);

?>