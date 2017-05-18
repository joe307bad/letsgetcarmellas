<?php

function theme_add_admin()
{

  #Settings page
	add_theme_page( 'pizzahit', 'Pizza HIT', 'administrator', 'pizzahit_options', 'theme_options' );

}

add_action('admin_menu', 'theme_add_admin');

?>