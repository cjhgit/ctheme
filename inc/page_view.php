<?php
/**
 * 界面设置页面
 */
 


// 界面设置
function viewSetting() {

$options = array(
    //开始第一个选项标签
	/*
    array(
        'title' => '常规选项',
        'type'  => 'title' // 
    ), 
	*/
	array(
        'label'  => '选择主题',
		'type'  => 'radio',
		'id'    => "themes",
        'desc'  => '选择一个色调作为您网站的主色调，如果这里的色彩还不够，您可以使用下面的自定义色彩',
        'options' => array(
            '默认（程序猿主题）',
            '蓝色经典',
            '绿色生机',
            '紫色高雅',
            '灰色稳重', 
            '红色喜庆',
            '粉红回忆',
            '碧蓝色',
            '黄色',
            '橙色',
            '文艺',
            '小清新',
            '喵星人',
			'简约',
			'极简',
        ),
    ),
	array(
        'label' => '主题颜色',
        'type' => 'text',
		'id' => 'theme_color',
		'desc' => '格式：#xxx或xxxxxxx，界面整体颜色，设置不好会影响整个网站的整体风格。',
    ),
	array(
        'label' => '主题搭配颜色',
        'type' => 'text',
		'id' => 'theme_color2',
		'desc' => '导航栏下拉菜单的子菜单背景颜色',
    ),
	array(
        'label' => '主题超链接颜色',
        'type' => 'text',
		'id' => 'theme_a_color',
    ),
	
	array(
        'label' => '背景颜色',
        'type' => 'text',
		'id' => 'bg_color',
		'desc' => '常用颜色：#eee，有背景图片时会被覆盖。',
    ),
	array(
        'label' => '背景图片',
        'type' => 'textarea',
		'id' => 'bg_image',
		'desc' => '会覆盖背景颜色。',
    ),
	array(
        'label' => '导航栏背景颜色',
        'type' => 'text',
		'id' => 'nav_bg_color',
		'desc' => '',
    ),
	array(
        'label' => '头部设置',
        'type' => 'title',
    ),
	array(
        'label' => '网站头部高度',
        'type' => 'text',
		'id' => 'header_height',
		'desc' => '单位px',
    ),
	array(
        'label' => '头部背景图片',
        'type' => 'textarea',
		'id' => 'header_image',
		'desc' => '会覆盖头部背景颜色。',
    ),
	array(
        'label' => '头部背景固定',
        'type' => 'checkbox',
		'id' => 'header_bg_fixed',
		'desc' => '开启 【开启后，头部背景图片高度不能伸缩适应，请在上面的头部高度输入框里填写头部背景图片的高度。】',
    ),
	array(
        'label' => '头部文字颜色',
        'type' => 'text',
		'id' => 'header_text_color',
		'desc' => '',
    ),
	
	array(
        'label' => '页脚背景颜色',
        'type' => 'text',
		'id' => 'footer_bg_color',
		'desc' => '',
    ),
	array(
        'label' => '网站宽度',
        'type' => 'text',
		'id' => 'max_width',
		'desc' => '单位px，默认1250px',
    ),
	array(
        'label' => '评论设置',
        'type' => 'title',
    ),
	array(
        'label' => '评论输入框显示的文字',
        'type' => 'text',
		'id' => 'comment_text',
		'desc' => '如：大侠，请留步，关于这篇文章，说点什么吧！',
    ),
	array(
        'label' => '特效设置',
        'type' => 'title',
    ),
	array(
        'label' => '飘雪特效',
        'type' => 'checkbox',
		'id' => 'show_snow',
		'desc' => '开启 【开启后会有点影响性能，不过影响不大】',
    ),
	array(
        'label' => '网页点击特效',
        'type' => 'checkbox',
		'id' => 'show_click_count',
		'desc' => '开启 【开启后点击网页任意位置就可以看到效果了。没卵用，无聊时做着玩玩的。】',
    ),
	
);

	if ($_POST['update_options']=='true') {
		
		
		foreach ($options as $opt) {
			if ($opt['type'] == 'checkbox') {
				$display = $_POST[$opt['id']] == 'on' ? true : false;
				update_option($opt['id'], $display);
			} else {
				update_option($opt['id'], $_POST[$opt['id']]);	
			}
		}

		echo SuccessInfo;
	}
	if ($_POST['update_options2']=='true') {
		update_option('post_recommend', $_POST['post_recommend']);
		
		
		echo SuccessInfo;
	}
	?>
    
    
    <div class="wrap">
    <h2>界面设置</h2><span>更多主题，请访问<a href="http://www.chenjianhang.com/" target="_blank">陈建杭个人博客</a></span>
    <form method="POST" action="">
    <input type="hidden" name="update_options" value="true" />
    <table class="form-table">
    <tbody>
    
    <?php
	outputHtml($options);
	?>

    </tbody>
    </table>
    <p><input type="submit" class="button-primary" name="admin_options" value="更新数据"/></p>
    </form>



	<h2>功能设置</h2>
    <form method="POST" action="">
    <input type="hidden" name="update_options2" value="true" />
    <table class="form-table">
    <tbody>

   <?php
   //echo 'PHP版本' . phpinfo();
   $check = get_option('post_recommend') ? 'checked' : '';
   ?>
    <tr valign="top">
        <th scope="row"><label for="d_hamster">底部文章随机推荐</label></th>
        <td><input type="checkbox" name="post_recommend" <?php echo $check; ?> /> 开启</td>
    </tr>
    </tbody>
    </table>
    <p><input type="submit" class="button-primary" name="admin_options" value="更新数据"/></p>
    </form>
</div>
    
    
    <?php
	add_action('admin_menu', 'viewSetting');
}
?>

