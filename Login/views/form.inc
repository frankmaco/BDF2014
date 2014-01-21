<h1>Authentication</h1>
<p>Please login</p>
<form action="http://localhost/flogin/auth.php" method="POST">

<label for="username">Username:</label>
	<input type="text" name="username" id="username" maxlength="20" size="20"/><br/>

<label for="password">Password:</label>
	<input type="password" name="password" id="password" maxlength="20" size="20"/><br/>
	<input type="hidden" name="token" value="<?php echo $_SESSION['token_id']; ?>" />
	<input type="submit"/>
</form>