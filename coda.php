<?php
require "header.php";
$i = 0;
?>
<table class="listafax" style="margin: auto;">
	<tr>
		<!-- th>Queue ID</th -->
		<th>A</th>
		<th>Inviato</th>
		<th>Pagine</th>
		<th>Stato</th>
		<th>PDF</th>
	</tr>
<?php foreach(getDoneq(true) as $r): ?>
	<tr class="<?php echo ($i++ % 2 == 0 ? "even" : "odd") ?> faxstate<?php echo $r["state"] ?>">
		<!-- td><?php echo $r["jobid"] ?></td -->
		<td><?php echo $r["number"] ?> <?php echo isset($r["csi"]) && $r["csi"]!="" ? "(".$r["csi"].")" : "" ?></td>
		<td><?php echo isset($r["killtime"]) && $r["killtime"] != "" ? date("r", $r["killtime"]) : "-" ?></td>
		<td style="text-align: center;"><?php echo $r["totpages"] ?></td>
		<td><?php echo $r["state_string"] ?></td>
		<td><a href="get/done/fax_<?php echo $r["jobid"] ?>.pdf"><img src="pdf.gif" alt="PDF" /></a></td>
	</tr>
<?php endforeach; ?>
</table>
<?php if($i == 0): ?>
    <p style="text-align: center;">Coda vuota</p>
<?php endif; ?>