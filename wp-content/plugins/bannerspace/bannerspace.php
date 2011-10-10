<?php
/*
Plugin Name: Bannerspace
Plugin URI: http://thriveweb.com.au/the-lab/bannerspace-wordpress-plugin/
Description: A banner plugin for WordPress powered by the jQuery Cycle Plugin.
Author: Dean Oakley
Author URI: http://deanoakley.com/
Version: 1.2.4
*/

/*  Copyright 2010  Dean Oakley  (email : contact@deanoakley.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 
	die('Illegal Entry');  
}


//============================== bannerspace options ========================//
class bannerspace_plugin_options {

	function BS_getOptions() {
		$options = get_option('bs_options');
		
		if (!is_array($options)) {
									
			$options['slide_effect'] = 'fade';
			$options['sync_effect'] = true;
			
			$options['banner_width'] = 800;
			$options['banner_height'] = 250;
			$options['banner_padding'] = 40;
			
			$options['content_width'] = 250;			
			$options['content_padding'] = 40;
			$options['hide_content'] = false;
			
			$options['image_width'] = 350;
			$options['image_height'] = 200;
			
			$options['delay'] = 3500;
			
			$options['speed'] = 1000;
			
			$options['colour'] = 'FFF';
			$options['active_colour'] = '000';
			$options['arrow_colour'] = '000';
			$options['bg_colour'] = 'e5e5e5';
			
			$options['show_arrows'] = true;
			$options['show_paging'] = true;
			$options['auto_play'] = true;
					
			
			update_option('bs_options', $options);
		}
		return $options;
	}
	
	
	function update() {
		if(isset($_POST['BS_save'])) {
			$options = bannerspace_plugin_options::BS_getOptions();
			
			$options['slide_effect'] = stripslashes($_POST['slide_effect']);
			$options['sync_effect'] = stripslashes($_POST['sync_effect']);
			
						
			$options['banner_width'] = stripslashes($_POST['banner_width']);
			$options['banner_height'] = stripslashes($_POST['banner_height']);
			$options['banner_padding'] = stripslashes($_POST['banner_padding']);
			
			$options['content_width'] = stripslashes($_POST['content_width']);
			$options['content_padding'] = stripslashes($_POST['content_padding']);		
			
			if ($_POST['hide_content'])
				$options['hide_content'] = (bool)true;
			else
				$options['hide_content'] = (bool)false;
			
			
			$options['image_width'] = stripslashes($_POST['image_width']);
			$options['image_height'] = stripslashes($_POST['image_height']);	
			
			$options['delay'] = stripslashes($_POST['delay']);
			$options['speed'] = stripslashes($_POST['speed']);
			
			$options['colour'] = stripslashes($_POST['colour']);
			$options['active_colour'] = stripslashes($_POST['active_colour']);
			$options['arrow_colour'] = stripslashes($_POST['arrow_colour']);
			$options['bg_colour'] = stripslashes($_POST['bg_colour']);
			
			if ($_POST['show_arrows'])
				$options['show_arrows'] = (bool)true;
			else
				$options['show_arrows'] = (bool)false;
			 
			if ($_POST['show_paging'])
				$options['show_paging'] = (bool)true;
			else
				$options['show_paging'] = (bool)false;
				
			if ($_POST['auto_play'])
				$options['auto_play'] = (bool)true;
			else
				$options['auto_play'] = (bool)false;			
				
			
			
			update_option('bs_options', $options);

		} else {
			bannerspace_plugin_options::BS_getOptions();
		}

		add_menu_page('Bannerspace options', 'Bannerspace Options', 'edit_themes', basename(__FILE__), array('bannerspace_plugin_options', 'display'));
	}
	
	function display() {
		
		$options = bannerspace_plugin_options::BS_getOptions();
		?>
		
		<div class="wrap">
		
			<h2>Bannerspace Options</h2>
			
			<form method="post" action="#" enctype="multipart/form-data">				
				
				<div class="wp-menu-separator" style="clear:both; padding-bottom:15px; border-bottom:solid 1px #e6e6e6" ></div>
				
				<div style="width:25%;float:left;">			
					<h3>Slide effect</h3>
						<select name="slide_effect">
							<option value="blindX" 		<?php bs_selected('blindX', 	$options['slide_effect']); ?>>blindX</option>
							<option value="blindY" 		<?php bs_selected('blindY', 	$options['slide_effect']); ?>>blindY</option>
							<option value="blindZ" 		<?php bs_selected('blindZ', 	$options['slide_effect']); ?>>blindZ</option>
							<option value="cover" 		<?php bs_selected('cover', 		$options['slide_effect']); ?>>cover</option>
							<option value="curtainX" 	<?php bs_selected('curtainX', 	$options['slide_effect']); ?>>curtainX</option>
							<option value="curtainY" 	<?php bs_selected('curtainY', 	$options['slide_effect']); ?>>curtainY</option>
							<option value="fade" 		<?php bs_selected('fade', 		$options['slide_effect']); ?>>fade</option>
							<option value="fadeZoom" 	<?php bs_selected('fadeZoom', 	$options['slide_effect']); ?>>fadeZoom</option>
							<option value="growX" 		<?php bs_selected('growX', 		$options['slide_effect']); ?>>growX</option>
							<option value="growY" 		<?php bs_selected('growY', 		$options['slide_effect']); ?>>growY</option>
							<option value="none" 		<?php bs_selected('none', 		$options['slide_effect']); ?>>none</option>
							<option value="scrollUp" 	<?php bs_selected('scrollUp', 	$options['slide_effect']); ?>>scrollUp</option>
							<option value="scrollDown" 	<?php bs_selected('scrollDown', $options['slide_effect']); ?>>scrollDown</option>
							<option value="scrollLeft" 	<?php bs_selected('scrollLeft', $options['slide_effect']); ?>>scrollLeft</option>
							<option value="scrollRight" <?php bs_selected('scrollRight',$options['slide_effect']); ?>>scrollRight</option>
							<option value="scrollHorz" 	<?php bs_selected('scrollHorz', $options['slide_effect']); ?>>scrollHorz</option>
							<option value="scrollVert" 	<?php bs_selected('scrollVert', $options['slide_effect']); ?>>scrollVert</option>
							<option value="shuffle" 	<?php bs_selected('shuffle', 	$options['slide_effect']); ?>>shuffle</option>
							<option value="slideX" 		<?php bs_selected('slideX', 	$options['slide_effect']); ?>>slideX</option>
							<option value="slideY" 		<?php bs_selected('slideY', 	$options['slide_effect']); ?>>slideY</option>
							<option value="toss" 		<?php bs_selected('toss', 		$options['slide_effect']); ?>>toss</option>
							<option value="turnUp" 		<?php bs_selected('turnUp', 	$options['slide_effect']); ?>>turnUp</option>
							<option value="turnDown" 	<?php bs_selected('turnDown', 	$options['slide_effect']); ?>>turnDown</option>
							<option value="turnLeft" 	<?php bs_selected('turnLeft', 	$options['slide_effect']); ?>>turnLeft</option>
							<option value="turnRight" 	<?php bs_selected('turnRight', 	$options['slide_effect']); ?>>turnRight</option>
							<option value="uncover" 	<?php bs_selected('uncover', 	$options['slide_effect']); ?>>uncover</option>
							<option value="wipe" 		<?php bs_selected('wipe', 		$options['slide_effect']); ?>>wipe</option>
							<option value="zoom" 		<?php bs_selected('zoom', 		$options['slide_effect']); ?>>zoom</option>	
							

						</select>
				</div>
				
				<div style="width:25%;float:left;">			
					<h3><label><input name="sync_effect" type="checkbox" value="checkbox" <?php if($options['sync_effect']) echo "checked='checked'"; ?> /> Sync Effects</label></h3>

				</div>
				
				<div style="clear:both; padding-bottom:15px; border-bottom:solid 1px #e6e6e6" ></div>
				
				<div style="width:25%;float:left;">				
					<h3>Banner Width</h3>
					<p><input type="text" name="banner_width" value="<?php echo($options['banner_width']); ?>" />px</p>
				</div>
				
				<div style="width:25%; float:left;">				
					<h3>Banner Height</h3>
					<p><input type="text" name="banner_height" value="<?php echo($options['banner_height']); ?>" />px</p>
				</div>
				
				<div style="width:25%; float:left;">				
					<h3>Banner Padding</h3>
					<p><input type="text" name="banner_padding" value="<?php echo($options['banner_padding']); ?>" />px</p>
				</div>				
				
				<div style="clear:both; padding-bottom:15px; border-bottom:solid 1px #e6e6e6" ></div>
				
				<h3 style="font-style:italic; font-weight:normal;  color:grey" >The content area displays the post title and body. </h3>
				
				<div style="width:25%;float:left;">				
					<h3>Content Width</h3>
					<p><input type="text" name="content_width" value="<?php echo($options['content_width']); ?>" />px</p>
				</div>
				
				<div style="width:25%;float:left;">				
					<h3>Content Padding</h3>
					<p><input type="text" name="content_padding" value="<?php echo($options['content_padding']); ?>" />px</p>
				</div>
				
				<div style="width:25%;float:left;">
					<h3><label><input name="hide_content" type="checkbox" value="checkbox" <?php if($options['hide_content']) echo "checked='checked'"; ?> /> Hide Content</label></h3>
				</div>
				
				<div style="clear:both; padding-bottom:15px; border-bottom:solid 1px #e6e6e6" ></div>
				
				<h3 style="font-style:italic; font-weight:normal; color:grey" >Images that are already on the server will not change size until you regenerate the thumbnails. Use <a title="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/" href="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/">AJAX thumbnail rebuild</a> or <a title="http://wordpress.org/extend/plugins/regenerate-thumbnails/" href="http://wordpress.org/extend/plugins/regenerate-thumbnails/">Regenerate Thumbnails</a> </h3>
				
				<div style="width:25%;float:left;">				
					<h3>Image Width</h3>
					<p><input type="text" name="image_width" value="<?php echo($options['image_width']); ?>" />px</p>
				</div>
				
				<div style="width:25%; float:left;">				
					<h3>Image Height</h3>
					<p><input type="text" name="image_height" value="<?php echo($options['image_height']); ?>" />px</p>
				</div>
				
				<div style="clear:both; padding-bottom:15px; border-bottom:solid 1px #e6e6e6" ></div>
				
				<div style="width:25%;float:left;">		
					<h3>Slide delay</h3> 
					<p><input type="text" name="delay" value="<?php echo($options['delay']); ?>" />ms</p>
				</div>
				
				<div style="width:25%;float:left;">		
					<h3>transition speed</h3>
					<p><input type="text" name="speed" value="<?php echo($options['speed']); ?>" />ms</p>
				</div>
				
				<div style="clear:both; padding-bottom:15px; border-bottom:solid 1px #e6e6e6" ></div>
				
				<div style="width:25%;float:left;">		
					<h3>Banner background colour</h3>
					<p>#<input type="text" name="bg_colour" value="<?php echo($options['bg_colour']); ?>" /></p>
				</div>
				
				<div style="width:25%;float:left;">		
					<h3>Nav colour</h3>
					<p>#<input type="text" name="colour" value="<?php echo($options['colour']); ?>" /></p>
				</div>
				
				<div style="width:25%;float:left;">		
					<h3>Current nav colour</h3>
					<p>#<input type="text" name="active_colour" value="<?php echo($options['active_colour']); ?>" /></p>
				</div>
				
				<div style="width:25%;float:left;">		
					<h3>Arrow background colour</h3>
					<p>#<input type="text" name="arrow_colour" value="<?php echo($options['arrow_colour']); ?>" /></p>
				</div> 
				

				
				<div style="clear:both; padding-bottom:15px; border-bottom:solid 1px #e6e6e6" ></div>
				
				
				<h3><label><input name="show_arrows" type="checkbox" value="checkbox" <?php if($options['show_arrows']) echo "checked='checked'"; ?> /> Show arrows</label></h3>
				
				<h3><label><input name="show_paging" type="checkbox" value="checkbox" <?php if($options['show_paging']) echo "checked='checked'"; ?> /> Show paging</label></h3>
				
				<h3><label><input name="auto_play" type="checkbox" value="checkbox" <?php if($options['auto_play']) echo "checked='checked'"; ?> /> Auto play on load</label></h3>


				<div style="clear:both; padding-bottom:15px; border-bottom:solid 1px #e6e6e6" ></div>
				
				<p><input class="button-primary" type="submit" name="BS_save" value="Save Changes" /></p>
				
			</form>
	
		</div>
		
		<?php
	} 
} 

function BS_getOption($option){ 
	global $mytheme; 
	return $mytheme->option[$option]; 
}

// register functions
add_action('admin_menu', array('bannerspace_plugin_options', 'update'));

//Set thumbnails
$options = get_option('bs_options');
add_theme_support( 'post-thumbnails' );
add_image_size('bannerspace', $options['image_width'], $options['image_height'] );

//============================== insert HTML header tag ========================//

wp_enqueue_script('jquery');

$bannerspace_wp_plugin_path = get_option('siteurl')."/wp-content/plugins/bannerspace";

wp_enqueue_style( 'bannerspace-styles', 	$bannerspace_wp_plugin_path . '/bannerspace.css'); 
wp_enqueue_script( 'jquery cycle', 	$bannerspace_wp_plugin_path . '/jquery.cycle.all.min.js');

add_action( 'wp_head', 'bannerspace_wp_headers', 10 );

function bannerspace_wp_headers() {
	
	$options = get_option('bs_options');
	
	echo "<!--	bannerspace [ START ] --> \n";
	
	echo "<style type='text/css'>";
	
	if(!empty($options['active_colour'])){ 
		echo "
			#bannerspace_nav .activeSlide a {
				background-color:#". $options['active_colour'] . " !important;
			}
		"; 
	}
	
	if(!empty($options['colour'])){ 
		echo "
			#bannerspace_nav a {
				background-color:#". $options['colour'] . ";
			}
		"; 
	}
	
	if(!empty($options['arrow_colour'])){ 
		echo "
			.bs_arrow{
				background-color:#". $options['arrow_colour'] . ";
			}
		"; 
	}
	
	if(!empty($options['bg_colour'])){ 
		echo "
			#bannerspace_wrap{
				background-color:#". $options['bg_colour'] . ";
			}
		"; 
	}	
	
	if(!$options['show_arrows']){ 
		echo "
			.bs_arrow{
				display:none !important;
			}
		"; 
	}
	
	if(!$options['show_paging']){ 
		echo "
			#bannerspace_nav{
				display:none !important;
			}
		"; 
	}
	
	if(!empty($options['banner_width']))
		echo '	#bannerspace_wrap,
				#bannerspace,
				.slide{
					width:'. $options['banner_width'] .'px;
				}
		';
		
	if(!empty($options['banner_height']))
		echo '	#bannerspace_wrap,
				#bannerspace,
				.slide{
					height:'. $options['banner_height'] .'px;
				}
		';
		
	if(!empty($options['banner_padding']))
		echo '	#bannerspace_wrap {
					padding:'. $options['banner_padding'] .'px;
				}
		';
		
	if(!empty($options['content_width']))
		echo '	#bannerspace .content {
					width:'. $options['content_width'] .'px;
				}
		';
		
	if(!empty($options['content_padding']))
		echo '	#bannerspace .content {
					padding:'. $options['content_padding'] .'px;
				}
		';
		
	if($options['hide_content'])
		echo '	#bannerspace .content {
					display:none;
				}
		';		
		
		
	if(!empty($options['image_width']))
		echo '	#bannerspace .imageWrapper {
					width:'. $options['image_width'] .'px;
				}
		';
		
		
	
		echo "</style>"; 
		
	echo "
	<script type='text/javascript'> 
	
		jQuery(document).ready(function($) {
			
			// All options - http://jquery.malsup.com/cycle/options.html
			
			$('#bannerspace').after('<div id=bannerspace_nav>').cycle({
				fx:     '" .  $options['slide_effect'] . "',	//Effects - http://jquery.malsup.com/cycle/browser.html
				speed:  '" . $options['speed'] . "',	
				pager:  '#bannerspace_nav',
				next:   '#bs_r_arrow',
                prev:   '#bs_l_arrow',
				timeout: '" . $options['delay'] . "',
				containerResize: 0,
				slideResize: 0,
				requeueOnImageNotLoaded: 1,
				cleartypeNoBg: true,
				sync: '" . $options['sync_effect'] . "',
				pagerAnchorBuilder: function(idx, slide) {
					var title =  $($(slide).find('.title').get(0)).html();
					
					return '<span><a href=javascript:void(0) title='+title+'></a></span>';
				}
			}).cycle('pause')";
		
			if($options['auto_play']){
				echo ";			
					jQuery(window).load(function ($) {									
						jQuery('.bs_arrow').fadeIn();
						jQuery('#bannerspace_nav').fadeIn();
						jQuery('#bannerspace .content').fadeIn();
						
						 setTimeout(function() {
						 	jQuery('#bannerspace').cycle('resume');
						 					
						 }," . $options['delay'] . ")
						 					
					});
				";
			}
			else{
				echo ";			
					jQuery(window).load(function ($) {									
						jQuery('.bs_arrow').fadeIn();
						jQuery('#bannerspace_nav').fadeIn();
						jQuery('#bannerspace .content').fadeIn();
					});
				";
			}
			
		echo "
		});
		

	"; 
	
	echo '</script>'; 
	
	echo "<!--	bannerspace [ END ] --> \n";
}


add_shortcode( 'bannerspace', 'bannerspace_shortcode' );
function bannerspace_shortcode( $atts ) {
	
	global $post;
	$options = get_option('bs_options');
	
	extract(shortcode_atts(array(
		'cat'	=> '', 
		'category_name' => '', 
	), $atts));
	
	$bannerspace_wp_plugin_path = get_option('siteurl')."/wp-content/plugins/bannerspace";
	
	$output_buffer ='
		<div id="bannerspace_wrap">
		<div id="bannerspace">
			';
			$loop = new WP_Query( array( "post_type" => "bannerspace_post", 'order' => 'asc', 'orderby' => 'menu_order', 'posts_per_page' => -1, 'cat' => $cat, 'category_name' => $category_name ) );
			while ( $loop->have_posts() ) : $loop->the_post();
				
				$link =  get_post_meta($post->ID, 'link', true);
				
				$output_buffer .='				
					<div class="slide">
						';
						if( !empty($link) ) : 
							$output_buffer .='<a href="'.$link.'">';
						endif;
						
						$output_buffer .='		
							<!--image slider-->
							<div class="imageWrapper">
								' . get_the_post_thumbnail($post->ID, 'bannerspace') . '
							</div>
							
							<div class="content">
								<h3 class="title">' . get_the_title('') . '</h3>
								<p>' . get_the_content('') . '</p>
							</div>
						';
						if( !empty($link) ) : 
							$output_buffer .='</a>';
						endif;
					
				$output_buffer .='
					</div>';
			
			endwhile; 
		
		$output_buffer .='
		</div>
		
		<a href="javascript: void(0);" id="bs_l_arrow" class="bs_arrow"></a>
		<a href="javascript: void(0);" id="bs_r_arrow" class="bs_arrow"></a>
	
	</div>
	<div class="bs_clear"></div>
	';
	
	wp_reset_postdata();
		
	return $output_buffer;
} 


//============================== add post type ========================//
add_action( 'init', 'create_bannerspace_post_type' );
function create_bannerspace_post_type() {
	register_post_type( 'bannerspace_post',
		array(
			'labels' => array( 
				'name' => __( 'Banner Slides' ), 	
				'singular_name' => __( 'slide' )
		),
		'public' => true,
		'exclude_from_search ' => true,
		'hierarchical' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes'),
		'taxonomies' => array('category') 
		)
		
	);
}


function bs_selected ($option, $set){
	if ($option == $set) 
		echo 'selected="selected"';  
} 
			