<?php
/**
 * 页脚模板
 */
?>
<!-- 页脚 -->
<footer class="footer theme-footer clear">
	<div class="footer-box">
    	<p class="copyright"><?php echo get_option('copyright'); ?></p>
        <a class="record" href="http://www.miitbeian.gov.cn/" target="_blank" rel="nofollow">粤ICP备16031950号-1</a>
    </div>
</footer>
<!-- /页脚 -->
</div>
<!-- 返回顶部 --> 
<a href="#" class="to-top theme-color-bg"><i class="fa fa-angle-up"></i></a>
<!-- /返回顶部 -->
<?php if (get_option('post_recommend')) { ?>
<!-- 文章随机推荐 -->
<div id="gg2" class="bottom-recommend">
	<div class="wp_close">
    	<a href="javascript:void(0)" onclick="$('#gg2').slideUp('slow');" title="关闭">×</a>
    	<div id="feedb">
            <a href="#" rel="nofollow" target="_blank" title="欢迎使用QQ邮箱订阅陈建杭个人博客" class="image">
                <img alt="订阅图标按钮" src="<?php bloginfo('template_directory'); ?>/images/feed.gif" style="width:23px;height:23px;" />
            </a>
        </div>
		<div class="bulletin">
            <ul>
				<?php
                wp_reset_query();
                query_posts(array('orderby' => 'rand', 'showposts' => 5, 'ignore_sticky_posts' => 10));
                while (have_posts()) : the_post();
                ?>
                <li>
                	<a href="<?php the_permalink(); ?>" target="_blank" title="细看 <?php the_title(); ?>">随机推荐：《<?php the_title(); ?>》</a>
                <?php
                if (function_exists('the_views')) {
                    print '( 阅读';the_views();
                    print '次 |</a>';
                }
                comments_popup_link('坐等沙发','1条评论','%条评论'); ?>)
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</div>
<!-- /文章随机推荐 -->
<?php } ?>

<!-- wp_footer -->
<?php wp_footer(); ?>
<!-- /wp_footer -->

<!-- 懒加载-->
<script src="<?php echo RES_PATH ?>/lib/lazyload/jquery.lazyload.min.js"></script>
<script>
$('#loading div').animate({'width':'80%'}, 50);  // 第四个节点

// 处理懒加载的图片
$("img").lazyload({
	effect: "fadeIn"
});
</script>
<script>
/* <![CDATA[ */
var ratingsL10n = {"plugin_url":"http:\/\/www.chenjianhang.com\/wp-content\/plugins\/wp-postratings","ajax_url":"http:\/\/www.chenjianhang.com\/wp-admin\/admin-ajax.php","text_wait":"Please rate only 1 post at a time.","image":"stars","image_ext":"gif","max":"5","show_loading":"1","show_fading":"1","custom":"0"};
var ratings_mouseover_image=new Image();ratings_mouseover_image.src=ratingsL10n.plugin_url+"/images/"+ratingsL10n.image+"/rating_over."+ratingsL10n.image_ext;;
/* ]]> */
</script>
<script src='http://www.chenjianhang.com/wp-content/plugins/wp-postratings/postratings-js.js?ver=1.83'></script>

<!-- 图片懒加载结束 -->
<script src="<?php echo RES_PATH ?>/js/posfixed.js"></script>
<script src="<?php echo RES_PATH ?>/js/common.js"></script>
<!--
<script src="<?php bloginfo('template_url'); ?>/js/myfix.js"></script>
-->
<script src="<?php bloginfo('template_url'); ?>/comments-ajax.js"></script>
<?php if (get_option('post_recommend')) { ?>
<script>
// 底部文章随机推荐
$(".bulletin").autoScroll({lineHeight: 25});
</script>
<?php } ?>
<?php
if (is_home()) {
?>
<script src="<?php echo RES_PATH ?>/js/slider.js"></script>
<script>

$(function() {
	var bannerSlider = new Slider($('#banner_tabs'), {
		onChange: onChange,
		time: 5000,
		delay: 400,
		event: 'hover',
		auto: true,
		mode: 'fade',
		controller: $('#bannerCtrl'),
		activeControllerCls: 'active'
	});
	$('#banner_tabs .flex-prev').click(function() {
		
		bannerSlider.prev()
		
	});
	$('#banner_tabs .flex-next').click(function() {
		bannerSlider.next()
	});
	$('#bannerCtrl').hide();
	$('#banner_tabs').hover(function() {
		$('#bannerCtrl').show();
	}, 
	function() {
		$('#bannerCtrl').hide();
	});
	$('#text-all').children().each(function(index, element) {
        $(element).hide();
    });
	$('#text-all').children().eq(0).show();
	
	function onChange(index) {
		$('#text-all').children().each(function(index, element) {
			$(element).hide();
		});
		$('#text-all').children().eq(index).show();
	}

	// 适配当前屏幕大小
	resize();
	
	// 窗口大小改变时，网页重新适配窗口
	$(window).resize(function() {
		resize();
	});

});
/* 适配当前屏幕大小 */
function resize() {
	var height = $('#banner_tabs').width() * 0.618;
	if (height > 500) {
		height = 500;
	}
	$('#banner_tabs').height(height);
	
}

</script>	
<?php } ?>

<?php if (get_option('show_click_count')) { ?>
<script>
// 点击特效
var clickCount = 0;
$('body').bind('click', function(e) { 
	//var n = Math.round(Math.random() * 100); // 随机数
	var $i = $("<b>").text('+' + (++clickCount)); // 添加到页面的元素
	var x = e.pageX, y = e.pageY; // 鼠标点击的位置
	$i.css({
		'z-index': 99999,
		'top': y - 15,
		'left': x,
		'position': 'absolute',
		'color': '#fe787c'
	});
	$('body').append($i);
	$i.animate(
		{'top': y - 180, 'opacity': 0},
		1500,
		function() { $i.remove(); }
	);
	//e.stopPropagation();
});
</script>
<?php } ?>

<?php if (get_option('show_snow')) { ?>
<script>
// 下雪特效
(function(a){a.fn.snow=function(d){var g=a('<div id="snowbox" />').css({position:"absolute","z-index":"9999",top:"-50px"}).html("&#10052;"),f=a(document).height(),b=a(document).width(),e={minSize:10,maxSize:20,newOn:1000,flakeColor:"#FFF"},d=a.extend({},e,d);var c=setInterval(function(){var l=Math.random()*b-100,j=0.5+Math.random(),h=d.minSize+Math.random()*d.maxSize,i=f-200,k=l-500+Math.random()*500,m=f*10+Math.random()*5000;g.clone().appendTo("body").css({left:l,opacity:j,"font-size":h,color:d.flakeColor}).animate({top:i,left:k,opacity:0.2},m,"linear",function(){a(this).remove()})},d.newOn)}})(jQuery);$(function(){$.fn.snow({minSize:5,maxSize:50,newOn:300})});
</script>
<?php } ?>

<?php if (get_option('prevent_copy')) { ?>
<script>
// 屏蔽复制
document.addEventListener('copy', function(e) {
	e.preventDefault();
	if (e.clipboardData) {  
		e.clipboardData.setData("text/html", ''); 
		e.clipboardData.setData("text/plain", '');
	} else if (window.clipboardData) {  
		return window.clipboardData.setData("text", '');  
	}  
});
</script>
<?php } ?>

<?php if (get_option('copy_tip')) { ?>
<script>
// 复制时弹窗显示版权声明信息
document.body.oncopy = function() {
	alert("复制成功！若要转载请务必保留原文链接，申明来源，谢谢合作！");
}
</script>
<?php } ?>

<script src="<?php echo RES_PATH ?>/lib/highslide/highslide.js"></script>
<script>
jQuery(document).ready(function($) {
    hs.graphicsDir = "<?php echo RES_PATH ?>/lib/highslide/graphics/";
    hs.outlineType = "rounded-white";
    hs.dimmingOpacity = 0.8;
    hs.outlineWhileAnimating = true;
    hs.showCredits = false;
    hs.captionEval = "this.thumb.alt";
    hs.numberPosition = "caption";
    hs.align = "center";
    hs.transitions = ["expand", "crossfade"];
    hs.addSlideshow({
        interval: 5000,
        repeat: true,
        useControls: true,
        fixedControls: "fit",
        overlayOptions: {
            opacity: 0.75,
            position: "bottom center",
            hideOnMouseOut: true
 
        }
 
    });
});
</script>
<script type="text/javascript">  
/* 
var documentHeight = 0;   
var topPadding = 130;   
$(function() {   
    var offset = $("#sidebar-bottom").offset();   
    documentHeight = $(document).height(); 
	$(".follow").css('width', $("#sidebar").width());
    $(window).scroll(function() {   
        var sideBarHeight = $("#sidebar-bottom").height();   
        if ($(window).scrollTop() > offset.top) {   
            var newPosition = ($(window).scrollTop() - offset.top) + topPadding;   
            var maxPosition = documentHeight - (sideBarHeight + 200);   
            if (newPosition > maxPosition) {   
                newPosition = maxPosition;   
            }   
            $("#sidebar-bottom").stop().animate({   
                marginTop: newPosition   
            });   
			$(".follow").show();
        } else {   
            $("#sidebar-bottom").stop().animate({   
                marginTop: 0   
            }); 
			
			$(".follow").hide(); 
        };   
    });   
});
*/   
</script>
<script>
$('#loading div').animate({'width':'100%'}, 50, function() {$("#loading").fadeOut();});  // 第五个节点
</script>

</body>


</html>