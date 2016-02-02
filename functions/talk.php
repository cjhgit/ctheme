<?php

// 创建一个产品类型
add_action('init', 'my_custom_post_state');

function my_custom_post_state() {
  $labels = array(
    'name'               => _x( '说说', 'post type 名称' ),
    'singular_name'      => _x( 'State', 'post type 单个 item 时的名称，因为英文有复数' ),
    'add_new'            => _x( '添加说说', '添加新内容的链接名称' ),
    'add_new_item'       => __( '新建一条说说' ),
    'edit_item'          => __( '编辑说说' ),
    'new_item'           => __( '新说说' ),
    'all_items'          => __( '所有说说' ),
    'view_item'          => __( '查看说说' ),
    'search_items'       => __( '搜索说说' ),
    'not_found'          => __( '没有找到有关说说' ),
    'not_found_in_trash' => __( '回收站里面没有相关说说' ),
    'parent_item_colon'  => '',
    'menu_name'          => '说说'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => '我们网站的说说',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array('title', 'editor', 'thumbnail', 'comments'), //, 'excerpt'
    'has_archive'   => true
  );
  register_post_type('state', $args);
}

?>