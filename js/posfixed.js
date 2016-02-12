(function($){
    $.extend($.fn, {
		posfixed: function(configSettings){
            var settings = {
            	direction:"top",
            	type:"while",
            	hide:false,
				distance:0
			};			
			$.extend(settings, configSettings);

			var obj = this;
			var initPos = $(obj).offset().top;
			var initPosLeft = $(obj).offset().left;
			var anchoredPos = settings.distance;

			if(settings.type=="while"){
				$(window).scroll(function(event) {

					if(settings.direction == "top"){
						var objTop = $(obj).offset().top - $(window).scrollTop();
					
						if(objTop<=settings.distance){
							$(obj).css("position","fixed");
							$(obj).css(settings.direction,settings.distance+"px");
							
						}
						if($(obj).offset().top<=initPos){
							$(obj).css("position","static");
						}
					}else{
						var objBottom = $(window).height() - $(obj).offset().top + $(window).scrollTop() - $(obj).outerHeight() ;
						
						if(objBottom<=settings.distance){
							
							$(obj).css("position","fixed");
							$(obj).css(settings.direction,settings.distance+"px");
							
						}
						if($(obj).offset().top>=initPos){
							$(obj).css("position","static");
						}
					}
					


				});
			}
			
			if(settings.type=="always"){
				if(settings.hide){
					$(obj).hide();
				}
				$(window).scroll(function(event) {
					if($(window).scrollTop()>300){
						$(obj).fadeIn(200);
					}else{
						$(obj).fadeOut(200);
					}
				});
				var objLeft = $(obj).offset().left;

				$(obj).css("position","fixed");
				$(obj).css(settings.direction,settings.distance+"px");
				if(settings.tag!=null){
					if(settings.tag.obj!=null){
						if(settings.tag.direction=="right"){
							$(obj).css("left",(settings.tag.obj.offset().left+settings.tag.obj.width()+settings.tag.distance)+"px");
							$(window).resize(function(){
								$(obj).css("left",(settings.obj.tag.offset().left+settings.tag.obj.width()+settings.tag.distance)+"px");
							});
						}else{
							console.log(settings.tag.obj.offset().left-settings.tag.obj.width()-settings.tag.distance);
							$(obj).css("left",(settings.tag.obj.offset().left-$(obj).outerWidth()-settings.tag.distance)+"px");
							$(window).resize(function(){
								$(obj).css("left",(settings.tag.obj.offset().left-$(obj).outerWidth()-settings.tag.distance)+"px");
							});
						}
						
					}else{
						$(obj).css(settings.tag.direction,settings.tag.distance+"px");
					}
				}
			}
			
			
		}
	});
	
	
})(jQuery);
