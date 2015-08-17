<?php
require "functions.php";
if(!isset($_POST["dest"]) || $_POST["dest"] == "" || !preg_match("/^[0-9]+$/", $_POST["dest"])) {
	errMsg("Numero di telefono non valido", "index.php");
}

$ext = pathinfo($_FILES["f"]["name"], PATHINFO_EXTENSION);
$dest = preg_replace("/^[^0-9]*$/", "", $_POST["dest"]);

if(HYLAFAX_REPLACEZERO) {
    $dest = "0" . $dest;
}

$uploadfile = "/tmp/" . time() . "_" . $dest . ".tif";

echo $uploadfile."\n";
$v = `/usr/bin/gs -q -dNOPAUSE -dBATCH -sDEVICE=tiffg4 -sPAPERSIZE=a4 -sOutputFile=$uploadfile {$_FILES["f"]["tmp_name"]} -c quit`;
$v = `/usr/bin/sendfax -n -E -l -s a4 -b 9600 -B 9600 -d $dest $uploadfile`;
unlink($uploadfile);

infoMsg("FAX accodato per l'invio.", "index.php");

#errMsg("FAX non inviato. Errore interno durante il salvataggio del FAX.", "index.php");
