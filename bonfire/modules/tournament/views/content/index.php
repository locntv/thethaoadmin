<div class="admin-box">
	<h3>Tournament</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($this->auth->has_permission('Tournament.Content.Delete') && isset($records) && is_array($records) && count($records)) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Name</th>
					<th>Description</th>
					<th>Date Start</th>
					<th>Date End</th>
					<th>Category Id</th>
					<th>Take Place</th>
					<th>Status</th>
				</tr>
			</thead>
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<tfoot>
				<?php if ($this->auth->has_permission('Tournament.Content.Delete')) : ?>
				<tr>
					<td colspan="10">
						<?php echo lang('bf_with_selected') ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('<?php echo lang('tournament_delete_confirm'); ?>')">
					</td>
				</tr>
				<?php endif;?>
			</tfoot>
			<?php endif; ?>
			<tbody>
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<?php foreach ($records as $record) : ?>
				<tr>
					<?php if ($this->auth->has_permission('Tournament.Content.Delete')) : ?>
					<td><input type="checkbox" name="checked[]" value="<?php echo $record->id ?>" /></td>
					<?php endif;?>
					
				<?php if ($this->auth->has_permission('Tournament.Content.Edit')) : ?>
				<td><?php echo anchor(SITE_AREA .'/content/tournamenttoteam/index/'. $record->id, '<i class="icon-pencil">&nbsp;</i>' .  $record->name) ?></td>
				<?php else: ?>
				<td><?php echo $record->name ?></td>
				<?php endif; ?>
			
				<td><?php echo $record->description?></td>
				<td><?php echo $record->date_start?></td>
				<td><?php echo $record->date_end?></td>
				<td><?php echo $record->category_id?></td>
				<td><?php echo $record->take_place?></td>
				<td><?php echo $record->status?></td>
				</tr>
			<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="10">No records found that match your selection.</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
	<?php echo form_close(); ?>
</div>