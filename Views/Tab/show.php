<?php
include('Views/header.php');
?>

<div id="col2">
	<?php if ($tab['type'] == 'blog') { ?>
		<div class="rssIcon">
			<a href="<?php echo $router->actionLink('Post','rss',array('pageid' => $page['uid'], 'tabid' => $tab['uid'])) ?>" target="_blank">
				<img src="Resources/images/rss_icon.jpg"/>
			</a>
		</div>
	<?php } //end if posts ?>
	
	<div id="aside" class="editable">
	<?php echo $tab['aside'] ?>
	</div> <!-- aside -->
	<?php if ($authenticated) { ?>
		<div id="aside_edit" class="hide">
			<form action="<?php echo $router->actionLink('Tab','update') ?>" method="POST">
				<input type="hidden" name="tab[pageid]" value="<?php echo $page['uid'] ?>" />
				<input type="hidden" name="tab[uid]" value="<?php echo $tab['uid'] ?>" />
				<textarea name="tab[aside]" rows="15" cols="33"><?php echo $tab['aside'] ?></textarea>
				<input type="submit" value="meow" />
			</form>
		</div>
	<?php } ?>
</div>

<div id="text">
	
	<div id="tabContent" class="editable">
	<?php echo $tab['content'] ?>
	</div> <!-- tabContent -->
	<?php if ($authenticated) { ?>
		<div id="tabContent_edit"  class="hide">
			<form action="<?php echo $router->actionLink('Tab','update') ?>" method="POST">
				<input type="hidden" name="tab[pageid]" value="<?php echo $page['uid'] ?>" />
				<input type="hidden" name="tab[uid]" value="<?php echo $tab['uid'] ?>" />
				<textarea name="tab[content]" rows="15" cols="70"><?php echo $tab['content'] ?></textarea>
				<input type="submit" value="meow" />
			</form>
		</div>
	<?php } ?>

	<?php echo $content ?>
	
</div> <!-- text -->

<?php
include('Views/footer.php');
?>