<?php
/**
 * 小工具（小插件）相关的函数
 */
 
require get_template_directory() . '/widgets/widget_hamster.php';
require get_template_directory() . '/widgets/widget_statistics.php';
require get_template_directory() . '/widgets/widget_ad.php';
require get_template_directory() . '/widgets/widget_comment.php';
require get_template_directory() . '/widgets/cat_posts-news-fix.php';
require get_template_directory() . '/widgets/widget_notice.php';
require get_template_directory() . '/widgets/widget_catalog.php';
require get_template_directory() . '/widgets/widget_post.php';
require get_template_directory() . '/widgets/widget_tag.php';
require get_template_directory() . '/widgets/widget_user.php';
require get_template_directory() . '/widgets/widget_about.php';

// 去掉系统自带的小工具
function unregister_d_widget() {
    //unregister_widget('WP_Widget_Search');
    //unregister_widget('WP_Widget_Recent_Comments');
    //unregister_widget('WP_Widget_Tag_Cloud');
    //unregister_widget('WP_Nav_Menu_Widget');
}

add_action('widgets_init','unregister_d_widget');
?>