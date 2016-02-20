(function($) {
	$.fn.extend({
		myFix:function(){
			var elem = $(this);
			var width = $(this).width();
			var height = $(this).height();
			var bottom = $(this).offset().top; // 侧栏顶部距离文档顶部的距离
			var wHeight = $(window).height();
			var dHeight = $(document).height();
			var sTop = $(document).scrollTop();
			var count = 1;
			var st = -1;

			var offsetLeft = $(this).offset().left;
			
			//$('#red').css('left', offsetLeft + 'px');
			
			var offset1 = elem.height() + elem.offset().top
					- $(window).height();
			//alert(offset1);
			var offsetBottom = elem.parent().height() + elem.offset().top;
			var test = $(document).scrollTop() + $(window).height();
			var offset2=elem.parent().height() + elem.offset().top-$(window).height();

			var offsetRight = $(window).width() - elem.offset().left
				- elem.width();
			$(this).click(function(){
				
				//alert(123);
				
				
			});  
			
			$(document).scroll(function() {
				if ($(document).scrollTop() < offset1 
				//|| $(document).scrollTop() > offset2 
				) {
					if (elem.hasClass('fix-bottom')) {
							elem.removeClass('fix-bottom');
						}
				} else {
					
					elem.addClass('fix-bottom');
					elem.css('left', offsetLeft + 'px');
					elem.css('width', width);
				}	
			});  
		}
	});    
})(jQuery);