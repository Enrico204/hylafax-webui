<?php
require "functions.php";
if(!isset($_POST["dest"]) || $_POST["dest"] == "" || !preg_match("/^[0-9]+$/", $_POST["dest"])) {
	errMsg("Numero di telefono non valido", "index.php");
}

if(!isset($_FILES["f"]["name"]) || $_FILES["f"]["name"] == "") {
    errMsg("Documento FAX non selezionato", "index.php");
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES["f"]["tmp_name"]);
finfo_close($finfo);
if($mime != "application/pdf") {
    errMsg("Il documento FAX selezionato deve essere di tipo PDF", "index.php");
}

$ext = pathinfo($_FILES["f"]["name"], PATHINFO_EXTENSION);
$dest = preg_replace("/^[^0-9]*$/", "", $_POST["dest"]);

if(HYLAFAX_REPLACEZERO) {
    $dest = "0" . $dest;
}

$modem = $_POST["modem"];
$modem = preg_replace("/^[^A-Za-z0-9]*$/", "", $modem);

$uploadfile = "/tmp/" . time() . "_" . $dest . ".tif";

$out = "";
$ret = 0;
exec("/usr/bin/gs -q -dNOPAUSE -dBATCH -sDEVICE=tiffg4 -sPAPERSIZE=a4 -sOutputFile=$uploadfile {$_FILES["f"]["tmp_name"]} -c quit", $out, $ret);
if($ret != 0) {
    errMsg("FAX non inviato. Errore interno durante l'invio del FAX.", "index.php");
}

exec("/usr/bin/sendfax -n -E -l -s a4 -b 9600 -B 9600 -h $modem@localhost -d $dest $uploadfile", $out, $ret);
unlink($uploadfile);

if($ret != 0) {
    errMsg("FAX non inviato. Errore interno durante l'invio del FAX.", "index.php");
} else {
    infoMsg("FAX accodato per l'invio.", "index.php");
}
