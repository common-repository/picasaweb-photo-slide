<?php
/*
Plugin Name: PicasaWeb Photo Slide Show Widget
Plugin URI: http://www.charlestang.cn/picasaweb-photo-slide.htm
Description: A photo slide show use Picasa Web Album.
Version: 8.8.13
Author: Charles Tang
Author URI: http://www.charlestang.cn
*/
/*  
	Copyright 2008  Charles Tang  (email : tngchao@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

function widget_picasaweb_photo_slide_init() {
	if (!function_exists('register_sidebar_widget')) {
		return;
	}

	function widget_picasaweb_photo_slide($args) {
		extract($args);
		$options = get_option('widget_picasaweb_photo_slide');
		$title = htmlspecialchars(stripslashes($options['title']));	
		echo $before_widget.$before_title.$title.$after_title;
		?>
			<style type="text/css">
				#photo_album {
					margin:0 auto;
					padding:0;
					overflow:hidden;
					width:100%;
					text-align:center;
					vertical-align:middle;
					position:relative;
				}
				.album_container {
					width:100%;
					text-align:center;
					vertical-align:middle;
					position:relative;
					<?php if (!$options['withdescription']) {?>
						height:<?php echo ($options['thumbsize'] + 16);?>px;
					<?php }else{?>
						height:<?php echo ($options['thumbsize'] + 44);?>px;
					<?php }?>
				}
				.photo_descip{
					text-align:center;
					background-color:#fff;
					border:8px solid #fff;
					font-size:12px;
					padding:2px 0;
					margin:0;
					overflow:hidden;
				}
				#photo_album img{
					border-top:8px solid #fff;
					border-left:8px solid #fff;
					border-right:8px solid #fff;
					<?php if (!$options['withdescription']) :?>
					border-bottom:8px solid #fff;
					<?php endif;?>
				}
				#photo_album > div {
					margin:0 auto;
					text-align:left;
				}
			</style>
			<div class="album_container">
				<div id="photo_album"></div>
			</div>
		<?php
		echo $after_widget;
	}

	function widget_picasaweb_photo_slide_options() {
		$options = get_option('widget_picasaweb_photo_slide');
		if (!is_array($options)) {
			$options = array(
				'title' => __('Photo Album','phs'),
				'userid' => 'tangchao.zju',
				'albumname' => 'beauties',
				'thumbsize' => 200,
				'withdescription' => 1
			);
		}
		if ($_POST['phs-submit']) {
			$options['title'] = strip_tags($_POST['phs-title']);
			$options['userid'] = $_POST['phs-userid'];
			$options['albumname'] = $_POST['phs-albumname'];
			$options['thumbsize'] = $_POST['phs-thumbsize'];
			$options['withdescription'] = $_POST['phs-withdescription'];
			update_option('widget_picasaweb_photo_slide', $options);
		}
		echo '<p style="text-align: left;"><label for="phs-title">';
		_e('Title: ','phs');
		echo '</label><input type="text" id="phs-title" name="phs-title" value="'. htmlspecialchars(stripslashes($options['title'])).'" /></p>'."\n";
		echo '<p style="text-align: left;"><label for="phs-userid">';
		_e('UserID: ','phs');
		echo '</label><input type="text" id="phs-userid" name="phs-userid" value="'. $options['userid'] . '" /></p>'."\n";
		echo '<p style="text-align: left;"><label for="phs-albumname">';
		_e('Album Name: ','phs');
		echo '</label><input type="text" id="phs-albumname" name="phs-albumname" value="'. $options['albumname'] . '" /></p>'."\n";
		echo '<p style="text-align: left;"><label for="phs-thumbsize">';
		_e('Thumb Size: ','phs');
		echo '</label><select id="phs-thumbsize" name="phs-thumbsize"/>';
		echo '<option value="72" '. ($options['thumbsize']==72?'selected="selected"':'') .'>72px</option>';
		echo '<option value="144" '. ($options['thumbsize']==144?'selected="selected"':'') .'>144px</option>';
		echo '<option value="160" '. ($options['thumbsize']==160?'selected="selected"':'') .'>166px</option>';
		echo '<option value="200" '. ($options['thumbsize']==200?'selected="selected"':'') .'>200px</option>';
		echo '<option value="288" '. ($options['thumbsize']==288?'selected="selected"':'') .'>288px</option>';
		echo '<option value="320" '. ($options['thumbsize']==320?'selected="selected"':'') .'>320px</option>';
		echo '<option value="400" '. ($options['thumbsize']==400?'selected="selected"':'') .'>400px</option>';
		echo '</select></p>'."\n";
		echo '<p style="text-align: left;"><label for="phs-withdescription">';
		_e('With Description: ','phs');
		echo '</label><input type="checkbox" id="phs-withdescription" name="phs-withdescription" value="'. ($options['withdescription']?'true':'false') . '" ' . ($options['withdescription']?'checked="checked"':'') . '/></p>'."\n";
		echo '<input type="hidden" id="phs-submit" name="phs-submit" value="1" />'."\n";
	}
	
	$widget_ops =  array('classname' => 'widget_picasaweb_photo_slide', 'description' => __( 'Display a photo slide show on your sidebar.', 'phs'));
	// Register Widgets
	wp_register_sidebar_widget('picasaweb_photo_slide', __('Photo Album','phs'), 'widget_picasaweb_photo_slide', $widget_ops);
	wp_register_widget_control('picasaweb_photo_slide', __('Photo Album','phs'), 'widget_picasaweb_photo_slide_options', 400, 200);
}

function pps_init(){
	wp_enqueue_script('jquery');
}

function pps_js(){
	$options = get_option('widget_picasaweb_photo_slide');
	echo '<script type="text/javascript" src="' . WP_CONTENT_URL . '/plugins/picasaweb-photo-slide/jquery.cycle.pack.js"></script>';
	//echo '<script type="text/javascript" src="' . WP_CONTENT_URL . '/plugins/picasaweb-photo-slide/picasaweb-photo-slide.js"></script>';
	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery.ajax({
				url:"http://picasaweb.google.com/data/feed/api/user/<?php echo $options['userid']; ?>/album/<?php echo $options['albumname']; ?>?kind=photo&alt=json&imgmax=<?php echo $options['thumbsize'];?>u",
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
						var imgsrc = entries[i]['content']['src'];
						var imgdescrip = entries[i]['summary']['$t'];
						var imgwidth = entries[i]['gphoto$width']['$t'];
						var imgheight = entries[i]['gphoto$height']['$t'];
						var containerwidth;
						var containerheight;
						
						if (imgwidth >= imgheight)
						{
							containerwidth = <?php echo $options['thumbsize'];?> + 16;
							containerheight = imgheight / imgwidth * <?php echo $options['thumbsize'];?> + 16;
						}
						else
						{
							containerheight = <?php echo $options['thumbsize'];?> + 16;
							containerwidth = imgwidth / imgheight * <?php echo $options['thumbsize'];?> + 16;
						}
						html += '<div height="'+ (containerheight+20) +'px" width="' + containerwidth  + 'px"><img src="' + imgsrc + '" width="' + (containerwidth - 16)  + 'px" style="display:hidden"/>';
						<?php if ($options['withdescription']) { ?>
							html += '<div style="height:20px;width:' + (containerwidth - 16) + 'px" class="photo_descip">';
							if (<?php echo $options['thumbsize'];?> > 72) 
							{
								html += imgdescrip;
							}
							html += '</div>';
						<?php } ?>
						html += '</div>';
					}
					jQuery('#photo_album').append(html);
					jQuery('#photo_album').cycle({ 
					        fx:      'custom', 
						    sync: 0, 
						    cssBefore: {  
						        top:  0, 
						        left: <?php echo $options['thumbsize'];?> + 20, 
						        display: 'block' 
						    }, 
						    animIn:  { 
						        left: 0
						    }, 
						    animOut: {  
						        top: <?php echo $options['thumbsize'];?> + 50
						    }, 
						    delay: -1000,
						    after: onAfter
					});
				},
				error:function(){
					jQuery('#feed').append('Error');
				}
			});				
		});
		function onAfter(){
			jQuery('#photo_album').width(jQuery(this).width());
			jQuery('#photo_album').height(jQuery(this).height());
			jQuery('#photo_album').css('top',(jQuery('.album_container').height() - jQuery('#photo_album').height())/2);
		}
	</script>
	<?php
}

add_action('init','pps_init');
add_action('wp_head', 'pps_js');
add_action('plugins_loaded','widget_picasaweb_photo_slide_init');
?>