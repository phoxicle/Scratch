
<?php if (!$newPage) { ?>
<div id="pageTitle" class="editable">
	:<?php echo $page['title'] ?>
</div>
<?php } ?>

<?php if ($authenticated) {?>
	
		<?php if ($newPage) { ?>
			<div id="pageTitle_edit">
			<form action="<?php echo $router->actionLink('Page','create') ?>" method="POST">
			
		<?php } else { ?>
			<div id="pageTitle_edit" class="hide">
			<form action="<?php echo $router->actionLink('Page','update') ?>" method="POST">
				<input type="hidden" name="page[uid]" value="<?php echo $page['uid'] ?>" />
			
		<?php } ?>
		
			<input type="text" name="page[title]" value="<?php echo $page['title'] ?>" />
			<select name="page[headerid]" value="<?php echo $page['headerid'] ?>">

				<?php foreach($headeridsArr as $headerid) {
					$selected = $page['headerid'] == $headerid ? 'selected="selected"' : '';
					echo '<option value="'.$headerid.'" '.$selected.'>'.$headerid.'</option>';
				} ?>

			</select>
			<input type="checkbox" value="1" <?php echo $page['isdefault'] ? 'checked="checked"' : '' ?>" name="page[isdefault]" />
			<input type="submit" value="meow" />
		</form>
	</div>
	
<?php }	?>
