<?php

/**
 * Option
 */
abstract class Option_admin_theme
{
    public $params = array();

    protected $template = '
    <div class="admin_mix-tab-control tab_{$ID}" style="{$OPTION_STYLE}">
        <div class="gt3_innerpadding" style="{$INNERPADDING_OPTION_STYLE}">
            <h2 class="gt3_option_heading">{$NAME}</h2>
            {$DESC}
            <div class="admin_input">
                {$INPUT}
            </div>
		</div>
	</div>';

    protected $vars = array(
        '{$ID}',
        '{$NAME}',
        '{$INPUT}',
        '{$DESC}',
        '{$OPTION_STYLE}',
        '{$INNERPADDING_OPTION_STYLE}'
    );

    protected $defaults = array(
        'id' => '',
        'name' => '',
        'desc' => '',
        'default' => '',
        'option_style' => '',
        'innerpadding_option_style' => ''
    );

    protected $value = '';
    protected $def_value = '';

    public function __construct(Array $params)
    {
        $this->params = array_merge($this->defaults, $params);


        $as_array = (isset($params['as_array'])) ? $params['as_array'] : FALSE;
        $this->def_value = (isset($params['default']) && !empty($params['default'])) ? $params['default'] : '';

        if (gt3_get_theme_option($params['id']) === null && (isset($params['default']) && strlen($params['default']) > 0)) {
            gt3_update_theme_option($params['id'], $params['default']);
        }

        if ($as_array) {
            $temp_value = gt3_get_theme_option($as_array);
            if (isset($temp_value[$params['id']])) {
                $this->value = $temp_value[$params['id']];
            } else {
                $this->value = $def_value;
            }
        } else {
            $this->value = stripslashes(gt3_get_theme_option($params['id'], (isset($params['default']) && !empty($params['default'])) ? $params['default'] : ''));
        }
    }

    public function render()
    {
        return str_replace($this->vars, array(
            $this->params['id'],
            $this->params['name'],
            $this->render_control(),
            $this->params['desc'],
            $this->params['option_style'],
            $this->params['innerpadding_option_style']
        ), $this->template);
    }

    abstract protected function render_control();
}


/**
 * Checkbox Option
 */
class CheckboxOption_admin_theme extends Option_admin_theme
{
    protected $template = '<div class="admin_mix-tab-control">
		<div class="admin_input">
			<ul class="inputs-list">
				<li>
					<label>
						{$INPUT}
						<span>{$NAME}</span>
					</label>
				</li>
			</ul>
			<span class="help-block">{$DESC}</span>
		</div>
	</div>';

    protected function render_control()
    {
        return '<input type="checkbox" name="' . $this->params['id'] . '" id="' . $this->params['id'] . '" value="1" ' . (!empty($this->value) ? 'checked="checked"' : '') . ' />';
    }
}


/**
 * Color Option
 */
class ColorOption_admin_theme extends Option_admin_theme
{
    protected function render_control()
    {
        if (empty($this->value) && $this->params['not_empty'] == true) {
            $this->value = $this->def_value;
        }		
		return '<div class="color_option_admin">
		<input class="medium cpicker admin_textoption type1" maxlength="25" type="text" name="' . $this->params['id'] . '" id="' . $this->params['id'] . '" ' . (!empty($this->value) ? 'value="' . htmlspecialchars($this->value) . '"' : '') . ' />
		</div>
		';		
    }
}

/**
 * Radio Option
 */
class RadioOption_admin_theme extends Option_admin_theme
{
    protected function render_control()
    {
        $control = '';
        foreach ($this->params['options'] as $ind => $val) {
            $control .= '<input type="radio" name="' . $this->params['id'] . '" value="' . $ind . '" ' . (($this->value == $ind) ? 'checked="checked"' : '') . ' /> ' . htmlspecialchars($val) . '<br />';
        }

        return $control;
    }
}


/**
 * Sidebar manager
 */
class SidebarManager_admin_theme extends Option_admin_theme
{
    protected function render_control()
    {

        $all_sidebars = gt3_get_theme_sidebars_for_admin();
        if (!isset($compile)) {
            $compile = '';
        }

        $compile .= '
        <div class="add_new_sidebar">
            <span class="caption">Create sidebar:</span> <input type="text" name="create_new_sidebar" class="admin_create_new_sidebar admin_textoption type3" value="">
            <input type="button" name="create_new_sidebar_btn" class="admin_create_new_sidebar_btn gt3_admin_button gt3_admin_ok_btn" value="Create">
        </div>
        <div class="admin_sidebars_list">';

        foreach ($all_sidebars as $key => $value) {
            $compile .= '
            <div class="admin_sidebar_item">
                <input type="hidden" name="theme_sidebars[]" value="' . esc_attr($value) . '">
                <span class="admin_sidebar_name admin_visual_style1">' . esc_attr($value) . '</span>
                <input type="button" class="admin_delete_this_sidebar admin_img_button cross" name="delete_this_sidebar" value="X">
            </div>';
        }

        $compile .= "</div>";

        return $compile;
    }
}


/**
 * Font selector
 */
class FontSelector_admin_theme extends Option_admin_theme
{
    protected function render_control()
    {
        if (!isset($compile)) {
            $compile = '';
        }

        $compile .= '
        <div class="fonts_list">';

        $compile .= '<select style="width:300px;" class="xlarge bg_hover1 fontselector" name="' . $this->params['id'] . '" id="' . $this->params['id'] . '">';
        $i = 0;
        foreach ($this->params['options'] as $key => $val) {
            if ($i == 0) {
                $compile .= '<option value="' . htmlspecialchars($this->def_value) . '" ' . (($this->value == $this->def_value) ? 'selected="selected"' : '') . '>Default</option>';
            }
            $compile .= '<option value="' . htmlspecialchars($val) . '" ' . (($this->value == $val) ? 'selected="selected"' : '') . '>' . htmlspecialchars($val) . '</option>';
            $i++;
        }
        $compile .= '</select>';

        $compile .= "</div>";
        //$compile .= "<div class='font_preview'>The quick brown fox jumps over the lazy dog</div>";
        $compile .= "<div class='clear'></div>";

        return $compile;
    }
}


/**
 * Select Option
 */
class SelectOption_admin_theme extends Option_admin_theme
{
    protected function render_control()
    {
        $control = '<select class="xlarge bg_hover1" name="' . $this->params['id'] . '" id="' . $this->params['id'] . '">';
        foreach ($this->params['options'] as $val => $name) {
            $control .= '<option value="' . htmlspecialchars($val) . '" ' . (($this->value == $val) ? 'selected="selected"' : '') . '>' . htmlspecialchars($name) . '</option>';
        }
        $control .= '</select>';

        return $control;
    }
}

/**
 * Text Option
 */
class TextOption_admin_theme extends Option_admin_theme
{
    protected function render_control()
    {

        if (isset($this->params['not_empty']) && (empty($this->value) && $this->params['not_empty'] == true)) {
            $this->value = $this->def_value;
        }

        if (isset($this->params['width']) && strlen($this->params['width']) > 0) {
            $wstyle = " width:" . $this->params['width'] . " !important; ";
        }

        if (isset($this->params['textalign']) && strlen($this->params['textalign']) > 0) {
            $textalign = " text-align:" . $this->params['textalign'] . " !important; ";
        }

        if (!isset($wstyle)) {
            $wstyle = '';
        }
        if (!isset($textalign)) {
            $textalign = '';
        }

        return '<input class="xxlarge admin_textoption type1" type="text" style="' . $wstyle . $textalign . '" name="' . $this->params['id'] . '" id="' . $this->params['id'] . '" ' . (!empty($this->value) ? 'value="' . htmlspecialchars($this->value) . '"' : '') . ' />';
    }
}

/**
 * Range Option
 */
class rangeOption_admin_theme extends Option_admin_theme
{
    protected function render_control()
    {

        if (isset($this->params['not_empty']) && (empty($this->value) && $this->params['not_empty'] == true)) {
            $this->value = $this->def_value;
        }

        #$this->params['min'];
        #$this->params['max'];
		#$this->params['unit'];
        #$this->params['step'];

	    wp_enqueue_script('range_js', get_template_directory_uri() . '/core/admin/js/jquery.nouislider.all.min.js');
				
        return '<input class="xxlarge admin_textoption type1 range_input" type="text" id="input-with-' . $this->params['id'] . '" name="' . $this->params['id'] . '" ' . (!empty($this->value) ? 'value="' . htmlspecialchars($this->value) . '"' : '') . '><div id="' . $this->params['id'] . '"></div>
			<script>
				jQuery(document).ready(function() {				
					var gt3_slider = jQuery("#' . $this->params['id'] . '"),
						gt3_input = jQuery("#input-with-' . $this->params['id'] . '");
					
					gt3_slider.noUiSlider({
						start: ' . htmlspecialchars($this->value) . ',
						step: ' . $this->params['step'] . ',
						decimals: "",
						range: {
							"min": ' . $this->params['min'] . ',
							"max": ' . $this->params['max'] . ',
						},
						format: wNumb({
							decimals: 0
						})
					});					
					gt3_slider.Link("lower").to(gt3_input);			
				});
			</script>			
		';			
    }
}


/**
 * Textarea Option
 */
class TextareaOption_admin_theme extends Option_admin_theme
{
    protected function render_control()
    {

        if (isset($this->params['not_empty']) && (empty($this->value) && $this->params['not_empty'] == true)) {
            $this->value = $this->def_value;
        }

        return '<textarea class="xxlarge admin_textareaoption type1" name="' . $this->params['id'] . '" id="' . $this->params['id'] . '" rows="5">' . (!empty($this->value) ? htmlspecialchars($this->value) : '') . '</textarea>';
    }
}

/**
 * Upload Option
 */
class image_admin_theme extends Option_admin_theme
{
    protected function render_control()
    {
        if (!isset($this->params['button_caption'])) {
            $this->params['button_caption'] = "Upload";
        }
        $control = gt3_select_image_from_media_button($this->params['id'], $this->value, $this->params['button_caption'], $this->params['default']);

        return $control;
    }
}

/**
 * Ajax Button Option
 */
class AjaxButtonOption_admin_theme extends Option_admin_theme
{
    protected function render_control()
    {
        return '<script>
			if (typeof window.ajaxButtonData == "undefined") {
				window.ajaxButtonData = {};
			}
			
			window.ajaxButtonData["' . $this->params['id'] . '"] = ' . json_encode($this->params['data']) . '
		</script>
		<a class="btn admin_mix_ajax_button gt3_admin_button" data-confirm="' . (empty($this->params['confirm']) ? 0 : 1) . '" data-id="' . $this->params['id'] . '">' . $this->params['title'] . '</a>
		<span></span>';
    }
}

?>