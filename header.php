<?php
require "functions.php";
?>
<html>
<head>
	<link rel="stylesheet" href="style.css" type="text/css" />
	<script src="jquery-2.1.4.min.js"></script>
</head>
<body>
<h1  style="float: left;"><?= _("Fax Virtuale"); ?></h1>
<pre style="float: right; font-family: monospace; padding-right: 30px;"><?php echo `/usr/bin/faxstat` ?></pre>
<div style="clear: both"></div>
<p align="center">
	.: <a href="index.php"><?= _("Invia fax"); ?></a>
	:: <a href="ricevuti.php"><?= _("Fax ricevuti"); ?></a>
	:: <a href="inviati.php"><?= _("Fax inviati"); ?></a>
    :: <a href="coda.php"><?= _("Coda invio"); ?></a> :.
</p>
<hr noshade size="1" style="padding-bottom: 20px;" />
