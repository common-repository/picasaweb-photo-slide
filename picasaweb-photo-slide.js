		jQuery(document).ready(function(){
			jQuery.ajax({
				url:"http://picasaweb.google.com/data/feed/api/user/tangchao.zju/album/beauties?kind=photo&alt=json&imgmax=200u",
				dataType:'jsonp',
				timeout:15000,
				type:'GET',
				timeout:function(){
					jQuery('#photo_album').append('Time Out!!');
				},
				success:function(data){
					jQuery('#photo_album').empty();
					var html = '';
					var entries = data['feed']['entry'];
					for (i = 0; i < entries.length; i++){
						var entry = entries[i]['content']['src'];
						html += '<img src="' + entry + '" height="200px" width="150px" style="display:hidden"/>';
					}
					jQuery('#photo_album').append(html);
					jQuery('#photo_album').cycle({ 
					    fx:      'custom', 
					    cssBefore: {  
					        left: 115,  
					        top:  115,  
					        width: 0,  
					        height: 0,  
					        opacity: 1, 
					        zIndex: 1 
					    }, 
					    animOut: {  
					        opacity: 0  
					    }, 
					    animIn: {  
					        left: 0,  
					        top: 0,  
					        width: 150,  
					        height: 200  
					    }, 
					    cssAfter: {  
					        zIndex: 0 
					    }, 
					    delay: -3000 
					});
				},
				error:function(){
					jQuery('#feed').append('Error');
				}
			});				
		});