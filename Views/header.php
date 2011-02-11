<?php 
$headeridsArr = array(/*'laptop',*/ 'mill', 'purse', 'milk', 'notebook', 'bottle', 'scissors', 'books'/*, 'tools'*/);
?>

<!DOCTYPE html> 
<html>
<head>
	<base href="<?php echo $router->baseUrl.'/' ?>" />
	
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="The personal website of Christine Gerpheide"/>
	<meta name="keywords" content="gerpheide,christine gerpheide, {page.title}, {tab.title}"/>
    <link rel="stylesheet" href="Resources/styles/global.css" type="text/css" media="all" />
    <script type="text/javascript" src="Resources/scripts/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="Resources/scripts/global.js"></script>

<script src="Resources/scripts/highlight/highlight.pack.js"></script>
<script> 
  hljs.tabReplace = '    ';
  hljs.initHighlightingOnLoad();
</script> 
<link rel="stylesheet" href="Resources/scripts/highlight/styles/github.css">

    <title>Pheide : <?php echo $page['title'] ?> | <?php echo $tab['title'] ?></title>

	<?php if ($posts) { ?>
		<link rel="alternate" 
			title="Pheide : <?php echo $page['title'] ?> | <?php echo $tab['title'] ?> RSS" 
			href="<?php echo $router->actionLink('Tab','rss',array('pageid' => $page['uid'], 'tabid' => $tab['uid'])) ?>" type="application/rss+xml" />
	<?php } //end if posts ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17623952-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
		
</head>
<body>
<div id="page">
	
	<?php if ($authenticated) { echo '<a href="'.$router->actionLink('Authentication','logout').'">^</a>'; } ?>
		
    <div id="header">
        
        <?php 
        	foreach ($headeridsArr as $headerid) {
        		if ($pages[$headerid]) {
        			echo '
<div id="'.$headerid.'" onmouseover="show(this);" onmouseout="hide(this);"><a href="'.$router->actionLink('Page','show',array('pageid' => $pages[$headerid]['uid'])).'"><img alt="'.$pages[$headerid]['title'].'" src="Resources/images/'.$headerid.'_cutout.jpg" style="visibility:hidden;" /></a></div>';
        		} else if ($authenticated) {
        			echo '
<div id="'.$headerid.'" onmouseover="show(this);" onmouseout="hide(this);"><a href="'.$router->actionLink('Page','new',array('headerid' => $headerid)).'"><img alt="" src="Resources/images/'.$headerid.'_cutout.jpg" style="visibility:hidden;" /></a></div>';
        		}
        	}
        ?>
        
        <div id="label"></div>
		<div id="current">
			<?php include('Views/pagetitle.php');?>
		</div> <!-- current -->
	
    </div> <!-- end header -->


<?php require_once('Views/cats.php') ?>
