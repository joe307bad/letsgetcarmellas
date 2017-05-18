<?php

class pricetable
{

    public function register_shortcode($shortcodeName)
    {
        function shortcode_pricetable($atts, $content = null)
        {

            $compile = '';

            extract(shortcode_atts(array(
                'heading_alignment' => 'center',
				'subtitle_text' => '',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'price_items_number' => '1',
                'heading_style' => 'yes',
            ), $atts));

            #heading
            $compile .= '<div class="module_wrapper">';
            if (strlen($heading_color) > 0) {
                $custom_color = "color:#{$heading_color};";
            }
			if (strlen($subtitle_text) > 0) {
				$subtitle_code = "<span class='subtitle'>". $subtitle_text ."</span>";
			} else {
				$subtitle_code = "";
			}			
            if (strlen($heading_text) > 0) {
                $compile .= "<div class='bg_title " .((strlen($heading_alignment) > 0 && ($heading_alignment == 'center')) ? 'centered' : '') . "' style='" .((strlen($heading_alignment) > 0) ? 'text-align:'.$heading_alignment.'; ' : '') . "'><".$heading_size." style='". (isset($custom_color) ? $custom_color : '') . "' class='headInModule'>{$heading_text}</".$heading_size.">". $subtitle_code . (($heading_style == 'yes') ? "<div class='heading_title_divider'></div>" : '') . "</div>";
            }


            $compile .= '<div class="module_price_table price_table_wrapper">' . do_shortcode($content) . '</div>';

            $compile .= '</div>';
            return $compile;

        }

        add_shortcode($shortcodeName, 'shortcode_pricetable');
    }
}

#Shortcode name
$shortcodeName = "pricetable";
$shortcode_pricetable = new pricetable();
$shortcode_pricetable->register_shortcode($shortcodeName);

#for pricetable_item
class pricetable_item
{
    public function register_shortcode($name)
    {
        function shortcode_pricetable_item($atts, $content = null)
        {
            extract(shortcode_atts(array(
                'block_link' => '',
                'get_it_now_caption' => '',
                'most_popular' => '',
                'price_features' => "",
                'block_price' => "",
				'block_currency' => "",
                'block_name' => "",
                'block_period' => "",
                'width' => "",
            ), $atts));

            $price_features = explode("||-||", $price_features);

            $compile = '';
            $compile .= '
                <div class="price_item '.($most_popular == "yes" ? 'most_popular' : '').'" style="width:' . $width . '%;">
                    <div class="price_item_wrapper">
						<div class="price_item_title">' . (strlen($block_name.$block_currency.$block_price.$block_period) ? '<h4>' . $block_name . '</h4><div class="item_cost_wrapper"><h3><span>' . $block_currency . '</span>' . ((strlen($block_price) && strpos('.', $block_price) !== false) ? str_replace('.', '<span>.', $block_price) . '</span>': $block_price) . '</h3><p>' . $block_period . '</p>
                            </div><!-- .item_cost_wrapper --></div>': '') . 

						'<div class="price_item_body"><div class="items_text">';

            if (isset($price_features) && is_array($price_features)) {
                foreach ($price_features as $value) {
                    $compile .= '<div class="price_item_text">'.esc_attr($value).'</div>';
                }
            }
			$compile .= '
				</div><div class="price_item_btn ' . $most_popular . '">';
				if (isset($get_it_now_caption) && $get_it_now_caption !== '') {
					if ($most_popular == "yes") {
						$compile .= '<a href="'.$block_link.'" class="shortcode_button btn_large btn_type3">'.$get_it_now_caption.'</a>';
					} else {
						$compile .= '<a href="'.$block_link.'" class="shortcode_button btn_large btn_type3">'.$get_it_now_caption.'</a>';
					}
				}
			$compile .= '
				</div>		
			</div>	
		</div>
	</div>
            ';

            return $compile;

        }
        add_shortcode($name, 'shortcode_pricetable_item');
    }
}

$pricetable_item = new pricetable_item();
$pricetable_item->register_shortcode("pricetable_item");

?>