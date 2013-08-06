<h3>Create a new category</h3>

<?php echo validation_errors(); ?>

<?php echo form_open('category/create') ?>

	<label for="name">Name</label>
	<input type="input" name="name" /><br />

	<input type="submit" name="submit" value="Create category" />

</form>