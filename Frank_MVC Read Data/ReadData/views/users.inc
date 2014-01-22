<?php		
	foreach ($users as $num=> $row){	
        echo "<article>";
		echo "<h1>${row['id']}</h1>";
		echo "<h2>${row['username']}</h2>";
		echo "<a href=\"$base?id=${row['id']}\">profile</a>";				
        echo "</article>";
    }
?>