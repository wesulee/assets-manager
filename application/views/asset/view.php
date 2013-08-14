<h3>View Asset</h3>
<h4>ID: <?php echo $asset['id'] ?></h4>
<table border="1">
	<tr>
		<th>Name</th>
		<th>Available</th>
		<th>Category</th>
		<th>Room</th>
		<th>Note</th>
	</tr>
	<tr>
		<td><?php echo $asset['name'] ?></td>
		<td><?php echo $asset['available'] ? 'Yes' : 'No' ?></td>
		<td><?php echo $asset['category'] ?></td>
		<td><?php echo $asset['room'] ?></td>
		<td><?php echo $asset['note'] ?></td>
	</tr>
</table>