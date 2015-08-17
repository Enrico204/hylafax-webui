<?php
require "header.php";

if(isset($_SESSION["errmsg"])) {
	echo "<p style=\"text-align: center; color: red;\">" . $_SESSION["errmsg"] . "</p>";
	unset($_SESSION["errmsg"]);
	require "footer.php";
	die();
}

if(isset($_SESSION["infomsg"])) {
	echo "<p style=\"text-align: center; color: blue;\">" . $_SESSION["infomsg"] . "</p>";
	unset($_SESSION["infomsg"]);
	require "footer.php";
	die();
}

?>
<form class="fileform" action="sendfax.php" method="POST" enctype="multipart/form-data">
<table>
	<tr>
		<th>Destinatario</th>
		<td><input type="text" placeholder="0773123456" name="dest" id="dest" /></td>
	</tr>
	<tr>
		<th>File</th>
		<td><input type="file" name="f" /></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center;"><button type="submit">Invia FAX</button></td>
	</tr>
</table>
</form>
<script>
	$('#dest').keydown(function(event){
		var char = String.fromCharCode(event.which);

		if((!char.match(/^[0-9]+$/) && event.which > 31) || event.which == 0) {
			event.preventDefault();
		}
	});
	function checkValidForm() {
		var dest = $('#dest').val();
		if(dest == "" || !dest.match(/^[0-9]+$/)) {
			alert("Numero fax di destinazione non valido");
			return false;
		}
	}
</script>
<?php
require "footer.php";