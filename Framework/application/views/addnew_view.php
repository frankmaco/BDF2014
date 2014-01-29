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
		<h1>Add New User</h1>
		
   <?php echo validation_errors(); ?>
   <?php echo form_open('addnewuser'); ?>
     <label for="username">Username:</label>
     <input type="text" size="20" id="username" name="username"/>
     <br/>
     <label for="password">New Password:</label>
     <input type="password" size="20" id="password" name="password"/>
     <br/>
     <input type="submit" value="Add New User"/>
   </form>
   </p>
	<?php echo anchor('home', '<- Go Back', 'class="link-class"'); ?>
   <p>
   </article>
 </body>
</html>