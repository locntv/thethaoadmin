<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/tournament') ?>" id="list"><?php echo lang('tournament_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Tournament.Content.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/content/tournament/create') ?>" id="create_new"><?php echo lang('tournament_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>