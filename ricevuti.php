<?php
require "header.php";
$i = 0;
?>
<table class="ricevuti" style="margin: auto;">
	<tr>
		<!-- th>ID</th -->
		<th>Da</th>
		<th>Quando</th>
		<th>Durata</th>
		<th>Pagine</th>
		<th>PDF</th>
	</tr>
<?php foreach(getRecvq() as $r): ?>
	<tr class="<?php echo ($i++ % 2 == 0 ? "even" : "odd") ?>">
		<!-- td><?php echo $r["id"] ?></td -->
		<td><?php echo $r["sender"] ?></td>
		<td><?php echo $r["received"] ?></td>
		<td><?php echo $r["ttr"] ?></td>
		<td style="text-align: center;"><?php echo $r["pages"] ?></td>
		<td><a href="get/recv/fax_<?php echo $r["id"] ?>.pdf"><img src="pdf.gif" alt="PDF" /></a></td>
	</tr>
<?php endforeach; ?>
</table>