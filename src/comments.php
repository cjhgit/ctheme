<?php
/**
 * 评论模板（如果使用了社会化评论插件（比如多说），此模板会无效）
 */

if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
	die('Please do not load this page directly. Thanks!');
}
	

?>

<!–- 评论开始 -–>
<h3 class="big-title theme-color-bg">评论</h3>
<ul class="comment-list">
<?php 
// if there's a password and it doesn't match the cookie
if (!empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {
	echo<<<LI
	<li class="decmt-box">
		<p><a href="#addcomment">请输入密码再查看评论内容.</a></p>
	</li>
LI;
} else if ( !comments_open() ) {
	echo<<<LI
	<li class="decmt-box">
		<p><a href="#addcomment">评论功能已经关闭!</a></p>
	</li>
LI;
} else if ( !have_comments() ) { 
	echo<<<LI
	<li class="decmt-box">
		<p><a href="#addcomment">还没有任何评论，你来说两句吧</a></p>
	</li>
LI;

} else {
	wp_list_comments('type=comment&callback=aurelius_comment'); // 输出评论列表
	?>
    <div id="comments-nav">
	<?php paginate_comments_links('prev_text=上一页&next_text=下一页');?>
	</div>
    <?php
	
}
?>
</ul>
<!-- 评论结束 -->
<?php 
if (comments_open()) {
	if (get_option('comment_registration') && !$user_ID ) {
		$url = get_option('siteurl') . "/wp-login.php?redirect_to=" . urlencode(get_permalink());
		echo '<p>你需要先 <a href="' . $url . '">登录</a> 才能发表评论.</p>';
	} else {	
		$defaults = array( 
            'comment_notes_before' => '',   
            'label_submit'         => __( '提交评论' ),   
            'comment_notes_after' =>''  
        );   
        //include(TEMPLATEPATH . '/smiley.php'); 
        //comm_smilies();
        //comment_form($defaults);    
		?>
        <!-- 评论表单开始 -->
        <div id="respond" class="comment-respond">
            <h3 id="reply-title" class="comment-reply-title">发表评论 
                <small><a rel="nofollow" id="cancel-comment-reply-link" href="/1197.html#respond" style="display:none;">取消回复</a></small>
            </h3>
            <form action="http://www.chenjianhang.com/wp-comments-post.php" method="post" id="commentform" class="comment-form">
            	
                <?php 
					global $current_user;
					get_currentuserinfo();
					if (is_user_logged_in()) { 
						echo get_avatar( $current_user->user_email, $size = '54' , deel_avatar_default() );
					} elseif (get_option('require_name_email') && $comment_author_email=='' ) {
						echo get_avatar( $current_user->user_email, $size = '54' , deel_avatar_default() );
					} elseif(get_option('require_name_email') && $comment_author_email!=='' )  {
						echo get_avatar( $comment->comment_author_email, $size = '54' , deel_avatar_default() );
					}

				?>
                
                <?php 
					if (is_user_logged_in()) {
						printf($user_identity.'<span>发表我的评论</span>');
						?>
                        <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="退出"><?php print ' 退出'; ?></a>
                        <?php
					} else {
						if (get_option('require_name_email') && !empty($comment_author_email)) {
							printf($comment_author.' <span>发表我的评论</span> &nbsp; <a class="switch-author" href="javascript:;" data-type="switch-author" style="font-size:12px;">换个身份</a>');
						}
					}
					
				?>
            
            	<?php 
				if (!is_user_logged_in()) {
				?>
                <p class="comment-form-author">
                    <label for="author">姓名 <span class="required">*</span></label>                        <input id="author" name="author" type="text" value="<?php echo esc_attr($comment_author); ?>" size="30" aria-required='true' required='required' />
                </p>
                <p class="comment-form-email">
                    <label for="email">电子邮件 <span class="required">*</span></label> 
                    <input id="email" name="email" type="text" value="<?php echo esc_attr($comment_author_email); ?>" size="30" aria-describedby="email-notes" aria-required='true' required='required' placeholder="不会被公布" /></p>
                <p class="comment-form-url">
                    <label for="url">站点</label>
                    <input id="url" name="url" type="text" value="<?php echo esc_attr($comment_author_url); ?>" size="30" />
                </p>
               
                
                <?php 
				}
				?>
                 <p class="comment-form-comment">
                    <textarea id="comment" name="comment" rows="3" aria-describedby="form-allowed-tags" aria-required="true" required class="theme-color-border" placeholder="<?php echo get_option('comment_text'); ?>"></textarea>
                </p>
                <div id="show-expression">
                    <i class="fa fa-smile-o"></i> 表情
                </div>
                <div id="expression-box" class="expression-box">
                    <?php
                    output_smilies(); // 输出表情
                    ?>
                </div>
                <div id="it"></div>
                <p class="form-submit">
                    <input name="submit" type="submit" id="submit" class="submit theme-color-bg" value="提交评论" /> <input type='hidden' name='comment_post_ID' value='<?php echo $post->ID; ?>' id='comment_post_ID' />
                    <input type='hidden' name='comment_parent' id='comment_parent' value='0' />
                </p>					
            </form>
        </div>
        <!-- 评论表单结束 -->     
        <?php  
	}
} else {
	echo '<p>对不起评论已经关闭</p>';
}


?>  
