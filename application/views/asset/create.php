<h2>Create asset</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('asset/create') ?>
	<label for="name">Name</label>
	<input type="input" name="name" value="<?php echo set_value('name') ?>"/><br />
	<input type="radio" name="available" value="1" <?php echo set_radio('available', '1') ?>>Available</input>
	<input type="radio" name="available" value="0" <?php echo set_radio('available', '0') ?>>Not Available</input><br />
	<label for="category_id">Category</label>
	<?php echo form_dropdown('category_id', $categories) ?><br />
	<label for="room_id">Room (optional)</label>
	<?php echo form_dropdown('room_id', $rooms) ?><br />
	<label for="note">Note (optional)</label><br />
	<?php echo form_textarea($note_settings) ?><br />

	<input type="submit" name="submit" value="Create asset" />
</form>
<br /><br />
<?php echo anchor('asset/index', 'Cancel') ?>