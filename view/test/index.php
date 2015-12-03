<html>
<meta charset="UTF-8">
        <header>
                <title>测试页面</title>
        </header>
        <body>
        		<?php 
        			foreach($result as $k => $v) {
        				print_r($v['name']);
        				echo "<br/>";
        			}
        			
        		?>
        </body>
</html>