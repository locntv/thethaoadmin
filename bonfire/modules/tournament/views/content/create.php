
<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs
if( isset($tournament) ) {
    $tournament = (array)$tournament;
}
$id = isset($tournament['id']) ? $tournament['id'] : '';
?>
<div class="admin-box">
    <h3>Tournament</h3>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
    <fieldset>
        <div class="control-group <?php echo form_error('name') ? 'error' : ''; ?>">
            <?php echo form_label('Name'. lang('bf_form_label_required'), 'name', array('class' => "control-label") ); ?>
            <p>
        <input id="name" type="text" name="name" maxlength="64" value="<?php echo set_value('name', isset($tournament['name']) ? $tournament['name'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('name'); ?></span>
        </p>


        </div>
        <div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
            <?php echo form_label('Description', 'description', array('class' => "control-label") ); ?>
            <p>
            <?php echo form_textarea( array( 'name' => 'description', 'id' => 'description', 'rows' => '5', 'cols' => '80', 'value' => set_value('description', isset($tournament['description']) ? $tournament['description'] : '') ) )?>
            <span class="help-inline"><?php echo form_error('description'); ?></span>
        </p>

        </div>
        <div class="control-group <?php echo form_error('date_start') ? 'error' : ''; ?>">
            <?php echo form_label('Date Start', 'date_start', array('class' => "control-label") ); ?>
            <p>
        <input id="date_start" type="text" name="date_start" maxlength="64" value="<?php echo set_value('date_start', isset($tournament['date_start']) ? $tournament['date_start'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('date_start'); ?></span>
        </p>


        </div>
        <div class="control-group <?php echo form_error('date_end') ? 'error' : ''; ?>">
            <?php echo form_label('Date End', 'date_end', array('class' => "control-label") ); ?>
            <p>
        <input id="date_end" type="text" name="date_end" maxlength="64" value="<?php echo set_value('date_end', isset($tournament['date_end']) ? $tournament['date_end'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('date_end'); ?></span>
        </p>


        </div>


        <?php // Change the values in this array to populate your dropdown as required ?>

<?php $options = array(
                6 => 6,
); ?>

        <?php echo form_dropdown('category_id', $options, set_value('category_id', isset($tournament['category_id']) ? $tournament['category_id'] : ''), 'Category Id')?>        <div class="control-group <?php echo form_error('take_place') ? 'error' : ''; ?>">
            <?php echo form_label('Take Place', 'take_place', array('class' => "control-label") ); ?>
            <p>
        <input id="take_place" type="text" name="take_place" maxlength="128" value="<?php echo set_value('take_place', isset($tournament['take_place']) ? $tournament['take_place'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('take_place'); ?></span>
        </p>


        </div>
        <div class="control-group <?php echo form_error('status') ? 'error' : ''; ?>">
            <?php echo form_label('Status', 'status', array('class' => "control-label") ); ?>
            <p>
            <label class="checkbox" for="status">
            <input type="checkbox" id="status" name="status" value="1" <?php echo (isset($tournament['status']) && $tournament['status'] == 1) ? 'checked="checked"' : set_checkbox('status', 1); ?>>
            <span class="help-inline"><?php echo form_error('status'); ?></span>
            </label>

        </p>

        </div>



        <div class="form-actions">
            <br/>
            <input type="submit" name="save" class="btn btn-primary" value="Create Tournament" />
            or <?php echo anchor(SITE_AREA .'/content/tournament', lang('tournament_cancel'), 'class="btn btn-warning"'); ?>
            
        </div>
    </fieldset>
    <?php echo form_close(); ?>


</div>
