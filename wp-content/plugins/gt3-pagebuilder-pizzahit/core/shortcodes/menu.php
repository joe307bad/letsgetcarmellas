<?php

class menu {

    public function register_shortcode($shortcodeName) {
        function shortcode_menu($atts, $content = null) {

            if (!isset($compile)) {$compile='';}

            extract( shortcode_atts( array(
                'heading_alignment' => 'center',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'subtitle_text' => '',
                'heading_text' => '',
                'module' => '',
                'text' => '',
                'heading_style' => 'yes',
                'menu_view_type' => '',
                'menu_type' => '',
                'prod_cat' => '',
                'prod_ids' => ''
            ), $atts ) );

            #heading
            $compile .= '<div class="module_wrapper">';
            if (strlen($subtitle_text) > 0) {
                $subtitle_code = "<span class='subtitle'>". $subtitle_text ."</span>";
            } else {
                $subtitle_code = "";
            }
            if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
            if (strlen($heading_text)>0) {
                $compile .= "<div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : '') . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.'; ' : '') . "'><".$heading_size." style='". (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>{$heading_text}</".$heading_size.">". $subtitle_code . (($heading_style == 'yes') ? "<div class='heading_title_divider'></div>" : '') . "</div>";
            }

            $compile .= '
                <div class="products_container view_type_' . $menu_view_type . '">

                    ';

                /* Listing by Categories */
                if ($menu_type == 'type1') {

                    $compile .= do_shortcode('[product_category category="' . $prod_cat . '"]');
                }

                /* Listing by IDs */
                else {				
				
                    $compile .= do_shortcode('[products ids="' . $prod_ids . '" orderby="date" order="desc"]');
                }
            $compile .= '
                    <div class="clear"></div>
                    <div class="prod_divider"></div>
                </div><!-- products_container -->
            </div>
            ';

            return $compile;
        }
        add_shortcode($shortcodeName, 'shortcode_menu');
    }
}

#Shortcode name
$shortcodeName="menu";
$shortcode_menu = new menu();
$shortcode_menu->register_shortcode($shortcodeName);
?>
