
<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs
if( isset($country) ) {
    $country = (array)$country;
}
$id = isset($country['id']) ? $country['id'] : '';
?>
<div class="admin-box">
    <h3>Country</h3>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
    <fieldset>
        <div class="control-group <?php echo form_error('name') ? 'error' : ''; ?>">
            <?php echo form_label('Name', 'name', array('class' => "control-label") ); ?>
            <p>
        <input id="name" type="text" name="name" maxlength="64" value="<?php echo set_value('name', isset($country['name']) ? $country['name'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('name'); ?></span>
        </p>


        </div>
        <div class="control-group <?php echo form_error('iso_code') ? 'error' : ''; ?>">
            <?php echo form_label('Iso Code', 'iso_code', array('class' => "control-label") ); ?>
            <p>
        <input id="iso_code" type="text" name="iso_code" maxlength="3" value="<?php echo set_value('iso_code', isset($country['iso_code']) ? $country['iso_code'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('iso_code'); ?></span>
        </p>


        </div>
        <div class="control-group <?php echo form_error('status') ? 'error' : ''; ?>">
            <?php echo form_label('Status', 'status', array('class' => "control-label") ); ?>
            <p>
            <label class="checkbox" for="status">
            <input type="checkbox" id="status" name="status" value="1" <?php echo (isset($country['status']) && $country['status'] == 1) ? 'checked="checked"' : set_checkbox('status', 1); ?>>
            <span class="help-inline"><?php echo form_error('status'); ?></span>
            </label>

        </p>

        </div>



        <div class="form-actions">
            <br/>
            <input type="submit" name="save" class="btn btn-primary" value="Edit Country" />
            or <?php echo anchor(SITE_AREA .'/settings/country', lang('country_cancel'), 'class="btn btn-warning"'); ?>
            

    <?php if ($this->auth->has_permission('Country.Settings.Delete')) : ?>

            or <button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php echo lang('country_delete_confirm'); ?>')">
            <i class="icon-trash icon-white">&nbsp;</i>&nbsp;<?php echo lang('country_delete_record'); ?>
            </button>

    <?php endif; ?>


        </div>
    </fieldset>
    <?php echo form_close(); ?>


</div>
