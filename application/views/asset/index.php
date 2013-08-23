<h3>All Assets</h3>

<p>
	<?php echo anchor('asset/create', 'Create Asset') ?>
	<?php echo anchor('asset/filter', 'Filter') ?>
</p>

<table border="1">
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Available</th>
		<th>Added by</th>
		<th>Category</th>
		<th>Room</th>
		<th>Note</th>
		<th>&nbsp;</th>
	</tr>
<?php foreach ($assets as $asset): ?>
	<tr>
		<td><?php echo $asset['id'] ?></td>
		<td><?php echo $asset['name'] ?></td>
		<td><?php echo $asset['available'] ? 'Yes' : 'No' ?></td>
		<td><?php echo view_asset_username($asset, $users) ?></td>
		<td><?php echo $categories[$asset['category_id']] ?></td>
		<td><?php echo view_asset_room($asset, $rooms) ?></td>
		<td><?php echo $asset['note'] ?></td>
		<td><?php echo $asset['deleteHTML'] ?></td>
	</tr>
<?php endforeach ?>
</table>