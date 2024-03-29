<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title>
<?php if ( is_home()) { bloginfo('name'); ?> - <?php bloginfo('description'); } ?>
<?php if ( is_search()) { bloginfo('name'); ?> - <?php _e('Search Results', 'nattywp'); } ?>
<?php if ( is_author()) { bloginfo('name'); ?> - <?php _e('Author Archives', 'nattywp'); } ?>
<?php if ( is_single()) { $custom_title = get_post_meta($post->ID, 'natty_title', true); 
if (strlen($custom_title)) {echo strip_tags(stripslashes($custom_title));}else { wp_title(''); ?> - <?php bloginfo('name'); }} ?>
<?php if ( is_page()) { $custom_title = get_post_meta($post->ID, 'natty_title', true); 
if (strlen($custom_title)) {echo strip_tags(stripslashes($custom_title));}else { bloginfo('name'); ?> - <?php wp_title(''); }}?>
<?php if ( is_category()) { bloginfo('name'); ?> - <?php _e('Archive','nattywp'); ?> - <?php single_cat_title(); } ?>
<?php if ( is_month()) { bloginfo('name'); ?> - <?php _e('Archive','nattywp'); ?> - <?php the_time('F');  } ?>
<?php if (function_exists('is_tag')) { if ( is_tag() ) { bloginfo('name'); ?> - <?php _e('Tag Archive','nattywp'); ?> - <?php  single_tag_title("", true); } } ?>
</title>

<?php /* Include the jQuery framework */ 
wp_enqueue_script("jquery"); if (is_singular() && get_option('thread_comments')) wp_enqueue_script( 'comment-reply' ); ?>
<!-- Style sheets -->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/style_temp.css" media="screen" />
<?php include (TEMPLATEPATH . '/style.php'); ?>
<?php wp_head(); ?>

<!-- Feed link -->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!-- jQuery utilities -->
<script type="text/javascript">var themePath = '<?php echo get_template_directory_uri(); ?>/'; // for js functions </script>
<script type="text/javascript">var $j = jQuery.noConflict();</script>
<script type='text/javascript' src="<?php echo get_template_directory_uri(); ?>/js/superfish.js?ver=2.9.2"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.min.js"></script>
<?php if (t_get_option('t_cufon_replace') == 'yes') { ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/cufon.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/font.js"></script>
<script type="text/javascript">Cufon.replace('.post .title h2 a', {hover:true});</script>
<?php } ?>

<!--[if IE 6]>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/menu.js"></script>
    	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ie6.css" />
        <style type="text/css">
            img.png {
            filter: expression(
            (runtimeStyle.filter == '') ? runtimeStyle.filter = 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src='+src+', sizingMethod=scale)' : '',
            width = width,
            src = '<?php echo get_template_directory_uri(); ?>/images/px.gif');
    }
        </style>
	<![endif]-->
    
    <!--[if IE 7]>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/ie7.css" />
	<![endif]-->
<style type="text/css">
<?php 
  $t_show_slideshow = t_get_option( "t_show_slideshow" );  
  $t_scroll_pages = t_get_option( "t_scroll_pages" );  
?>
</style>

<script type="text/javascript">
    WebFontConfig = {
      custom: { families: ['aRubricaXtCnRegular'],
        urls: [ '<?php echo bloginfo('stylesheet_directory'); ?>/fonts/stylesheet.css' ] }
    };

  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
        '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })();
</script>

</head>

<body <?php body_class(); ?>>
<div class="content-pad">

<div class="top">
    <?php t_get_logo ('<div id="logo">', '</div>', 'logo.gif', true); ?>
    <div id="menu">
       <?php wp_nav_menu( array( 'id' => 'Menu', 'before' => '<span>', 'after' => '</span>' ) ); ?>
    </div>
</div> <!-- END top -->

<script type="text/javascript">
    jQuery(document).ready(function()
    {
       jQuery('#menu li.menu-item:last').addClass('last');
    });
</script>

<div class="clear"></div>
<div class="head-img">

  <?php if ($t_show_slideshow == 'hide') {}
  elseif (!isset($t_show_slideshow) || $t_show_slideshow == 'no') { // Display Slideshow ?>  
  <div class="slideshow-bg module">
    <div class="slideshow">
      <?php if ($t_scroll_pages == 'no' || $t_scroll_pages[0] == 'no' || $t_scroll_pages[0] == ''){
        echo '<div><div class="tagline">Welcome to Delicate template</div><img src="'.get_template_directory_uri().'/images/header/headers.jpg" alt="Header" /></div>';
        echo '<div><div class="tagline">Just another WordPress site</div><img src="'.get_template_directory_uri().'/images/header/header.jpg" alt="Header" /></div>';
      } else { 
        foreach ($t_scroll_pages as $ad_pgs ) { 
         query_posts('page_id='.$ad_pgs ); while (have_posts()) : the_post(); ?>
      <div>
        <div class="tagline"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
        <?php if ( has_post_thumbnail() ) {the_post_thumbnail('slide-thumb');} // 970x225 ?>
      </div>
      <?php endwhile; wp_reset_query(); ?>	
      <?php } //end foreach ?>  
    <?php } ?>  
    </div><!-- END Slideshow -->
    <div id="slideshow-nav"></div>
  </div> <!-- END slideshow-bg -->

  <?php } else { // Display Header Image    
    $header_image = get_header_image();
    if ( !empty( $header_image ) ) : ?>
      <div class="tagline"><?php bloginfo('description'); ?></div>
      <img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="Header" />
    <?php endif;     
  } // End if ?>
</div>

<div id="banner_content_block">
    <div id="banner_block">
        <?php echo do_shortcode('[bannerspace]'); ?>
    </div>
</div>
<!-- END Header -->