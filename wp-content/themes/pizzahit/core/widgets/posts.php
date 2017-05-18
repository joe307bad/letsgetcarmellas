<?php
class posts extends WP_Widget {

	function posts() {
		parent::__construct( false, 'Posts (current theme)' );
	}

	function widget( $args, $instance ) {
		extract($args);

        echo $before_widget;
        echo $before_title;
        echo $instance['widget_title'];
        echo $after_title;

		$postsArgs = array(
		'showposts'     => $instance['posts_widget_number'],
		'offset'          => 0,
		'orderby'         => 'date',
		'order'           => 'DESC',
		'post_type'       => 'post',
		'post_status'     => 'publish'
        );

        $firstCat = get_the_category( get_the_ID() );
        $readmorelinktext = esc_html__('Read more!','pizzahit');
        $compilepopular = '';

		$wp_query_posts = new WP_Query();
		$wp_query_posts->query($postsArgs);
		while ($wp_query_posts->have_posts()) : $wp_query_posts->the_post();
            $gt3_theme_featured_image_latest = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()));

		$compilepopular .= '
			<li ' . ((!empty($gt3_theme_featured_image_latest)) ? 'class="with_img"' : '') . '>
			    <div class="recent_posts_container">';

            if (empty($gt3_theme_featured_image_latest)) {
                $widg_img = '';
            } else {
                $widg_img = '<img src="' . aq_resize($gt3_theme_featured_image_latest[0], 90, 90, true, true, true) . '" alt="' . esc_html(get_the_title()) . '">';
            }

            if (get_the_category()) $categories = get_the_category();

            if ($categories) {
                $post_categ = '';
                foreach ($categories as $category) {
                    $post_categ = $post_categ . '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->cat_name) . '</a>' . ', ';
                }
                $post_category_compile = trim($post_categ, ', ');
            }

$compilepopular .= '
					<div class="recent_posts_content">
					    <div class="recent_post_img">
                            <a href="' . esc_url(get_permalink()) . '">
                                ' . $widg_img . '
                            </a>
                        </div>
						<a class="post_title" href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a>
						<div class="featured_items_meta">
							<span class="post_date">' . esc_html(get_the_time(get_option('date_format'))) . '</span>
						</div>
					</div>
					<div class="clear"></div>
				</div>                
			</li>
		';
		endwhile;
		wp_reset_postdata();
		echo '
			<ul class="recent_posts">
				'.$compilepopular.'
			</ul>
		';

		#END OUTPUT

		echo $after_widget;
	}


	function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['widget_title'] = esc_attr( $new_instance['widget_title'] );
        $instance['posts_widget_number'] = absint( $new_instance['posts_widget_number'] );

        return $instance;
	}

	function form( $instance ) {
        $defaultValues = array(
            'widget_title' => 'Posts',
            'posts_widget_number' => '2'
        );
        $instance = wp_parse_args((array) $instance, $defaultValues);
	?>
		<table class="fullwidth">
            <tr>
				<td>Title:</td>
				<td><input type='text' class="fullwidth" name='<?php echo $this->get_field_name( 'widget_title' ); ?>' value='<?php echo esc_attr($instance['widget_title']); ?>'/></td>
			</tr>
			<tr>
				<td>Number:</td>
				<td><input type='text' class="fullwidth" name='<?php echo $this->get_field_name( 'posts_widget_number' ); ?>' value='<?php echo esc_attr($instance['posts_widget_number']); ?>'/></td>
			</tr>
		</table>
	<?php
	}
}

function posts_register_widgets() { register_widget( 'posts' ); }
add_action( 'widgets_init', 'posts_register_widgets' );

?>