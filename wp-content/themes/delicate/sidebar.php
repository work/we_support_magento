<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
    <h1 class="new_font block_title home_contact"><?php _e('Contact us'); ?></h1>
    <?php echo do_shortcode('[contact-form-7 id="22" title="Contact form 1"]'); ?>
<?php endif; ?> 

