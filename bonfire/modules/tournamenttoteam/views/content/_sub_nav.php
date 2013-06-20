<ul class="nav nav-pills">
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/content/tournament') ?>" id="back"><?php echo lang('tournamenttoteam_back'); ?></a>
	</li>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/content/match/index/' . $tournament_id) ?>" id="matches"><?php echo lang('tournamenttoteam_matches'); ?></a>
	</li>
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/tournamenttoteam') ?>" id="list"><?php echo lang('tournamenttoteam_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('TournamentToTeam.Content.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/content/tournamenttoteam/create/' . $tournament_id) ?>" id="create_new"><?php echo lang('tournamenttoteam_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>