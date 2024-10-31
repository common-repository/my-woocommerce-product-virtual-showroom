/**	DRAG SUPPORT ON MOBILE	**/
!function(a){function f(a,b){if(!(a.originalEvent.touches.length>1)){a.preventDefault();var c=a.originalEvent.changedTouches[0],d=document.createEvent("MouseEvents");d.initMouseEvent(b,!0,!0,window,1,c.screenX,c.screenY,c.clientX,c.clientY,!1,!1,!1,!1,0,null),a.target.dispatchEvent(d)}}if(a.support.touch="ontouchend"in document,a.support.touch){var e,b=a.ui.mouse.prototype,c=b._mouseInit,d=b._mouseDestroy;b._touchStart=function(a){var b=this;!e&&b._mouseCapture(a.originalEvent.changedTouches[0])&&(e=!0,b._touchMoved=!1,f(a,"mouseover"),f(a,"mousemove"),f(a,"mousedown"))},b._touchMove=function(a){e&&(this._touchMoved=!0,f(a,"mousemove"))},b._touchEnd=function(a){e&&(f(a,"mouseup"),f(a,"mouseout"),this._touchMoved||f(a,"click"),e=!1)},b._mouseInit=function(){var b=this;b.element.bind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),c.call(b)},b._mouseDestroy=function(){var b=this;b.element.unbind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),d.call(b)}}}(jQuery);

/**	END OF DRAG SUPPORT ON MOBILE	**/


(function( $ ) {
		//FILE UPLOAD
		$("#MyWooCommerceShowroom_wrappper .uploader").on('click', function() {
					var imageLoader = document.getElementById('filePhoto');
					imageLoader.addEventListener('change', handleImage, false);
					

					function handleImage(e) {
						var reader = new FileReader();
						reader.onload = function (event) {
						
							$('#MyWooCommerceShowroom_wrappper .uploader .userSelected').attr('src',event.target.result);
							$('#MyWooCommerceShowroom_wrappper .uploader .userSelected').fadeIn();
							$('#MyWooCommerceShowroom_wrappper .showroom .userPic').attr('src',event.target.result);
							
							$('#MyWooCommerceShowroom_wrappper .uploader').css('height','auto');
													
							$('#MyWooCommerceShowroom_wrappper .toSecond').removeClass('disabled');
							$('#MyWooCommerceShowroom_wrappper .toSecond').css('font-weight','bold');
							$("#upload .showroomtitle").html(MyWooCommerceShowroom_url.pic_uploaded);
							$("#upload .showroomtitle").addClass('showroomtitleCurrent');							
							//$('#MyWooCommerceShowroom_wrappper .uploader').css('background','none');
							
							//auto animaate to next step!
							
							setTimeout(
							  function(){					
								$('#MyWooCommerceShowroom_wrappper .toSecond').trigger('click');	
								setTimeout(
								  function(){
									$('body').removeClass('loading');
									
								  }, 1000);									
							  }, 2000);										
						}
						reader.readAsDataURL(e.target.files[0]);
					};			
		});
		
					$('#MyWooCommerceShowroom_wrappper .tab a').click(function(){
						$('#MyWooCommerceShowroom_wrappper .tab a').css('font-weight','normal');
					});
					
		
					
					$("#MyWooCommerceShowroom_wrappper .productList p").click(function(){
						//auto animaate to next step!
							
							setTimeout(
							  function() 
							  {
								$('#MyWooCommerceShowroom_wrappper .toThird').trigger('click');	
								$('body').removeClass('loading');
							  }, 2000);
						$('#MyWooCommerceShowroom_wrappper .toThird').removeClass('disabled');
						
						$('#MyWooCommerceShowroom_wrappper .tab a').css('font-weight','normal');
						$('#MyWooCommerceShowroom_wrappper .toThird').css('font-weight','bold');
						
						$("#product .showroomtitle").html(MyWooCommerceShowroom_url.prod_selected);
						$("#product .showroomtitle").addClass('showroomtitleCurrent');
						
					
						/**		WHEN PRODUCT CLICKED HIGHTLIGHT 	**/
						if($("#MyWooCommerceShowroom_wrappper .productList img").hasClass('activeImg') ){
							$("#MyWooCommerceShowroom_wrappper .productList img").removeClass('activeImg');
						}
						$(this).find('img').addClass('activeImg');						
						
						
						
					});
									
		
					$('div.tab a').on('click',function(e){
						e.preventDefault();
						var tab_id = $(this).attr('data-tab');

						$('div.tab a').removeClass('current');
						$('.tabcontent').removeClass('current');

						$(this).addClass('current');
						$("#"+tab_id).addClass('current');
					});					

					
					$("#MyWooCommerceShowroom_wrappper .WoocommerceSamplerDataNotFromDB img").click(function(){
							src = $(this).attr('src');
							$('#MyWooCommerceShowroom_wrappper .product').attr('src',src);
						
					});

			/***	DRAG 	***/		
					$("#MyWooCommerceShowroom_wrappper .showroom .productdrag").draggable({cursor: 'move'});					
			/***	END OF DRAG ***/
				
			
			/***	ACCORDION 	***/
				var acc = document.getElementsByClassName("accordion");
				var i;

				for (i = 0; i < acc.length; i++) {
				  acc[i].onclick = function() {
					this.classList.toggle("active");
					var panel = this.nextElementSibling;
					if (panel.style.maxHeight){
					  panel.style.maxHeight = null;
					} else {
					  panel.style.maxHeight = panel.scrollHeight + "px";
					} 
				  }
				}
				$(".accordion:gt[0]").load(function(){
					var panel = this.nextElementSibling;
					if (panel.style.maxHeight){
					  panel.style.maxHeight = null;
					} else {
					  panel.style.maxHeight = panel.scrollHeight + "px";
					} 						
				});	
			/***	END OF ACCORDION	***/
				
				
			/**	RESIZE PRODUCT	**/
					var scale=1;
					$('#increaseSize').on("click",function(){
						scale+=0.21;
						$(".product").css('transform',"scale("+scale+")");
					});
					$('#decreaseSize').on("click",function(){	
						scale-=0.1;
						$(".product").css('transform',"scale("+scale+")");								
					});
					
			/**	END OF RESIZE PRODUCT	**/			
})( jQuery );