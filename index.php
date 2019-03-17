<?php
// Show category menu  
# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
get_header(); #defaults to header_inc.php

?>

<a href="feed_view.php?id=science">science</a> 
<?php
get_footer(); #defaults to footer_inc.php
?>