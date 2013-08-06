<table border="1">
	<tr>
		<th>Name</th>
		<th>Available</th>
		<th>Category</th>
		<th>Room</th>
	</tr>
	<tr>
		<td><?php echo $asset['name'] ?></td>
		<td><?php echo $asset['available'] ? 'Yes' : 'No' ?></td>
		<td><?php echo $asset['category'] ?></td>
		<td><?php echo $asset['room'] ?></td>
	</tr>
</table>