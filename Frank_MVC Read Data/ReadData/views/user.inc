<?php

echo "<article>";
	if (count($user) > 0) {
		foreach ($user as $num=> $row){	
			echo "<h1>${row['id']}</h1>";
			echo "<h2>${row['username']}</h2>";
			echo "<h3>${row['userpassword']}</h3>";		
	    }	
	} else {
        echo "<h1>User not found.</h1>";	
    }

echo "<a href=\"$base\">back</a>";		
echo "</article>";