<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/team') ?>" id="list"><?php echo lang('team_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Team.Content.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/content/team/create') ?>" id="create_new"><?php echo lang('team_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>