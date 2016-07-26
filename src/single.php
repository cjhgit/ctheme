<?php
/**
 * 文章内容页模板
 */

if (in_category(array(64)) ) {
    include(TEMPLATEPATH . '/single-b.php');
} else {
    include(TEMPLATEPATH . '/single-a.php');
} 

?>
