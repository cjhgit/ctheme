<?php 
/**
 * 主题设置项更新页面
 */
     
// 成功提示
define('SuccessInfo','<div class="updated"><p><strong>设置已保存。</strong></p></div>');
 
require_once(get_template_directory().'/inc/base.php');
require_once(get_template_directory().'/inc/page_view.php');



// SEO设置
function seoSetting() {
	if ($_POST['update_options']=='true') {
		// 数据更新验证
		update_option('web_desc', $_POST['web_desc']); // 网站描述
		update_option('keywords', $_POST['keywords']); // 关键词
		echo SuccessInfo;
	}
	require_once(get_template_directory() . '/inc/page_seo.php');
	add_action('admin_menu', 'seoSetting');
}

// 高级设置
function AdvancedSettings() {
if ($_POST['update_options']=='true') {
	update_option('categories-demo', $_POST['categories-demo']); //Categories
	update_option('pages-demo', $_POST['pages-demo']); //Pages
	update_option('upload-demo', $_POST['upload-demo']); //Upload
	echo SuccessInfo;
}
require_once(get_template_directory().'/inc/advanced.php'); //代码解耦
add_action('admin_menu', 'AdvancedSettings');
}
  
function outputHtml($options) {
	foreach ($options as $opt) {
		echo '<tr valign="top">';
		if ($opt['type'] == 'title') {
			echo '<th scope="row"><h3>' . $opt['label'] . '</h3></th>';
		} else {
			echo '<th scope="row"><label for="' . $opt['id'] . '">' . $opt['label'] . '</label></th>';
		}
    	
        echo '<td>';
		switch ($opt['type']) {
		case 'text':
			echo '<input type="'.$opt['type'].'" class="regular-text" name="'.$opt['id'].'" value="' . get_option($opt['id']) . '" />';
			echo '<p class="description">'.$opt['desc'].'</p>';
			break;	
		case 'textarea':
			$text = get_option($opt['id']);
			echo<<<HTML
			<textarea class="large-text" name="{$opt['id']}">{$text}</textarea>
            <p class="description">{$opt['desc']}</p>
HTML;
			break;
		case 'radio':
			for ($i = 0, $length = count($opt['options']); $i < $length; $i++) {
				$checked = get_option('themes') == $i ? 'checked="true"' : '';
				echo<<<INPUT
				<input type="{$opt['type']}" {$checked} name="{$opt['id']}" value="{$i}" />{$opt['options'][$i]} <br/>
INPUT;
				
			}
			echo '<p class="description">'.$opt['desc'].'</p>';
			break;
		case 'checkbox':
			$check = get_option($opt['id']) ? 'checked' : '';
			echo '<input type="checkbox" name="'.$opt['id'].'"' . $check . ' />' 
				. $opt['desc'];
			break;
		case 'title':
			// do nothing
			break;
		default:
			echo '类型错误（请开发者修改代码）';
			break;
		}
	
		/*
		if ($opt['type'] == 'text') {
			
			
			echo '<input type="'.$opt['type'].'" class="re$checkgular-text" name="'.$opt['id'].'" value="' . get_option($opt['id']) . '" />';
			echo '<p class="description">'.$opt['desc'].'</p>';
            
		} else if ($opt['type'] == 'textarea') {
			$text = get_option($opt['id']);
			echo<<<HTML
			<textarea class="large-text" name="{$opt['id']}">{$text}</textarea>
            <p class="description">{$opt['desc']}</p>
HTML;
		} else if ($opt['type'] == 'radio') {
			
			
			for ($i = 0, $length = count($opt['options']); $i < $length; $i++) {
				$checked = get_option('themes') == $i ? 'checked="true"' : '';
				echo<<<INPUT
				<input type="{$opt['type']}" {$checked} name="{$opt['id']}" value="{$i}" />{$opt['options'][$i]} <br/>
INPUT;
				
			}
			echo '<p class="description">'.$opt['desc'].'</p>';
			
		} else if ($opt['type'] == 'checkbox') {
			$check = get_option($opt['id']) ? 'checked' : '';
			echo '<input type="checkbox" name="'.$opt['id'].'"' . $check . ' />' 
				. $opt['desc'];
		} else if ($opt['type'] == 'title') {
			// do nothing
		} else {
			echo '类型错误';
		}
		*/
        echo '</td>';
    	echo '</tr>';
		
	} 
}

?>