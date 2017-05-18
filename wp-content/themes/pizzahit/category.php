<?php
get_header();
#Emulate default settings for page without personal ID
$gt3_theme_pagebuilder = gt3_get_default_pb_settings();
$gt3_current_page_sidebar = $gt3_theme_pagebuilder['settings']['layout-sidebars'];
?>
	<div class="container">
        <div class="content_block <?php echo esc_attr($gt3_theme_pagebuilder['settings']['layout-sidebars']) ?>">
            <div class="fl-container <?php echo(($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") ? "hasRS" : ""); ?>">
                <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "<div class='row'>" : ""); ?>
                    <div class="posts-block <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "hasLS" : ""); ?>">
                        <div class="contentarea">
                            <div class="row">
                                <div class="col-sm-12 module_blog <?php echo (($gt3_theme_pagebuilder['settings']['layout-sidebars'] !== 'no-sidebar') ? 'with_sidebar' : 'without_sidebar') ?>">
                                    <div class="module_blog_listing">
                                        <?php
                                        while (have_posts()) : the_post();
                                            get_template_part("bloglisting");
                                        endwhile;
                                        ?>
                                    </div>
                                    <div class="post_divider_wrapper">
                                        <div class="post_divider"></div>
                                    </div>
                                    <?php
                                    echo gt3_get_theme_pagination();
                                    ?>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                    <?php get_sidebar('left'); ?>
                <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "</div>" : ""); ?>        
            </div>
            <?php get_sidebar('right'); ?>
            <div class="clear"></div>
        </div>    	    
    </div>
    
<?php get_footer(); ?>