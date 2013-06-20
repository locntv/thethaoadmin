
<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs
if( isset($testing) ) {
    $testing = (array)$testing;
}
$id = isset($testing['id']) ? $testing['id'] : '';
?>
<div class="admin-box">
    <h3>testing</h3>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
    <fieldset>
        <div class="control-group <?php echo form_error('testing_date') ? 'error' : ''; ?>">
            <?php echo form_label('date', 'testing_date', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="testing_date" type="text" name="testing_date"  value="<?php echo set_value('testing_date', isset($testing['testing_date']) ? $testing['testing_date'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('testing_date'); ?></span>
        </div>


        </div>
        <div class="control-group <?php echo form_error('testing_detail') ? 'error' : ''; ?>">
            <?php echo form_label('detail', 'testing_detail', array('class' => "control-label") ); ?>
            <div class='controls'>
            <?php echo form_textarea( array( 'name' => 'testing_detail', 'id' => 'testing_detail', 'rows' => '5', 'cols' => '80', 'value' => set_value('testing_detail', isset($testing['testing_detail']) ? $testing['testing_detail'] : '') ) )?>
            <span class="help-inline"><?php echo form_error('testing_detail'); ?></span>
        </div>

        </div>



        <div class="form-actions">
            <br/>
            <input type="submit" name="save" class="btn btn-primary" value="Create testing" />
            or <?php echo anchor(SITE_AREA .'/content/testing', lang('testing_cancel'), 'class="btn btn-warning"'); ?>
            
        </div>
    </fieldset>
    <?php echo form_close(); ?>


</div>
