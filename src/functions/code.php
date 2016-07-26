<?php
/**
 * 代码段
 */

add_action('init', 'my_custom_post_code');

function my_custom_post_code() {
  $labels = array(
    'name'               => _x( '代码', 'post type 名称' ),
    'singular_name'      => _x( 'State', 'post type 单个 item 时的名称，因为英文有复数' ),
    'add_new'            => _x( '添加代码', '添加新内容的链接名称' ),
    'add_new_item'       => __( '新建一条代码' ),
    'edit_item'          => __( '编辑代码' ),
    'new_item'           => __( '新代码' ),
    'all_items'          => __( '所有代码' ),
    'view_item'          => __( '查看代码' ),
    'search_items'       => __( '搜索代码' ),
    'not_found'          => __( '没有找到有关代码' ),
    'not_found_in_trash' => __( '回收站里面没有相关代码' ),
    'parent_item_colon'  => '',
    'menu_name'          => '代码'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => '我们网站的代码',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array('title', 'editor', 'thumbnail', 'comments'), //, 'excerpt'
    'has_archive'   => true
  );
  register_post_type('code', $args);
}

?>