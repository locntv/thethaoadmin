<div class="admin-box">
	<?php $tournament_info = get_model_infos("tournament", $tournament_id); ?>
	<h3><?php echo $tournament_info->name ?></h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($this->auth->has_permission('TournamentToTeam.Content.Delete') && isset($records) && is_array($records) && count($records)) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Team Id</th>
					<th>Team Info</th>
					<th>Group Code</th>
					<th>Point</th>
					<th>Ranking</th>
					<th>Is Out</th>
				</tr>
			</thead>
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<tfoot>
				<?php if ($this->auth->has_permission('TournamentToTeam.Content.Delete')) : ?>
				<tr>
					<td colspan="8">
						<?php echo lang('bf_with_selected') ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('<?php echo lang('tournamenttoteam_delete_confirm'); ?>')">
					</td>
				</tr>
				<?php endif;?>
			</tfoot>
			<?php endif; ?>
			<tbody>
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<?php foreach ($records as $record) : ?>
				<tr>
					<?php if ($this->auth->has_permission('TournamentToTeam.Content.Delete')) : ?>
					<td><input type="checkbox" name="checked[]" value="<?php echo $record->id ?>" /></td>
					<?php endif;?>
					
				<?php /*if ($this->auth->has_permission('TournamentToTeam.Content.Edit')) : ?>
				<!--td><?php echo anchor(SITE_AREA .'/content/tournamenttoteam/edit/'. $record->id, '<i class="icon-pencil">&nbsp;</i>' .  $record->tournament_id) ?></td>
				<?php else: ?>
				<td><?php echo $record->tournament_id ?></td-->
				<?php endif;*/ ?>
			
				<td><?php echo $record->name?></td>
				<td><?php echo $record->team_info?></td>
				<td><?php echo $record->group_code?></td>
				<td><?php echo $record->point?></td>
				<td><?php echo $record->ranking?></td>
				<td><?php echo $record->is_out?></td>
				</tr>
			<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="8">No records found that match your selection.</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
	<?php echo form_close(); ?>
</div>