<h3>All categories</h3>

<p><a href="<?php echo site_url('category/create') ?>">create new category</a></p>

<table border="1">
	<tr>
		<th>ID</th>
		<th>Name</th>
	</tr>
<?php foreach ($categories as $category): ?>
	<tr>
		<td><a href="<?php echo site_url('category/view').'/'.$category['id'] ?>"><?php echo $category['id'] ?></a></td>
		<td><?php echo $category['name'] ?></td>
	</tr>
<?php endforeach ?>
</table>