<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/settings/country') ?>" id="list"><?php echo lang('country_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Country.Settings.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/settings/country/create') ?>" id="create_new"><?php echo lang('country_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>