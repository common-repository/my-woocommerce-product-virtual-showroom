(function( $ ) {

  var mediaUploader;
	
  
   $("#protabs").tabs();
   
  $('#MyWooCommerceShowroom_pics_upload').click(function(e) {
    e.preventDefault();
    // If the uploader object has already been created, reopen the dialog
      if (mediaUploader) {
      mediaUploader.open();
      return;
    }
    // Extend the wp.media object
    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Choose Image',
      button: {
      text: 'Choose Image'
    }, multiple: true });
	
    mediaUploader.on('select', function() {
		
		var MyWooCommerceProductDemo_pics_attachment = mediaUploader.state().get('selection').toJSON();
		
		var MyWooCommerceProductDemo_pics_array_id = [];
		var MyWooCommerceProductDemo_pics_array_url = [];
		
		$.each(MyWooCommerceProductDemo_pics_attachment, function() {
			MyWooCommerceProductDemo_pics_array_id.push(this.id);
			MyWooCommerceProductDemo_pics_array_url.push(this.url);
			$('.uploader_p').append("<img src='"+this.url+"'  width='100' />");
		});	 

		
		$(".MyWooCommerceShowroom_pics").each(function(i) {
		   $(this).val(MyWooCommerceProductDemo_pics_array_id[i]);
			  $('#MyWooCommerceShowroom_pics').val(MyWooCommerceProductDemo_pics_array_id[i]);
			  $('.MyWooCommerceProductDemo_pics_preview').attr('src', MyWooCommerceProductDemo_pics_array_url[i]);
		});	
		$(".MyWooCommerceShowroom_pics_url").each(function(i) {
		   $(this).val(MyWooCommerceProductDemo_pics_array_url[i]);
		   
			$('.existing').css('display','none');
		});	
						$.ajax({
							url: window.location.href,
							data:  $('#MyWooCommerceShowroom_form').serialize(),
							type: 'POST',
							beforeSend: function() {	
								$('#MyWooCommerceShowroom_form #save_changes').append("<img  style='position:absolute;left:150px;width:70px;height:70px;' src='"+MyWooCommerceShowroom_url.plugin_url+"/images/loader.gif' />");
							},						
							success: function(data){
								$("body").html(data);
								$("#submit").val('Saved');
								$("#submit").attr('disabled','disabled');
							}
						});	
    });	
	

    // Open the uploader dialog
    mediaUploader.open();
  });	


 			$("#MyWooCommerceShowroom_form").submit(function(e) {
				e.preventDefault();
						$.ajax({
							url: window.location.href,
							data:  $(this).serialize(),
							type: 'POST',
							beforeSend: function() {	
								//$(".MyWooCommerceShowroomWrap").addClass('loading');
								$('#MyWooCommerceShowroom_form #save_changes').append("<img  style='position:absolute;left:150px;width:70px;height:70px;' src='"+MyWooCommerceShowroom_url.plugin_url+"/images/loader.gif' />");
							},						
							success: function(data){
								location.reload();
							}
						});	
			});				
			
			$('#MyWooCommerceShowroom_form select, #MyWooCommerceShowroom_form input').click(function(){
				$("#submit").delay(4000).val('Save Changes');
				$("#submit").attr('disabled',false);
			});
			
 		$("#MyWooCommerceShowroom_signup").on('submit',function(e){
			e.preventDefault();	
			var dat = $(this).serialize();
			$.ajax({
				
				url:	"https://extend-wp.com/wp-json/signups/v2/post",
				data:  dat,
				type: 'POST',							
				beforeSend: function(data) {								
						console.log(dat);
				},					
				success: function(data){
					alert(data);
				},
				complete: function(data){
					dismiss();
				}				
			});	
		});
		

		function dismiss(){
			
				var ajax_options = {
					action: 'MyWooCommerceShowroom_push_not',
					data: 'title=1',
					nonce: 'MyWooCommerceShowroom_push_not',
					url: MyWooCommerceShowroom_url.ajaxUrl,
				};			
				
				$.post( MyWooCommerceShowroom_url.ajaxUrl, ajax_options, function(data) {
					$(".MyWooCommerceShowroom_notification").fadeOut();
				});
				
				
		}
		
		$(".MyWooCommerceShowroom_notification .dismiss").on('click',function(e){
				dismiss();
				console.log('clicked');
				
		});			
			
})( jQuery );