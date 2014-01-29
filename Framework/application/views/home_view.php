<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <title>Welcome back <?php echo $user_name; ?></title>
 </head>
 <body>
   <p>Welcome back <?php echo $user_name; ?>! | <a href="home/logout">LOGOUT</a></p>
   <hr />
   <p><?php echo anchor('home', 'View All Users', 'class="link-class"'); ?> | <?php echo anchor('adduser', 'Add New User', 'class="link-class"'); ?></p>
   <?php echo $app_users; ?>
   
 
 </body>
</html>