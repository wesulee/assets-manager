<h3>All Assets</h3>

<p><a href="<?php echo site_url('asset/create') ?>">create new asset item</a></p>

<table border="1">
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Available</th>
		<th>Category</th>
		<th>Room</th>
	</tr>
<?php foreach ($assets as $asset): ?>
	<tr>
		<td><?php echo $asset['id'] ?></td>
		<td><?php echo $asset['name'] ?></td>
		<td><?php echo $asset['available'] ? 'Yes' : 'No' ?></td>
		<td><?php echo $categories[$asset['category_id']] ?></td>
		<td><?php echo empty($asset['room_id']) ? '-' : $rooms[$asset['room_id']] ?></td>
	</tr>
<?php endforeach ?>
</table>
