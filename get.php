<?php
require "functions.php";

header("Content-type: application/pdf");

$qid = intval($_GET["qid"]);
$file = null;
switch($_GET["queue"]) {
	case "done":
		$file = HYLAFAX_ROOT . "docq/doc" . $qid . ".ps";
		echo `/usr/bin/ps2pdf $file -`;
		break;
	case "recv":
		$file = HYLAFAX_ROOT . "recvq/fax" . str_pad($qid, 9, "0", STR_PAD_LEFT) . ".tif";
		system("/usr/bin/tiff2pdf -p A4 -o /tmp/fax_$qid.pdf $file");
		echo file_get_contents("/tmp/fax_$qid.pdf");
		unlink("/tmp/fax_$qid.pdf");
		break;
}
