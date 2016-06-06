// 返回顶部小插件
(function($) {
    
    $.fn.backToTop = function(options) {
 		
		var defaults = {
			topOffset: 300, // 开始显示返回顶部链接时与页面顶部的距离（像素）
			opacityOffset: 1200, // 开始变半透明时与页面顶部的距离（像素）
			duration: 700, // 返回顶部滚动的时间(ms)
		};
		var opts = $.extend(defaults, options);
		
        var $elem = $(this); // 返回顶部链接
        
        // 隐藏或显示返回顶部链接
        $(window).scroll(function() {
            if ($(this).scrollTop() > opts.topOffset) {
				$elem.show();
				//$elem.css('
                //$elem.addClass('cd-is-visible')
            } else {
                //$elem.removeClass('cd-is-visible cd-fade-out');
				$elem.hide();
            }
          
            if ($(this).scrollTop() > opts.opacityOffset) { 
                //$elem.addClass('cd-fade-out');
            }
        });
        
        // 平滑返回顶部
        $elem.on('click', function(event) {
            event.preventDefault();
            $('body,html').animate({
                scrollTop: 0 ,
                }, 
                opts.duration
            );
        });
 
        return this;
    }
})(jQuery);

// 滚动公告小插件
(function($) {
    $.fn.autoScroll = function(options) {
        var defaults = {
			duration: 4000, // 相邻两次滚动的间隔时间（ms）
			speed: 500, // 滚动一次的时间（ms）
			lineHeight: 0, // 每条公告的高度
			line: 1, // 每次滚动的行数（功能未实现）
		};
		var opts = $.extend(defaults, options);
		var elem = $(this);
		
		var lineHeight = (opts.lineHeight == 0) ? elem.find('ul:first').height() : opts.lineHeight; // 每条公告的高度
		
        function scrollAuto() {
			elem.find('ul:first').animate(
				{ marginTop: '-' + lineHeight + 'px' },
				opts.speed, 
				function() { 
					$(this).css({marginTop:'0px'}).find('li:first').appendTo(this); 
				}
			); 
		}
		
		// 鼠标指向公告时停止滚动
		var timerId;
		elem.hover(function() {
			clearInterval(timerId);
		}, function() {
			timerId = setInterval(scrollAuto, opts.duration); 
		});
		timerId = setInterval(scrollAuto, opts.duration); 
		
        return this;
    }
    
})(jQuery);

$(document).ready(function($) {

// 顶部公告自动滚动
$('#notice').autoScroll({lineHeight: 25});

// 返回顶部
$('.to-top').backToTop();

var isShow = false; // 菜单是否显示

// 点击遮罩层隐藏菜单
$('#mask').on('click', function(e) {
	$("#mask").hide(0.8);
	$('#nav').css('right', '-70%');
	isShow = false;
});

// 点击菜单按钮，显示/隐藏菜单
$('#menu-btn').on('click', function(e) {
	if (isShow) {
		$("#mask").hide(0.8);
		$('#nav').css('right', '-70%');
	} else {
		$("#mask").show();
		$('#nav').css('right', '0');
	}
	isShow = !isShow;
});

// 侧栏悬停（因为代码可能出问题，放在最后^_^）
//$('#sidebar').myFix();
	
// 文章顶
$.fn.postLike = function() {
	if ($(this).hasClass('done')) {
		alert('您已赞过该文章');
		return false;
	} else {
		$(this).addClass('done');
		var id = $(this).data("id"),
		action = $(this).data('action'),
		rateHolder = $(this).children('.count');
		var ajax_data = {
			action: "specs_zan",
			um_id: id,
			um_action: action
		};
		$.post("/wp-admin/admin-ajax.php", ajax_data,
		function(data) {
			$(rateHolder).html(data);
		});
		return false;
	}
};

$(document).on("click", "#post-like",
	function() {
		$(this).postLike();
	}
);

// 文章踩

$.fn.postDislike = function() {
	if ($(this).hasClass('done')) {
		alert('您已赞过该文章');
		return false;
	} else {
		$(this).addClass('done');
		var id = $(this).data("id");
		var umAction = $(this).data('action'),
		rateHolder = $(this).children('.count');
		var ajax_data = {
			action: "specs_zan",
			um_id: id,
			um_action: umAction
		};
		$.post("/wp-admin/admin-ajax.php", ajax_data,
		function(data) {
			$(rateHolder).html(data);
		});
		return false;
	}
};

$(document).on("click", "#post-dislike",
	function() {
		$(this).postDislike();
	}
);

// 评论顶
$.fn.commentLike = function() {
	if ($(this).hasClass('done')) {
		alert('您已发表过意见了');
		return false;
	} else {
		$(this).addClass('done');
		var id = $(this).data("id"),
		action = $(this).data('action'),
		rateHolder = $(this).children('.count');
		var ajax_data = {
			action: "specs_zan",
			um_id: id,
			um_action: action
		};
		$.post("/wp-admin/admin-ajax.php", ajax_data,
		function(data) {
			$(rateHolder).html(data);
		});
		return false;
	}
};

$(document).on("click", ".comment-like",
	function() {
		$(this).commentLike();
	}
);

// 评论踩
$.fn.commentDislike = function() {
	if ($(this).hasClass('done')) {
		alert('您已发表过意见了');
		return false;
	} else {
		$(this).addClass('done');
		var id = $(this).data("id"),
		action = $(this).data('action'),
		rateHolder = $(this).children('.count');
		var ajax_data = {
			action: "specs_zan",
			um_id: id,
			um_action: action
		};
		$.post("/wp-admin/admin-ajax.php", ajax_data,
		function(data) {
			$(rateHolder).html(data);
		});
		return false;
	}
};

$('.comment-dislike').on('click', function() {
	$(this).commentDislike();
});

// 显示表情框
$('#show-expression').on('click', function() {
    $('#expression-box').toggle();
});

// 没乱用的功能
try {
    if (window.console && window.console.log) {
        console.log("Hi，本主题已开源，源码及下载地址：\nhttps://github.com/cjhgithub/ctheme");
    }
} catch(e) {
}

// 导航菜单悬停
$('#nav-header').posfixed({
    distance: 0,
    pos: "top",
    type: "while",
    hide:false	// TODO 这里在false前面加一个空格会出错，原因未知
});

// 签名
drawName(30);

function drawName(num) {
    var speed = 200.0; // 每秒绘制100px
    var totalTime = 0;
    for (var i = 0; i < num; i++) {
        var path = document.querySelector('#name' + i);
        if (path) {
            var length = path.getTotalLength(); // TODO IE8这里会报错
            var time = length / speed;

            path.style['stroke-dasharray'] = length;
            path.style['stroke-dashoffset'] = length;
            path.style['animation'] = 'dash ' + time + 's linear forwards';
            path.style['animation-delay'] = totalTime + 's';

            totalTime += time;
        } 
    }
}


}); // end of $(document).ready

// 选择表情图片
function grin(tag) {
	var myField;
	tag = ' ' + tag + ' ';
	if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
		myField = document.getElementById('comment');
	} else {
		return false;
	}
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = tag;
		myField.focus();
	} else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		var cursorPos = endPos;
		myField.value = myField.value.substring(0, startPos)
					  + tag
					  + myField.value.substring(endPos, myField.value.length);
		cursorPos += tag.length;
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;
	} else {
		myField.value += tag;
		myField.focus();
	}
}