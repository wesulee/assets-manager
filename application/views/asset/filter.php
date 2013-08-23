<h3>Filter Assets</h3>
<?php
if (!empty($errors)): ?>
	<div>
		<b>Errors</b>
	<?php foreach ($errors as $error): ?>
		<div><?php echo $error ?></div>
	<?php endforeach ?>
	</div><?php
endif;

echo form_open('asset/filter_post') ?>
	<label for="available">Available?</label>
	<?php echo form_dropdown('available', $available_form_dropdown, $dropdown_selected['available']) ?><br />
	<label for="category">Category</label>
	<?php echo form_dropdown('category', $categories, $dropdown_selected['category']) ?><br />
	<label for="room">Room</label>
	<?php echo form_dropdown('room', view_room_dropdown_from_all($rooms), $dropdown_selected['room']) ?><br />

	<input type="submit" name="submit" value="Filter" />
	<a href="<?php echo site_url('asset/filter') ?>"><button type="button">Reset</button></a>
</form>

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
<?php if (!empty($assets))
	foreach ($assets as $asset): ?>
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
	<?php endforeach;
else echo '<tr><td colspan="7" align="center">No assets</td></tr>' ?>
</table>