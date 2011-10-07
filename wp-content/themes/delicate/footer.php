<?php 
$t_timeout = t_get_option('t_timeout');  
$t_slide_speed = t_get_option('t_slide_speed'); 
$t_slide_effect = t_get_option('t_slide_effect'); 
?>

<div id="footer">
    <div class="footer_block" id="footer_menu">
       <?php wp_nav_menu( 'id=Menu' ); ?>
    </div>
    <div class="footer_line"></div>
    <div class="footer_block footer_block_bottom">
        <div class="footer_cont_block">
            <h1><?php _e('Get Magento support'); ?></h1>
            <p class="phone_block"><?php _e('380-33-567-67'); ?></p>
            <p class="email_block"><?php _e('mail@wesupportmagento.com'); ?></p>
        </div>
    </div>
</div>
    
</div>  
<div class="clear"></div>

<?php $t_tracking = t_get_option( "t_tracking" );
if ($t_tracking != ""){
	echo stripslashes(stripslashes($t_tracking));
	}
?>

<?php wp_footer(); ?>

<script type="text/javascript">
    jQuery(document).ready(function()
    {
       jQuery('#footer_menu li.menu-item:last').addClass('last');
    });
</script>

<script type="text/javascript" charset="utf-8">
<?php if (t_get_option('t_cufon_replace') == 'yes') { ?>	Cufon.now(); <?php } ?>	
	jQuery(document).ready(function() {
			$j('.slideshow').cycle({
				fx: '<?php if(!isset($t_slide_effect) || $t_slide_effect == 'no') {echo 'fade';} else {echo $t_slide_effect;} ?>',
				timeout: <?php if(!isset($t_timeout) || $t_timeout == 'no') {echo '5000';} else {echo $t_timeout;} ?>,
				pager: '#slideshow-nav',
				speed: <?php if(!isset($t_slide_speed) || $t_slide_speed == 'no') {echo '1000';} else {echo $t_slide_speed;} ?>,
				//prev: '#left-arrow',
        //next: '#right-arrow',
				pagerEvent: 'click',
    		pauseOnPagerHover: true,
				cleartypeNoBg: true });						
	  });		
	</script>     
</body>
</html>