
<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs
if( isset($tournamenttoteam) ) {
    $tournamenttoteam = (array)$tournamenttoteam;
}
$id = isset($tournamenttoteam['id']) ? $tournamenttoteam['id'] : '';
?>
<div class="admin-box">
    <h3>TournamentToTeam</h3>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
    <fieldset>


        <?php // Change the values in this array to populate your dropdown as required ?>
		<?php if (empty($tournament_id)) : ?>
<?php $options = array(
                1 => 1,
                2 => 2,
); ?>

        <?php echo form_dropdown('tournament_id', $options, set_value('tournament_id', isset($tournamenttoteam['tournament_id']) ? $tournamenttoteam['tournament_id'] : ''), 'Tournament Id')?>
		<?php else : ?>
			<input type="hidden" name="tournament_id" id="tournament_id" value="<?php echo $tournament_id ?>" />
        <?php endif; ?>
        <?php // Change the values in this array to populate your dropdown as required ?>

<?php
	$options = array();
	foreach ($team as $key => $obj) {
		if (!empty($key)) {
			$options[$obj->id] = $obj->name;
		}
	}
?>

        <?php echo form_dropdown('team_id', $options, set_value('team_id', isset($tournamenttoteam['team_id']) ? $tournamenttoteam['team_id'] : ''), 'Team Id')?>        
        
        <div class="control-group <?php echo form_error('team_info') ? 'error' : ''; ?>">
            <?php echo form_label('Team Info', 'team_info', array('class' => "control-label") ); ?>
            <p>
		        <input id="team_info" type="text" name="team_info" maxlength="128" value="<?php echo set_value('team_info', isset($tournamenttoteam['team_info']) ? $tournamenttoteam['team_info'] : ''); ?>"  />
		        <span class="help-inline"><?php echo form_error('team_info'); ?></span>
	        </p>
        </div>

<?php
	$options = array();
	$options = array(
		'group-a' => 'Group A',
		'group-b' => 'Group B',
		'group-c' => 'Group C',
		'group-d' => 'Group D',
		'group-e' => 'Group E',
		'group-f' => 'Group F',
		'group-g' => 'Group G',
		'group-h' => 'Group H',
	);
?>
        
        <?php echo form_dropdown('group_code', $options, set_value('group_code', isset($tournamenttoteam['group_code']) ? $tournamenttoteam['group_code'] : ''), 'Group Code')?>        
        
        <div class="control-group <?php echo form_error('point') ? 'error' : ''; ?>">
            <?php echo form_label('Point', 'point', array('class' => "control-label") ); ?>
            <p>
        <input id="point" type="text" name="point" maxlength="4" value="<?php echo set_value('point', isset($tournamenttoteam['point']) ? $tournamenttoteam['point'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('point'); ?></span>
        </p>


        </div>
        <div class="control-group <?php echo form_error('ranking') ? 'error' : ''; ?>">
            <?php echo form_label('Ranking', 'ranking', array('class' => "control-label") ); ?>
            <p>
        <input id="ranking" type="text" name="ranking" maxlength="4" value="<?php echo set_value('ranking', isset($tournamenttoteam['ranking']) ? $tournamenttoteam['ranking'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('ranking'); ?></span>
        </p>


        </div>
        <div class="control-group <?php echo form_error('is_out') ? 'error' : ''; ?>">
            <?php echo form_label('Is Out', 'is_out', array('class' => "control-label") ); ?>
            <p>
            <label class="checkbox" for="is_out">
            <input type="checkbox" id="is_out" name="is_out" value="1" <?php echo (isset($tournamenttoteam['is_out']) && $tournamenttoteam['is_out'] == 1) ? 'checked="checked"' : set_checkbox('is_out', 1); ?>>
            <span class="help-inline"><?php echo form_error('is_out'); ?></span>
            </label>

        </p>

        </div>



        <div class="form-actions">
            <br/>
            <input type="submit" name="save" class="btn btn-primary" value="Create TournamentToTeam" />
            or <?php echo anchor(SITE_AREA .'/content/tournamenttoteam', lang('tournamenttoteam_cancel'), 'class="btn btn-warning"'); ?>
            
        </div>
    </fieldset>
    <?php echo form_close(); ?>


</div>
