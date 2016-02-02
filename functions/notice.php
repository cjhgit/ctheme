<?php

// 创建一个公告类型
add_action('init', 'registerNoticeType');

function registerNoticeType() {
  $labels = array(
    'name'               => _x( '公告', 'post type 名称' ),
    'singular_name'      => _x( 'State', 'post type 单个 item 时的名称，因为英文有复数' ),
    'add_new'            => _x( '添加公告', '添加新内容的链接名称' ),
    'add_new_item'       => __( '新建一条公告' ),
    'edit_item'          => __( '编辑公告' ),
    'new_item'           => __( '新公告' ),
    'all_items'          => __( '所有公告' ),
    'view_item'          => __( '查看公告' ),
    'search_items'       => __( '搜索公告' ),
    'not_found'          => __( '没有找到有关公告' ),
    'not_found_in_trash' => __( '回收站里面没有相关公告' ),
    'parent_item_colon'  => '',
    'menu_name'          => '公告'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => '我们网站的公告',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array('title', 'editor', 'thumbnail', 'comments'), //, 'excerpt'
    'has_archive'   => true
  );
  register_post_type('notice', $args);
}

?>