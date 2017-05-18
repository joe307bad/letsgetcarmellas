<?php
#Register portfolio
function my_post_type_port()
{
    #Team
    register_post_type('team', array(
            'label' => __('Team', 'gt3_builder'),
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array(
                'slug' => 'team',
                'with_front' => false
            ),
            'hierarchical' => true,
            'menu_position' => 6,
            'supports' => array(
                'title',                
                'page-attributes',
                'editor',
                'excerpt',
                'thumbnail')
        )
    );
	
    #Gallery
    register_post_type('gallery', array(
            'label' => __('Gallery', 'gt3_builder'),
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array(
                'slug' => 'gallery',
                'with_front' => false
            ),
            'hierarchical' => true,
            'menu_position' => 4,
            'supports' => array(
                'title',				
				'thumbnail'
            )
        )
    );
	register_taxonomy('gallerycat', 'gallery', array('hierarchical' => true, 'label' => __('Category', 'gt3_builder'), 'singular_name' => 'Category'));

    #Testimonials
    $labels = array(
        'name' => __('Testimonials', 'gt3_builder'),
        'add_new_item' => __('Add New', 'gt3_builder')
    );
    register_post_type('testimonials', array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array(
                'slug' => 'testimonials',
                'with_front' => false
            ),
            'hierarchical' => true,
            'menu_position' => 7,
            'supports' => array(
                'title',
                'editor',
                'thumbnail'
            )
        )
    );

}

add_action('init', 'my_post_type_port');
?>