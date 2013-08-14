<h2>View category: <?php echo $category['name'] ?></h2>
<h3>Assets in room</h3>
<table border="1">
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Available</th>
		<th>Room</th>
		<th>Note</th>
		<th>&nbsp;</th>
	</tr>
<?php foreach ($assets as $asset): ?>
	<tr>
		<td><?php echo $asset['id'] ?></td>
		<td><?php echo $asset['name'] ?></td>
		<td><?php echo $asset['available'] ? 'Yes' : 'No' ?></td>
		<td><?php echo $asset['room_id'] ?></td>
		<td><?php echo $asset['note'] ?></td>
		<td><?php echo $asset['deleteHTML'] ?></td>
	</tr>
<?php endforeach ?>
</table>