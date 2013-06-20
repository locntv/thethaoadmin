
<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs
if( isset($team) ) {
    $team = (array)$team;
}
$id = isset($team['id']) ? $team['id'] : '';
?>
<div class="admin-box">
    <h3>Team</h3>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
    <fieldset>
        <div class="control-group <?php echo form_error('name') ? 'error' : ''; ?>">
            <?php echo form_label('Name'. lang('bf_form_label_required'), 'name', array('class' => "control-label") ); ?>
            <p>
        <input id="name" type="text" name="name" maxlength="64" value="<?php echo set_value('name', isset($team['name']) ? $team['name'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('name'); ?></span>
        </p>


        </div>


        <?php // Change the values in this array to populate your dropdown as required ?>

<?php $options = array(
                0 => 0,
                1 => 1,
                2 => 2,
); ?>

        <?php echo form_dropdown('type', $options, set_value('type', isset($team['type']) ? $team['type'] : ''), 'Type')?>

        <?php // Change the values in this array to populate your dropdown as required ?>

<?php $options = array(
                1 => 1,
                2 => 2,
                3 => 3,
); ?>

        <?php echo form_dropdown('category_id', $options, set_value('category_id', isset($team['category_id']) ? $team['category_id'] : ''), 'Category Id')?>        <div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
            <?php echo form_label('Description', 'description', array('class' => "control-label") ); ?>
            <p>
            <?php echo form_textarea( array( 'name' => 'description', 'id' => 'description', 'rows' => '5', 'cols' => '80', 'value' => set_value('description', isset($team['description']) ? $team['description'] : '') ) )?>
            <span class="help-inline"><?php echo form_error('description'); ?></span>
        </p>

        </div>
        <div class="control-group <?php echo form_error('country_id') ? 'error' : ''; ?>">
            <?php echo form_label('Country Id', 'country_id', array('class' => "control-label") ); ?>
            <p>
        <input id="country_id" type="text" name="country_id" maxlength="11" value="<?php echo set_value('country_id', isset($team['country_id']) ? $team['country_id'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('country_id'); ?></span>
        </p>


        </div>



        <div class="form-actions">
            <br/>
            <input type="submit" name="save" class="btn btn-primary" value="Edit Team" />
            or <?php echo anchor(SITE_AREA .'/content/team', lang('team_cancel'), 'class="btn btn-warning"'); ?>
            

    <?php if ($this->auth->has_permission('Team.Content.Delete')) : ?>

            or <button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php echo lang('team_delete_confirm'); ?>')">
            <i class="icon-trash icon-white">&nbsp;</i>&nbsp;<?php echo lang('team_delete_record'); ?>
            </button>

    <?php endif; ?>


        </div>
    </fieldset>
    <?php echo form_close(); ?>


</div>
