<div class="post" id="post<?php echo $post['uid']?>">
					
	<div id="postDate<?php echo $post['uid'] ?>" class="postDate editable"><?php echo date('M j, Y',strtotime($post['date'])) ?></div>
	<?php if ($authenticated) { ?>
		<div id="postDate<?php echo $post['uid']?>_edit" class="hide">
			<form action="<?php echo $router->actionLink('Post','update'); ?>" method="POST">
				<input type="hidden" name="post[uid]" value="<?php echo $post['uid'] ?>" />
				<input type="hidden" name="post[tabid]" value="<?php echo $post['tabid'] ?>" />
				<input type="text" name="post[date]" value="<?php echo date('Y/m/d',strtotime($post['date'])) ?>" />
				<input type="submit" value="meow" />
			</form>
		</div>
	<?php } ?>
	
	<h2 id="postTitle<?php echo $post['uid'] ?>"  class="editable">
		<a href="<?php echo $router->actionLink('Tab','show',array('tabid' => $post['tabid'],'postid' => $post['uid'])); ?>"><?php echo $post['title'] ?></a>
	</h2>
	<?php if ($authenticated) { ?>
		<div id="postTitle<?php echo $post['uid']?>_edit" class="hide">
			<form action="<?php echo $router->actionLink('Post','update'); ?>" method="POST">
				<input type="hidden" name="post[uid]" value="<?php echo $post['uid'] ?>" />
				<input type="hidden" name="post[tabid]" value="<?php echo $post['tabid'] ?>" />
				<input type="text" name="post[title]" value="<?php echo $post['title'] ?>" />
				<input type="submit" value="meow" />
				<a href="?controller=Post&action=delete&tabid=<?php echo $post['tabid'] ?>&postid=<?php echo $post['uid'] ?>">x</a>
			</form>
		</div>
	<?php } ?>
	
	<div id="postContent<?php echo $post['uid'] ?>" class="editable"><?php echo $post['content'] ?></div>
	<?php if ($authenticated) { ?>
		<div id="postContent<?php echo $post['uid']?>_edit" class="hide">
			<form action="<?php echo $router->actionLink('Post','update'); ?>" method="POST">
				<input type="hidden" name="post[uid]" value="<?php echo $post['uid'] ?>" />
				<input type="hidden" name="post[tabid]" value="<?php echo $post['tabid'] ?>" />
				<textarea name="post[content]" rows="15" cols="70"><?php echo htmlspecialchars_decode($post['content']) ?></textarea>
				<input type="submit" value="meow" />
			</form>
		</div>
	<?php } ?>

</div> <!-- end post -->