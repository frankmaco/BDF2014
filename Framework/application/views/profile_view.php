<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <title>Profile Area</title>
 </head>
 <body>
   <p>Welcome back <?php echo $user_name; ?>! | <a href="home/logout">LOGOUT</a></p>
   <hr />
   <p><?php echo anchor('home', 'View All Users', 'class="link-class"'); ?> | <?php echo anchor('adduser', 'Add New User', 'class="link-class"'); ?></p>
   
   <article>
		<h1>USER ID: <?php echo $appuser_id; ?></h1>
		<h2>USER NAME: <?php echo $appuser_name; ?></h2>		
		<h1><?php echo anchor('profile?id=' . $appuser_id . '&delete=true', 'Delete User', 'class="link-class"'); ?></h1>
		<h3>Edit User Info</h3>
		
   <?php echo validation_errors(); ?>
   <?php echo form_open('appuserchange'); ?>
     <label for="username">Username:</label>
     <input type="text" size="20" id="username" name="username" value="<?php echo $appuser_name; ?>"/>
     <br/>
     <label for="password">New Password:</label>
     <input type="password" size="20" id="passowrd" name="password"/>
     <input type="hidden" id="userid" name="userid" value="<?php echo $appuser_id; ?>"/>
     <br/>
     <input type="submit" value="Update User"/>
   </form>
   </p>
	<?php echo anchor('home', '<- Go Back', 'class="link-class"'); ?>
   <p>
   </article>
 </body>
</html>