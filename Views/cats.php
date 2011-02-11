<ul id="cats">
	
	<?php
		if ($tabs) {
			foreach($tabs as $aTab){
				if ($tab['uid'] == $aTab['uid']) {
					?>
						<li class="activeTab">
							<span id="tabTitle" class="editable">
							<?php if($authenticated) { ?>
								<a class="tabAction" href="<?php echo $router->actionLink('Tab','shift',array('tabid'=> $tab['uid'], 'direction' => 'left')) ?>">&lt;</a>
							<?php } ?>
							<?php echo $tab['title'] ?>
								<?php if($authenticated) { 
									//TODO add alert message
									?>
									<a class="tabAction" href="<?php echo $router->actionLink('Tab','delete',array('pageid' => $page['uid'], 'tabid' => $tab['uid'])) ?>">x</a>
									<a class="tabAction" href="<?php echo $router->actionLink('Tab','shift',array('tabid'=> $tab['uid'], 'direction' => 'right')) ?>">&gt;</a>
								<?php } ?>
							</span>
							<?php if($authenticated) { ?>
								<span id="tabTitle_edit"  class="hide">
									<form action="<?php echo $router->actionLink('Tab','update') ?>" method="POST">
										<input type="hidden" name="tab[pageid]" value="<?php echo $page['uid'] ?>" />
										<input type="hidden" name="tab[uid]" value="<?php echo $tab['uid'] ?>" />
										<input type="text" name="tab[title]" value="<?php echo $tab['title'] ?>" size="15"/>
										<select name="tab[type]">
											<option value=""></option>
											<option value="blog" <?php if ($tab['type'] == 'blog') echo 'selected="selected"' ?>>blog</option>
											<option value="album" <?php if ($tab['type'] == 'album') echo 'selected="selected"' ?>>album</option>
										</select>
										<input type="submit" value="meow" />
									</form>
								</span>
							<?php } ?>
						</li>
					<?php
				} else {
					?>
						<li><a href="<?php echo $router->actionLink('Tab','show',array('pageid' => $page['uid'], 'tabid' => $aTab['uid'])) ?>"><?php echo $aTab['title'] ?></a></li>
					<?php
				}
			}	
		}
		if ($authenticated && $page['uid']) {
			if ($newTab) {
				?>
					<li class="activeTab">
						<?php if($authenticated) { ?>
								<form action="<?php echo $router->actionLink('Tab','create') ?>" method="POST">
									<input type="hidden" name="tab[pageid]" value="<?php echo $page['uid'] ?>" />
									<input type="text" name="tab[title]" value="" />
									<input type="submit" value="meow" />
								</form>
						<?php } ?>
					</li>
				<?php
			} else {
				?>
					<li><a href="<?php echo $router->actionLink('Tab','new',array('pageid' => $page['uid'])) ?>">+</a></li>
				<?php
			}
		}
	?>
</ul>
