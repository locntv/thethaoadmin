<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/testing') ?>" id="list"><?php echo lang('testing_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Testing.Content.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/content/testing/create') ?>" id="create_new"><?php echo lang('testing_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>