<?php
/**
 * 文章列表相关的函数
 */

// 更改文章摘录的长度
function custom_excerpt_length($length) {
    return 100;
}

add_filter('excerpt_length', 'custom_excerpt_length', 999);

// 更改系统默认设置更多样式
add_filter('excerpt_more', 'custom_excerpt_more');

function custom_excerpt_more($more) {
    return '...';
}

/* 根据文章对象获取文章图片 */
function getImageByPost($post) {
	$cate = get_the_category();
			//echo $cate[0]->cat_ID;
			//$post->post_parent->term_id
	if (has_post_thumbnail($post->ID)) {
		$image= wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
		$image = $image[0];
		return $image;
	} elseif (strlen($catImageUrl = getCategoryImage($cate[0]->cat_ID)) > 0) {
		return $catImageUrl;
	} elseif (strlen(getFirstImage($post->ID)) > 0) {
		$image= getFirstImage($post->ID);
		return $image;
	} else {
		
		$theme = get_option('themes');
		if ($theme == '10') {
			return get_stylesheet_directory_uri() . '/images/themes/post-default10.jpg';
		} elseif ($theme == 11) {
			return get_stylesheet_directory_uri() . '/images/themes/post-default11.jpg';
		} elseif ($theme == 12) {
			return get_stylesheet_directory_uri() . '/images/themes/post-default12.jpg';
		} else {
			return get_stylesheet_directory_uri() . '/images/themes/post-default10.jpg'; // TODO
		}
		
	}
}

function getCategoryImage($categoryId) {
	return z_taxonomy_image_url($categoryId);
	//return get_option('_category_image' . $categoryId);
}

// 文章缩略图
if (function_exists('add_theme_support')) {
	add_theme_support( 'post-thumbnails');
}

/* 获取文章里面的第一个图片 */
function getFirstImage($postId) {
	$args = array(
		'numberposts' => 1,
		'order'=> 'ASC',
		'post_mime_type' => 'image',
		'post_parent' => $postId,
		'post_status' => null,
		'post_type' => 'attachment'
		);
	$attachments = get_children($args);
	
	// 如果没有上传图片, 返回空字符串
	if (!$attachments) {
		return '';
	}
	
	// 获取缩略图中的第一个图片, 并组装成 HTML 节点返回
	$image = array_pop($attachments);
	$imageSrc = wp_get_attachment_image_src($image->ID, 'thumbnail');
	$imageUrl = $imageSrc[0];
	$html = '<img src="' . $imageUrl . '" alt="' . the_title('', '', false) . '" />';
	
	return $imageUrl;
}

/*
 * 获取文章缩略图
 * $size: thumbnail:缩略图 medium：中图 large：大图 full：原图
 */
function get_post_thumbnail_url($post_id,$size) {
	$post_id = (null == $post_id ) ? get_the_ID() : $post_id;
	$thumbnail_id = get_post_thumbnail_id($post->ID);
	if ($thumbnail_id) {
		$thumb = wp_get_attachment_image_src($thumbnail_id, $size);
		return $thumb[0];
	} else {
		return false;
	}
}

/** 页码函数 */   
function wp_pagenavi() {   
    // 先申明两个全局变量   
    global $wp_query, $wp_rewrite;   
    // 判断当前页面   
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;   
       
    $pagination = array(   
        'base' => @add_query_arg('paged','%#%'),   
        'format' => '',   
        'total' => $wp_query->max_num_pages,   
        'current' => $current,   
        'show_all' => false,   
        'type' => 'plain',   
        'end_size' => '1',   
        'mid_size' => '3',   
        'prev_text' => '上一页',   
        'next_text' => '下一页'   
    );   
       
    if ($wp_rewrite->using_permalinks()) {   
        $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged'); 
	}
    if (!empty($wp_query->query_vars['s'])) {   
        $pagination['add_args'] = array('s'=>get_query_var('s'));
	}
    echo paginate_links($pagination);   
}

/* 设置每页显示的文章数 */
/*
function custom_pre_get_posts($query) {
    if (is_home()) {
		$query->set('posts_per_page', 10); // 首页每页显示10篇文章（不分页则设为-1）
	} else {
		$query->set('posts_per_page', 20); // 其他页每页显示20篇文章
	}
}
*/
//add_action('pre_get_posts', 'custom_pre_get_posts');

?>