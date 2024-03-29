<?php get_header();?>      

<?php 
$t_show_post = t_get_option ("t_show_post");	
?>    

<div id="main">		
	<div class="columns">        
     <div class="narrowcolumn">
     <?php if (have_posts()) : ?>
     <?php while (have_posts()) : the_post(); ?>							
			<div <?php post_class();?>>

				<div class="entry">
            <?php 
                if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
                      the_post_thumbnail('thumbnail');} 
                if ($t_show_post == 'no') {//excerpt                    
                    the_excerpt();   
                } else { //fullpost 
                    t_show_video($post->ID);
                    the_content(); ?>  
                <div id="morepage-list"><?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?></div>                       
            <?php } ?>
            <div class="clear"></div>
       </div>              
                
				<p class="postmetadata">	
           <span class="category"><?php the_tags('', ', ', ''); ?></span>   
				</p>
			</div>			
	<?php endwhile; ?>	
    		
		<div id="navigation">
		<?php natty_pagenavi(); ?>
		</div>    
        
    <?php else : 
		echo '<div class="post">';
		if ( is_category() ) { // If this is a category archive
			printf(__('<h2 class=\'center\'>Sorry, but there aren\'t any posts in the %s category yet.</h2>','nattywp'), single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			_e('<h2>Sorry, but there aren\'t any posts with this date.</h2>','nattywp');
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf(__('<h2 class=\'center\'>Sorry, but there aren\'t any posts by %s yet.</h2>','nattywp'), $userdata->display_name);
		} else {
      _e('<h2 class=\'center\'>No posts found.</h2>','nattywp');
		}
		get_search_form();	
		echo '</div>';		
	endif; ?>
	
 </div> <!-- END Narrowcolumn -->
    <?php if (!is_page('79')): ?>
       <div id="sidebar" class="profile">
         <?php get_sidebar();?>
       </div>
    <?php endif; ?>
<div class="clear"></div>
</div> <!-- END Columns -->
</div><!-- END main -->
<?php get_footer(); ?> 