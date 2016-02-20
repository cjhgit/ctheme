<?php
/**
 * 高级设置页面
 */
?>
<div class="wrap">
    <h2>高级2设置</h2>
    <form method="POST" action="">
    <input type="hidden" name="update_options" value="true" />
     
    <table class="form-table">
    <tbody>
    <tr valign="top">
    <th scope="row">选择文章分类</th>
    <td>
    <?php wp_dropdown_categories(array('name' =>'categories-demo','hide_empty' => 0,'orderby' => 'name','show_count' => 1,'selected' =>get_option('categories-demo'),'hierarchical' => true,'show_option_none' =>'全部分类','echo' => 1)); ?>
    </td>
    </tr>
    <tr valign="top">
    <th scope="row">选择页面</th>
    <td><?php wp_dropdown_pages(array('name' =>'pages-demo')); ?></td>
    </tr>
    <tr valign="top">
    <th scope="row">图片选择&图片上传</th>
    <td><input type="text" name="upload-demo" value="<?php echo get_option('upload-demo'); ?>"/><a id="upload-demo" class="cp_upload_button button" href="#">上传</a></td>
    </tr>
    </tbody>
    </table>
    <p><input type="submit" class="button-primary" name="admin_options" value="更新数据"/></p>
    </form>
    </div>
    <?php wp_enqueue_media(); ?> <!-- 必须 -->
    <script>
    //调用媒体库上传图片
    jQuery(document).ready(function(){
    var upload_frame;
    var value_id;
    jQuery('.cp_upload_button').live('click',function(event){
    value_id =jQuery( this ).attr('id');
    event.preventDefault();
    if( upload_frame ){
    upload_frame.open();
    return;
    }
    upload_frame = wp.media({
    title: '选择图片',
    button: {
    text: '插入',
    },
    multiple: false
    });
    upload_frame.on('select',function(){
    attachment = upload_frame.state().get('selection').first().toJSON();
    jQuery('input[name='+value_id+']').val(attachment.url);
    //jQuery('img').attr("src",attachment.url);//图片预览
    });
     
    upload_frame.open();
    });
    });
    </script>