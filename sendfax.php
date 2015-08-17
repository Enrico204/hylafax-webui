<?php
require "functions.php";
if(!isset($_GET["dest"]) || $_GET["dest"] == "" || !preg_match("/^[0-9]+$/", $_GET["dest"])) {
	errMsg("Numero di telefono non valido", "index.php");
}

$ext = pathinfo($_FILES["f"]["name"], PATHINFO_EXTENSION);
$dest = preg_replace("/^[0-9]*$/", "", $_GET["dest"]);
$uploadfile = "/tmp/" . time() . "_" . $dest . ".tif";
$v = move_uploaded_file($_FILES["f"]["tmp_name"], $uploadfile);

if($v) {
	system("/usr/bin/gs -q -dNOPAUSE -sDEVICE=tiffg4 -sOutputFile=$uploadfile {$_FILES["f"]["tmp_name"]} -c quit");
	$res = `/usr/bin/sendfax -n -E -l -s a4 -b 9600 -B 9600 -d $dest $uploadfile`;
	unlink($uploadfile);

	infoMsg("FAX accodato per l'invio.", "index.php");
} else {
	errMsg("FAX non inviato. Errore interno durante il salvataggio del FAX.", "index.php");
}
