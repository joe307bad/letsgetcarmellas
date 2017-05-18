<?php

class gt3_menu_walker extends Walker
{

    function __construct($showtitles = false)
    {
        $this->showtitles = $showtitles;
    }

    var $tree_type = array('post_type', 'taxonomy', 'custom');
    var $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');

    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        if (!isset($GLOBALS['gt3_megamenu_started']) || (($GLOBALS['gt3_megamenu_started'] == true && $depth == 0) || $GLOBALS['gt3_megamenu_started'] == false)) {
            $output .= "\n$indent<div class=\"sub-nav\"><ul class=\"sub-menu\">\n";
        }
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        if (!isset($GLOBALS['gt3_megamenu_started']) || (($GLOBALS['gt3_megamenu_started'] == true && $depth == 0) || $GLOBALS['gt3_megamenu_started'] == false)) {
            $output .= "$indent</ul></div>\n";
        }
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array)$item->classes;

        $gt3_megamenu_status = get_post_meta($item->ID, 'gt3_megamenu_status', true);

        if ($depth == 0 && $gt3_megamenu_status == 'enabled') {
            $gt3_megamenu_columns = get_post_meta($item->ID, 'gt3_megamenu_columns', true);
            $GLOBALS['gt3_megamenu_started'] = true;
            $classes[] = 'gt3-mega-menu gt3-mega-menu-columns-' . $gt3_megamenu_columns;
        }
        if (($depth == 0 && $gt3_megamenu_status == 'disabled') || $gt3_megamenu_status == '') {
            $GLOBALS['gt3_megamenu_started'] = false;
        }

        $classes[] = 'menu-item-' . $item->ID;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        $output .= $indent . '<li' . $id . $class_names . '>';
        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        $item_output = '';
        if (isset($args->before)) $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';

        $gt3_select_icon_ultimate = get_post_meta($item->ID, 'gt3_select_icon_ultimate', true);

        if ($depth > 0 && strlen($gt3_select_icon_ultimate) > 0) {
            $item_output .= '<i class="' . $gt3_select_icon_ultimate . '"></i> ';
        }

        if (isset($args->link_before)) $item_output .= $args->link_before;
        $item_output .= apply_filters('the_title', $item->title, $item->ID);
        if (isset($args->link_after)) $item_output .= $args->link_after;

        $item_output .= '</a>';
        if (isset($args->after)) $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    function end_el(&$output, $item, $depth = 0, $args = array())
    {
        $output .= "</li>\n";
    }

}