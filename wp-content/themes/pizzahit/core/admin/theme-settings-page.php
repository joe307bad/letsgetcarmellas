<?php

if (gt3_get_theme_option("theme_already_installed") !== "true") {
    $gt3_tabs_admin_theme->reset_to_default();
    gt3_update_theme_option("theme_already_installed", "true");
    header('Location: admin.php?page=' . GT3_THEMESHORT . 'options');
    exit;
}

function theme_options()
{

    global $gt3_tabs_admin_theme;

    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }

    $gt3_theme = wp_get_theme();
    ?>

    <script>
        var gt3_admin_ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
    </script>
    <form action="" method="post" class="admin_page_settings">
        <input type="hidden" id="form-tab-id" name="tab" value="<?php if (isset($_POST['tab'])) {
            echo esc_attr($_POST['tab']);
        } ?>"/>
        <input type="hidden" id="what_open_after_save" name="what_open_after_save" value=""/>

        <div class="gt3_admin_wrap">
            <div class="gt3_inner_wrap">
                <div class="gt3_main_line">
                    <div class="gt3_themename"><?php echo GT3_THEMENAME; ?> <span
                            class="gt3_theme_ver"><?php echo esc_attr($gt3_theme['Version']); ?></span></div>
                    <div class="gt3_links">
                        <?php
                        if (GT3_SHOWOURLINKSINADMIN == true) {
                            echo '
                            <a href="http://www.gt3themes.com/helpdesk/documentation/" target="_blank">Documentation</a>
                            <a href="http://forums.gt3themes.com" target="_blank">Support Forum</a>
                            ';
                        }
                        ?>
                    </div>
                    <div class="clear"></div>
                </div>
                <?php echo $gt3_tabs_admin_theme->render(); ?>
                <div class="clear"></div>
            </div>
        </div>
    </form>

<?php
}