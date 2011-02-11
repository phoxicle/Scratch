<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0">
<channel>

<title>Pheide.com : <?php echo $page['title'] . ' | ' . $tab['title'] ?></title>
<link><?php $router->actionLink('Tab','show',array('pageid' => $page['uid'], 'tabid' => $tab['uid'])) ?></link>
<description><?php $tab['aside'] ?></description>
<lastBuildDate><?php echo date('D, d M Y g:i:s O') ?></lastBuildDate>
<language>en-us</language>

<?php
	if ($posts) {
		foreach ($posts as $post){
			?>

<item>
<title><?php echo $post['title'] ?></title>
<link><?php echo $router->actionLink('Tab','show',array('pageid' => $page['uid'], 'tabid' => $tab['uid']),'#post'.$post['uid']) ?></link>
<guid><?php echo $router->actionLink('Tab','show',array('pageid' => $page['uid'], 'tabid' => $tab['uid']),'#post'.$post['uid']) ?></guid>
<pubDate><?php echo date('D, d M Y g:i:s O',strtotime($post['date'])) ?></pubDate>
<description><?php echo htmlspecialchars(substr($post['content'],0,500)) ?></description>
</item>

<?php 
		} //end foreach post
	} //end if posts
?>

</channel>
</rss>
