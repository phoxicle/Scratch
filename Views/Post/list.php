<?php
?>

<?php 
	if ($authenticated) { ?>
		<div id="newPost" class="postDate editable">+</div>
		<div id="newPost_edit" class="hide">
			<form action="<?php echo $router->actionLink('Post','create'); ?>" method="POST">
				<input type="hidden" name="post[tabid]" value="<?php echo $tab['uid'] ?>" />
				<input type="text" name="post[title]" value="" />
				<input type="text" name="post[date]" value="<?php echo date('Y/m/d') ?>" />
				<textarea name="post[content]" rows="15" cols="70"></textarea>
				<input type="submit" value="meow" />
			</form>
		</div>
<?php } ?>

<?php
	if ($posts) {
		foreach ($posts as $post){ 
			include('show.php');
		} // end foreach post
	} // end if posts
?>
