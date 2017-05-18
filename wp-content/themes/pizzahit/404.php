<?php
get_header();
?>
    <div class="error_404">
        <div class="container">
            <div>
            	<img src="<?php echo esc_url(gt3_get_theme_option('error_bg_img')); ?>"/>
            </div>
            <a href="<?php echo esc_url(home_url('/')) ?>" class=" shortcode_button btn_large btn_type1"><?php echo esc_html__('TAKE ME HOME', 'pizzahit') ?></a>
        </div>
    </div>
</div><!-- wrapper -->

<?php get_footer(); ?>
</body>
</html>
