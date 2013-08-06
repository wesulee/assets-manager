<h3>All rooms</h3>

<p><a href="<?php echo site_url('room/create') ?>">create new room</a></p>

<table border="1">
	<tr>
		<th>ID</th>
		<th>Name</th>
	</tr>
<?php foreach ($rooms as $room): ?>
	<tr>
		<td><a href="<?php echo site_url('room/view').'/'.$room['id'] ?>"><?php echo $room['id'] ?></a></td>
		<td><?php echo $room['name'] ?></td>
	</tr>
<?php endforeach ?>
</table>