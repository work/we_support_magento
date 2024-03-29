<?php get_header(); ?> 
<div id="main">		
	<div class="columns">      
    <div class="narrowcolumn singlepage <?php if (is_page('79')):?>no_sidebar<?php endif; ?>">
     <?php if (have_posts()) : ?>
     <?php while (have_posts()) : the_post(); ?>							
			<div class="post">
            	
                <div class="title"><h2><?php the_title(); ?></h2></div>                
				<div class="entry">
                     <?php t_show_video($post->ID); ?>
                     <?php the_content(); ?>    
                    <div class="clear"></div>
                </div>   
				<p class="postmetadata">	               
                <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>                    	
                <?php edit_post_link(__('Edit','nattywp'), '<p>', '</p>'); ?>	
				</p>                   
			</div>	    
			<?php comments_template( '', true ); ?>      	
	<?php endwhile; ?>		
    <?php endif; ?>				
	</div> <!-- END Narrowcolumn -->
    <?php if (!is_page('79')): ?>
        <div id="sidebar" class="profile">
          <?php if (!function_exists('dynamic_sidebar') || (!is_active_sidebar(2))) {
            get_sidebar();
          } else {
            echo '<ul>';
            dynamic_sidebar('sidebar-2');
            echo '</ul>';
          } ?>
        </div>
    <?php endif; ?>
<div class="clear"></div>
</div> <!-- END Columns -->
</div><!-- END main -->
<?php get_footer(); ?> 