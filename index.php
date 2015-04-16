<html>
<div>
Generate report from JSON files:
<form action="upload.php" method="post" enctype="multipart/form-data">
	<table>
	<tr>
		<td>Deck JSON</td>
		<td><input type="file" name="deck" id="deck" value="choose deck file"></td>
	</tr>
	<tr>
		<td>Activity JSON</td>
		<td><input type="file" name="activity" id="activity"></td>
	</tr>
	<tr>
		<td>Task JSON</td>
		<td><input type="file" name="task" id="task"></td>
	</tr>
	<tr>
		<td>Download report</td>
		<td><input type="checkbox" name="download" id="download"></td>
	</tr>
	</table>
	<input type="submit" name="submit">
</form>
</div>
</html>