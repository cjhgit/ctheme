<?php
/**
 * 分类模板
 */
$strArrIds = explode(",", get_option('works_ids'));
$ids = array();

for ($i = 0, $length = count($strArrIds); $i < $length; $i++) {
	//echo count($strArrIds);
	$ids[$i] = intval($strArrIds[$i]);
	//echo '=' . $str . '|';
	//echo $ids[$i];
}
if (is_category($ids) ) {
    include(TEMPLATEPATH . '/category-b.php');
} else {
    include(TEMPLATEPATH . '/category-a.php');
} 
?>