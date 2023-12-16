<?php

// ++++++++++++++++ custom post listing Shortcode ++++++++++++

add_shortcode("custom-blog-list","post_listing_shortcode");
function post_listing_shortcode()
 {
 ob_start();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	$atts = shortcode_atts( array(
		'category' => 'YOUR CATEGORY NAME HERE'
	), $atts );

	$args = array(
		'post_type' => 'post',
		'post_status'=>'publish',
		 'posts_per_page' => 5,
		 'order' => 'DESC',
		 'paged' => $paged,
		 'tax_query'         => array( array(
					'taxonomy'  => 'category',
					'field'     => 'slug',
					'terms'     => $atts,
				) )
	);

	$loop = new WP_Query( $args );
	if ( $loop->have_posts() ) {
		
		while ( $loop->have_posts() ) : $loop->the_post();
			//POST DISPLAY STUCTURE CREATE HERE
		endwhile;
		
		$total_pages = $loop->max_num_pages;

		if ($total_pages > 1){
			?>
			
			<div class="blog-pagination">
				<?php
				$current_page = max(1, get_query_var('paged'));

				echo paginate_links(array(
					'base' => get_pagenum_link(1) . '%_%',
					'format' => '/page/%#%',
					'current' => $current_page,
					'total' => $total_pages,
					'prev_text'    => __('« prev'),
					'next_text'    => __('next »'),
				));
				?>
			</div>
			<?php
		}    
	}
	wp_reset_postdata();
	?>
	<?php
	return ob_get_clean(); 
 }


// ********************** End custom post listing Shortcode ***********************





