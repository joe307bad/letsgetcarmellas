<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

#main gt3_photo_gallery settings
$GLOBALS["gt3_photo_gallery_defaults"] = 
	array(
		'gt3pg_link_to' => 'file',
		'gt3pg_size' => 'thumbnail',
		'gt3pg_columns' => 3,
		'gt3pg_rand_order' => 'off',
		'gt3pg_thumbnail_type' => 'rectangle', 
		'gt3pg_corner_type' => 'standard', 
		'gt3pg_margin' => 30, 
		'gt3pg_border' => 'off', 
		'gt3pg_border_col' => '#dddddd', 
		'gt3pg_border_padding' => 0, 
		'gt3pg_border_size' => 1,
		'gt3pg_text_before_head' => ''
	);

$GLOBALS["gt3_photo_gallery"] = array();