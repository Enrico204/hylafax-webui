<?php
require "header.php";
$i = 0;
?>
<table class="listafax" style="margin: auto;">
	<tr>
		<!-- th>ID</th -->
		<th><?= _("Da"); ?></th>
		<th><?= _("Quando"); ?></th>
		<th><?= _("Durata"); ?></th>
		<th><?= _("Pagine"); ?></th>
		<th><?= _("PDF"); ?></th>
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
    <?php if($i == 0): ?>
        <p style="text-align: center;"><?= _("Nessun fax ricevuto"); ?></p>
    <?php endif; ?>
