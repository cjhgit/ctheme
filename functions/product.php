<?php

// 创建一个产品类型
add_action('init', 'my_custom_post_product');

function my_custom_post_product() {
  $labels = array(
    'name'               => _x( '商品', 'post type 名称' ),
    'singular_name'      => _x( 'Product', 'post type 单个 item 时的名称，因为英文有复数' ),
    'add_new'            => _x( '添加商品', '添加新内容的链接名称' ),
    'add_new_item'       => __( '新建一个商品' ),
    'edit_item'          => __( '编辑商品' ),
    'new_item'           => __( '新商品' ),
    'all_items'          => __( '所有商品' ),
    'view_item'          => __( '查看商品' ),
    'search_items'       => __( '搜索商品' ),
    'not_found'          => __( '没有找到有关商品' ),
    'not_found_in_trash' => __( '回收站里面没有相关商品' ),
    'parent_item_colon'  => '',
    'menu_name'          => '商品'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => '我们网站的商品信息',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array('title', 'editor', 'thumbnail', 'comments'), //, 'excerpt'
    'has_archive'   => true
  );
  register_post_type('product', $args);
}

// 添加分类的功能
add_action('init', 'product_classify', 0);

function product_classify() {
  $labels = array(
    'name'              => _x( '商品分类', 'taxonomy 名称' ),
    'singular_name'     => _x( '商品分类', 'taxonomy 单数名称' ),
    'search_items'      => __( '搜索商品分类' ),
    'all_items'         => __( '所有商品分类' ),
    'parent_item'       => __( '该商品分类的上级分类' ),
    'parent_item_colon' => __( '该商品分类的上级分类：' ),
    'edit_item'         => __( '编辑商品分类' ),
    'update_item'       => __( '更新商品分类' ),
    'add_new_item'      => __( '添加新的商品分类' ),
    'new_item_name'     => __( '新商品分类' ),
    'menu_name'         => __( '商品分类' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy('product_category', 'product', $args );
}

// 添加价格
add_action('add_meta_boxes', 'product_price');

function product_price() {
    add_meta_box(
        'product_price',
        '商品价格',
        'product_price_meta_box',
        'product',
        'normal', // ('normal', '默认advanced', or 'side')
        'high'	// ('high', 'core', 'default' or 'low')
    );
}

function product_price_meta_box($post) {
    // 创建临时隐藏表单，为了安全
    wp_nonce_field('product_price_meta_box', 'product_price_meta_box_nonce');
    // 获取之前存储的值
    $value = get_post_meta( $post->ID, '_product_price', true );

    ?>

    <label for="product_price"></label>
    <input type="text" id="product_price" name="product_price" value="<?php echo esc_attr( $value ); ?>" placeholder="输入商品价格" >

    <?php
}

// 保存价格
add_action('save_post', 'product_price_save_meta_box');

function product_price_save_meta_box($post_id) {
    // 安全检查
    // 检查是否发送了一次性隐藏表单内容（判断是否为第三者模拟提交）
    if (!isset( $_POST['product_price_meta_box_nonce'])) {
        return;
    }
    // 判断隐藏表单的值与之前是否相同
    if (!wp_verify_nonce( $_POST['product_price_meta_box_nonce'], 'product_price_meta_box' )) {
        return;
    }
    // 判断该用户是否有权限
    if (!current_user_can( 'edit_post', $post_id )) {
        return;
    }

    // 判断 Meta Box 是否为空
    if (!isset( $_POST['product_price'])) {
        return;
    }

    $movie_director = sanitize_text_field($_POST['product_price']);
    update_post_meta($post_id, '_product_price', $movie_director);
}

// 在商品列表中显示价格字段
add_action("manage_posts_custom_column",  "product_custom_columns");

function product_custom_columns($column) {
    global $post;
    switch ($column) {
        case "product_price":
            echo get_post_meta( $post->ID, '_product_price', true );
            break;
		default:
			break;
    }
}

add_filter("manage_edit-product_columns", "product_edit_columns");

function product_edit_columns($columns){
    $columns['product_price'] = '价格（￥）';
    return $columns;
}

add_filter('post_type_link', 'custom_book_link', 1, 3);
function custom_book_link( $link, $post = 0 ){
    if ($post->post_type == 'product') {
        return home_url( 'product/' . $post->ID .'.html' );
    } else {
        return $link;
    }
}

add_action('init', 'custom_book_rewrites_init');

function custom_book_rewrites_init(){
    add_rewrite_rule(
        'product/([0-9]+)?.html$',
        'index.php?post_type=product&p=$matches[1]',
        'top' );
}
?>