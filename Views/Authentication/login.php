<?php
include('Views/header.php');
?>

<h1>Login</h1>

<form action="<?php echo $router->actionLink('Authentication','authenticate') ?>" method="POST">
	Username: <input type="text" name="username" /><br/>
	Password: <input type="password" name="password" /><br/>
	<input type="submit" value="meow" />
</form>

<?php
include('Views/footer.php');
?>