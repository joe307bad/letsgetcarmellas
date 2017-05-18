<?php

$gt3_tabs_admin_theme = new Tabs_admin_theme();

$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
	'name' => 'General',
	'icon' => 'fa fa-cogs'
), array(
	new image_admin_theme(array(
        'name' => 'Logo (Retina)',
        'id' => 'logo_retina',
        'button_caption' => 'Add Image',
        'desc' => '<span class="gt3_help_block">Retina Default: 198px x 128px</span>',
        'default' => THEMEROOTURL . '/img/logo.png',
        'option_style' => 'width: 100%;',
        'innerpadding_option_style' => ''
    )),
	new rangeOption_admin_theme(array(
        'name' => 'Header logo width',
        'id' => 'logo_standart_width',
        'not_empty' => true,
        'default' => '198',
        'min' => '10',
        'max' => '198',
        'step' => '1',
        'unit' => 'px',
        'desc' => '<span class="gt3_help_block">Default: 198px</span>',
        'option_style' => 'width: 50%;',
        'innerpadding_option_style' => 'margin-right: 10px;'
    )),
    new rangeOption_admin_theme(array(
        'name' => 'Header logo height',
        'id' => 'logo_standart_height',
        'not_empty' => true,
        'default' => '128',
        'min' => '10',
        'max' => '128',
        'step' => '1',
        'unit' => 'px',
        'desc' => '<span class="gt3_help_block">Default: 128px</span>',
        'option_style' => 'width: 50%;',
        'innerpadding_option_style' => 'margin-left: 10px;'
    )),
	new image_admin_theme(array(
        'type' => 'upload',
        'name' => 'Favicon',
        'id' => 'favicon',
        'desc' => '<span class="gt3_help_block">Icon must be 16x16px or 32x32px. Please note that if you\'ve already uploaded the Site Icon in the Theme Customizer (Appearance -> Customize), the settings from the theme options panel will be ignored.</span>',
        'default' => THEMEROOTURL . '/img/favicon.png',
        'option_style' => 'width: 100%;'
    )),
	new image_admin_theme(array(
        'type' => 'upload',
        'name' => 'Apple touch icon (57px)',
        'id' => 'apple_touch_57',
        'desc' => '<span class="gt3_help_block">Icon must be 57x57px. Please note that if you\'ve already uploaded the Site Icon in the Theme Customizer (Appearance -> Customize), the settings from the theme options panel will be ignored.</span>',
        'default' => THEMEROOTURL . '/img/apple_icons_57x57.png',
        'option_style' => 'width: 100%;'
    )),
	new image_admin_theme(array(
        'type' => 'upload',
        'name' => 'Apple touch icon (72px)',
        'id' => 'apple_touch_72',
        'desc' => '<span class="gt3_help_block">Icon must be 72x72px. Please note that if you\'ve already uploaded the Site Icon in the Theme Customizer (Appearance -> Customize), the settings from the theme options panel will be ignored.</span>',
        'default' => THEMEROOTURL . '/img/apple_icons_72x72.png',
        'option_style' => 'width: 100%;'
    )),
	new image_admin_theme(array(
        'type' => 'upload',
        'name' => 'Apple touch icon (114px)',
        'id' => 'apple_touch_114',
        'desc' => '<span class="gt3_help_block">Icon must be 114x114px. Please note that if you\'ve already uploaded the Site Icon in the Theme Customizer (Appearance -> Customize), the settings from the theme options panel will be ignored.</span>',
        'default' => THEMEROOTURL . '/img/apple_icons_114x114.png',
        'option_style' => 'width: 100%;'
    )),
	new TextareaOption_admin_theme(array(
        'name' => esc_html__('Copyright', 'pizzahit'),
        'id' => 'footer_line_1',
        'option_style' => 'width: 100%;',
        'default' => 'Copyright &copy; 2017 Pizza HIT. All Rights Reserved.'
    )),
	new TextareaOption_admin_theme(array(
        'name' => 'Any code (before &lt;/head&gt;)',
        'id' => 'code_before_head',
        'option_style' => 'width: 100%;',
        'default' => ''
    )),
	new TextareaOption_admin_theme(array(
        'name' => 'Any code (before &lt;/body&gt;)',
        'id' => 'code_before_body',
        'option_style' => 'width: 100%;',
        'default' => ''
    ))
)));

$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
	'name' => 'Sidebars',
    'icon' => 'fa fa-trello'
), array(
	new SelectOption_admin_theme(array(
        'name' => 'Default sidebar layout',
        'id' => 'default_sidebar_layout',
        'desc' => '',
        'default' => 'no-sidebar',
        'option_style' => 'width: 100%;',
        'options' => array(
            'left-sidebar' => 'Left sidebar',
            'right-sidebar' => 'Right sidebar',
            'no-sidebar' => 'Without sidebar'
        )
    )),
	new SidebarManager_admin_theme(array(
        'name' => 'Sidebar manager',
        'id' => 'sidebar_manager',
        'option_style' => 'width: 100%;',
        'desc' => ''
    ))
)));

$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
	'name' => 'Fonts',
    'icon' => 'fa fa-font'
), array(
	new FontSelector_admin_theme(array(
        'name' => 'Main font',
        'id' => 'main_font',
        'desc' => '',
        'default' => 'Open Sans',
        'option_style' => 'width: 100%;',
        'options' => get_fonts_array_only_key_name()
    )),
	new textOption_admin_theme(array(
        'name' => 'Main font parameters',
        'id' => 'google_font_parameters_main_font',
        'not_empty' => true,
        'default' => ':100,200,300,400,400i,600,700',
        'width' => '100%',
        'textalign' => 'left',
        'option_style' => 'width: 100%;',
        'desc' => '<span class="gt3_help_block">Google font. Click <a href="https://developers.google.com/webfonts/docs/getting_started" target="_blank">here</a> for help.</span>'
    )),
    new textOption_admin_theme(array(
        'name' => 'Main font size',
        'id' => 'main_content_font_size',
        'not_empty' => true,
        'default' => '15px',
        'option_style' => 'width: 100%;',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'Main line height',
        'id' => 'main_content_line_height',
        'not_empty' => true,
        'default' => '22px',
        'option_style' => 'width: 100%;',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'Main font weight',
        'id' => 'content_weight',
        'not_empty' => true,
        'default' => '400',
        'option_style' => 'width: 100%;',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new FontSelector_admin_theme(array(
        'name' => 'Main menu font',
        'id' => 'main_menu_font',
        'desc' => '',
        'default' => 'Open Sans',
        'option_style' => 'width: 100%;',
        'options' => get_fonts_array_only_key_name()
    )),
    new textOption_admin_theme(array(
        'name' => 'Main menu font size',
        'id' => 'menu_font_size',
        'not_empty' => true,
        'default' => '14px',
        'option_style' => 'width: 100%;',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'Main menu font weight',
        'id' => 'menu_weight',
        'not_empty' => true,
        'default' => '700',
        'option_style' => 'width: 100%;',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'Sub menu font size',
        'id' => 'submenu_font_size',
        'not_empty' => true,
        'default' => '15px',
        'option_style' => 'width: 100%;',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
	new FontSelector_admin_theme(array(
        'name' => 'Headings Font',
        'id' => 'text_headers_font',
        'desc' => '',
        'default' => 'Rancho',
        'option_style' => 'width: 100%;',
        'options' => get_fonts_array_only_key_name()
    )),
	new textOption_admin_theme(array(
        'name' => 'Headings font parameters',
        'id' => 'google_font_parameters_headers_font',
        'not_empty' => true,
        'default' => ':400',
        'option_style' => 'width: 100%;',
        'width' => '100%',
        'textalign' => 'left',
        'desc' => '<span class="gt3_help_block">Google font. Click <a href="https://developers.google.com/webfonts/docs/getting_started" target="_blank">here</a> for help.</span>'
    )),
    new textOption_admin_theme(array(
        'name' => 'Headings weight',
        'id' => 'headers_weight',
        'not_empty' => true,
        'default' => '400',
        'option_style' => 'width: 100%;',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
	new textOption_admin_theme(array(
        'name' => 'H1 font size',
        'id' => 'h1_font_size',
        'not_empty' => true,
        'default' => '70px',
        'option_style' => 'width: 100%;',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'H1 line-height',
        'id' => 'h1_line_height',
        'not_empty' => true,
        'default' => '80px',
        'width' => '100px',
        'textalign' => 'center',
        'option_style' => 'width: 100%;',
        'innerpadding_option_style' => ''
    )),
	new textOption_admin_theme(array(
        'name' => 'H2 font size',
        'id' => 'h2_font_size',
        'not_empty' => true,
        'default' => '60px',
        'option_style' => 'width: 100%;',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'H2 line-height',
        'id' => 'h2_line_height',
        'not_empty' => true,
        'default' => '70px',
        'width' => '100px',
        'textalign' => 'center',
        'option_style' => 'width: 100%;',
        'innerpadding_option_style' => ''
    )),
	new textOption_admin_theme(array(
        'name' => 'H3 font size',
        'id' => 'h3_font_size',
        'not_empty' => true,
        'default' => '50px',
        'option_style' => 'width: 100%;',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'H3 line-height',
        'id' => 'h3_line_height',
        'not_empty' => true,
        'default' => '60px',
        'option_style' => 'width: 100%;',
        'width' => '100px',
        'textalign' => 'center',
        'option_style' => 'width: 100%;',
        'innerpadding_option_style' => ''
    )),
	new textOption_admin_theme(array(
        'name' => 'H4 font size',
        'id' => 'h4_font_size',
        'not_empty' => true,
        'default' => '40px',
        'option_style' => 'width: 100%;',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'H4 line-height',
        'id' => 'h4_line_height',
        'not_empty' => true,
        'default' => '50px',
        'width' => '100px',
        'textalign' => 'center',
        'option_style' => 'width: 100%;',
        'innerpadding_option_style' => ''
    )),
	new textOption_admin_theme(array(
        'name' => 'H5 font size',
        'id' => 'h5_font_size',
        'not_empty' => true,
        'default' => '30px',
        'option_style' => 'width: 100%;',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'H5 line-height',
        'id' => 'h5_line_height',
        'not_empty' => true,
        'default' => '35px',
        'width' => '100px',
        'textalign' => 'center',
        'option_style' => 'width: 100%;',
        'innerpadding_option_style' => ''
    )),
	new textOption_admin_theme(array(
        'name' => 'H6 font size',
        'id' => 'h6_font_size',
        'not_empty' => true,
        'default' => '26px',
        'option_style' => 'width: 100%;',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'H6 line-height',
        'id' => 'h6_line_height',
        'not_empty' => true,
        'default' => '30px',
        'width' => '100px',
        'textalign' => 'center',
        'option_style' => 'width: 100%;',
        'innerpadding_option_style' => ''
    ))
)));

$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
	'name' => 'Socials',
    'icon' => 'fa fa-users'
), array(
	new TextOption_admin_theme(array(
        'name' => esc_html__('Facebook', 'pizzahit'),
        'id' => 'social_facebook',
        'default' => 'http://facebook.com',
        'option_style' => 'width: 100%;',
        'desc' => '<span class="gt3_help_block">Please specify http:// to the URL</span>'
    )),
	new TextOption_admin_theme(array(
        'name' => esc_html__('Flickr', 'pizzahit'),
        'id' => 'social_flickr',
        'default' => '',
        'option_style' => 'width: 100%;',
        'desc' => '<span class="gt3_help_block">Please specify http:// to the URL</span>'
    )),
	new TextOption_admin_theme(array(
        'name' => esc_html__('Tumblr', 'pizzahit'),
        'id' => 'social_tumblr',
        'default' => '',
        'option_style' => 'width: 100%;',
        'desc' => '<span class="gt3_help_block">Please specify http:// to the URL</span>'
    )),
	new TextOption_admin_theme(array(
        'name' => esc_html__('Instagram', 'pizzahit'),
        'id' => 'social_instagram',
        'default' => 'http://instagram.com',
        'option_style' => 'width: 100%;',
        'desc' => '<span class="gt3_help_block">Please specify http:// to the URL</span>'
    )),
	new TextOption_admin_theme(array(
        'name' => esc_html__('Twitter', 'pizzahit'),
        'id' => 'social_twitter',
        'default' => 'http://twitter.com',
        'option_style' => 'width: 100%;',
        'desc' => '<span class="gt3_help_block">Please specify http:// to the URL</span>'
    )),
	new TextOption_admin_theme(array(
        'name' => esc_html__('Youtube', 'pizzahit'),
        'id' => 'social_youtube',
        'default' => '',
        'option_style' => 'width: 100%;',
        'desc' => '<span class="gt3_help_block">Please specify http:// to the URL</span>'
    )),
	new TextOption_admin_theme(array(
        'name' => esc_html__('Dribbble', 'pizzahit'),
        'id' => 'social_dribbble',
        'default' => 'http://dribbble.com/',
        'option_style' => 'width: 100%;',
        'desc' => '<span class="gt3_help_block">Please specify http:// to the URL</span>'
    )),
	new TextOption_admin_theme(array(
        'name' => esc_html__('Google+', 'pizzahit'),
        'id' => 'social_gplus',
        'default' => '',
        'option_style' => 'width: 100%;',
        'desc' => 'Please specify http:// to the URL'
    )),
	new TextOption_admin_theme(array(
        'name' => esc_html__('Vimeo', 'pizzahit'),
        'id' => 'social_vimeo',
        'default' => '',
        'option_style' => 'width: 100%;',
        'desc' => '<span class="gt3_help_block">Please specify http:// to the URL</span>'
    )),
	new TextOption_admin_theme(array(
        'name' => esc_html__('Delicious', 'pizzahit'),
        'id' => 'social_delicious',
        'default' => '',
        'option_style' => 'width: 100%;',
        'desc' => '<span class="gt3_help_block">Please specify http:// to the URL</span>'
    )),
	new TextOption_admin_theme(array(
        'name' => esc_html__('Linked In', 'pizzahit'),
        'id' => 'social_linked',
        'default' => '',
        'option_style' => 'width: 100%;',
        'desc' => '<span class="gt3_help_block">Please specify http:// to the URL</span>'
    )),
	new TextOption_admin_theme(array(
        'name' => esc_html__('Pinterest', 'pizzahit'),
        'id' => 'social_pinterest',
        'default' => '',
        'option_style' => 'width: 100%;',
        'desc' => '<span class="gt3_help_block">Please specify http:// to the URL</span>'
    )),
)));

$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
    'name' => 'Contacts',
    'icon' => 'fa fa-envelope'
), array(
    new TextOption_admin_theme(array(
        'name' => 'Postal address',
        'id' => 'contact_address',
        'default' => '121 King Street, Melbourne, Vic 3000',
        'option_style' => 'width: 100%;',
        'innerpadding_option_style' => ''
    )),
    new TextOption_admin_theme(array(
        'name' => 'Phone number',
        'id' => 'phone_number',
        'default' => '+1 (800) 456 37 96',
        'option_style' => 'width: 100%;',
        'innerpadding_option_style' => ''
    )),
    new TextOption_admin_theme(array(
        'name' => 'Send mails to',
        'id' => 'contact_email',
        'default' => get_option("admin_email"),
        'option_style' => 'width: 100%;',
        'innerpadding_option_style' => ''
    )),
    new TextOption_admin_theme(array(
        'name' => esc_html__('Timetable title', 'pizzahit'),
        'id' => 'timetable_title',
        'option_style' => 'width: 100%;',
        'width' => '100%',
        'default' => 'You Are Always Welcome Here'
    )),
    new TextOption_admin_theme(array(
        'name' => esc_html__('Timetable text', 'pizzahit'),
        'id' => 'timetable_text',
        'option_style' => 'width: 100%;',
        'width' => '100%',
        'default' => 'Mn - St: 8:00am - 9:00pm Sn: Closed'
    )),
)));

$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
    'name' => 'View Options',
    'icon' => 'fa fa-file-image-o'
), array(
    new SelectOption_admin_theme(array(
        'name' => 'Responsive',
        'id' => 'responsive',
        'desc' => '',
        'default' => 'on',
        'option_style' => 'width: 100%;',
        'options' => array(
            'on' => 'On',
            'off' => 'Off'
        )
    )),
    new SelectOption_admin_theme(array(
        'name' => 'Preloader',
        'id' => 'show_preloader',
        'desc' => '',
        'default' => 'on',
        'option_style' => 'width: 100%;',
        'options' => array(
            'on' => 'On',
            'off' => 'Off'
        )
    )),
    new image_admin_theme(array(
        'type' => 'upload',
        'name' => 'Preloader Image',
        'id' => 'preloader_img',
        'desc' => '',
        'default' => THEMEROOTURL . '/img/preloader2.gif',
        'option_style' => 'width: 100%;'
    )),
    new SelectOption_admin_theme(array(
        'name' => 'Sticky Header',
        'id' => 'header_style',
        'desc' => '',
        'default' => 'sticky_off',
        'option_style' => 'width: 100%;',
        'options' => array(
            'sticky_on' => 'On',
            'sticky_off' => 'Off'
        )
    )),
    new image_admin_theme(array(
        'type' => 'upload',
        'name' => 'Error 404 page background image',
        'id' => 'error_bg_img',
        'desc' => '',
        'default' => THEMEROOTURL . '/img/404_back.png',
        'option_style' => 'width: 100%;'
    )),
    new SelectOption_admin_theme(array(
        'name' => 'Related Posts',
        'id' => 'related_posts',
        'desc' => '',
        'default' => 'on',
        'option_style' => 'width: 100%;',
        'options' => array(
            'on' => 'On',
            'off' => 'Off'
        )
    )),
    new SelectOption_admin_theme(array(
        'name' => 'Page comments',
        'id' => 'page_comments',
        'desc' => '',
        'default' => 'enabled',
        'option_style' => 'width: 100%;',
        'options' => array(
            'disabled' => 'Disabled',
            'enabled' => 'Enabled'
        )
    )),
    new SelectOption_admin_theme(array(
        'name' => 'Post comments',
        'id' => 'post_comments',
        'desc' => '',
        'default' => 'enabled',
        'option_style' => 'width: 100%;',
        'options' => array(
            'disabled' => 'Disabled',
            'enabled' => 'Enabled'
        )
    )),
    new SelectOption_admin_theme(array(
        'name' => esc_html__('Trackbacks and Pingbacks', 'pizzahit'),
        'id' => 'post_pingbacks',
        'desc' => '',
        'default' => 'disabled',
        'option_style' => 'width: 100%;',
        'options' => array(
            'disabled' => esc_html__('Disabled', 'pizzahit'),
            'enabled' => esc_html__('Enabled', 'pizzahit')
        )
    )),
    new TextareaOption_admin_theme(array(
        'name' => 'Custom CSS',
        'id' => 'custom_css',
        'default' => '',
        'option_style' => 'width: 100%;'
    )),
    new TextareaOption_admin_theme(array(
        'name' => esc_html__('Footer Instagram Feed Shortcode', 'pizzahit'),
        'id' => 'footer_instagram_feed_shortcode',
        'option_style' => 'width: 100%;',
        'default' => ''
    )),
    new SelectOption_admin_theme(array(
        'name' => 'Contacts area (Header left part)',
        'id' => 'contacts_area_left_header',
        'desc' => '',
        'default' => 'disabled',
        'option_style' => 'width: 100%;',
        'options' => array(
            'disabled' => 'Disabled',
            'enabled' => 'Enabled'
        )
    )),
    new SelectOption_admin_theme(array(
        'name' => 'Timetable area (Header right part)',
        'id' => 'timetable_area_right_header',
        'desc' => '',
        'default' => 'disabled',
        'option_style' => 'width: 100%;',
        'options' => array(
            'disabled' => 'Disabled',
            'enabled' => 'Enabled'
        )
    ))
)));

$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
	'name' => 'Color Options',
    'icon' => 'fa fa-paint-brush'
), array(
	new ColorOption_admin_theme(array(
        'name' => 'Theme Color',
        'id' => 'theme_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '#dd3601',
        'option_style' => 'width: 100%;'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Buttons Hover Color',
        'id' => 'hover_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '#ff511a',
        'option_style' => 'width: 100%;'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Arrow Button Color',
        'id' => 'arrow_button_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '#fed501',
        'option_style' => 'width: 100%;'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Arrow Buttons Hover Color',
        'id' => 'arrow_button_hover_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '#ffdf38',
        'option_style' => 'width: 100%;'
    )),
	new ColorOption_admin_theme(array(
        'name' => 'Header Background',
        'id' => 'header_bg_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '#ffffff',
        'option_style' => 'width: 100%;'
    )),
	new ColorOption_admin_theme(array(
        'name' => 'Footer Background',
        'id' => 'footer_bg_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '#1d2326',
        'option_style' => 'width: 100%;'
    )),
	new ColorOption_admin_theme(array(
        'name' => 'Headings Color',
        'id' => 'headings_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '#353638',
        'option_style' => 'width: 100%;'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Header Color',
        'id' => 'header_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '#353638',
        'option_style' => 'width: 100%;'
    )),
	new ColorOption_admin_theme(array(
        'name' => 'Footer Color',
        'id' => 'footer_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '#ffffff',
        'option_style' => 'width: 100%;'
    )),
	new ColorOption_admin_theme(array(
        'name' => 'Content Color',
        'id' => 'content_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '#757678',
        'option_style' => 'width: 100%;'
    )),
	new ColorOption_admin_theme(array(
        'name' => 'Main Menu Color',
        'id' => 'menu_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '#353638',
        'option_style' => 'width: 100%;'
    )),
	new ColorOption_admin_theme(array(
        'name' => 'Sub-menu color',
        'id' => 'submenu_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '#ffffff',
        'option_style' => 'width: 100%;'
    )),
	new ColorOption_admin_theme(array(
        'name' => 'Sub-menu Background',
        'id' => 'submenu_bg',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '#1d2326',
        'option_style' => 'width: 100%;'
    ))
)));

#WOOCOMMERCE
$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
    'name' => 'Woocommerce',
    'icon' => 'fa fa-shopping-cart'
), array(
    new TextOption_admin_theme(array(
        'name' => 'Shop items per page',
        'id' => 'woo_shop_items_per_page',
        'not_empty' => true,
        'width' => '100px',
        'textalign' => 'center',
        'default' => '6',
        'option_style' => 'width: 100%;',
        'desc' => '<span class="gt3_help_block">Please enter the number of items to display on the page.</span>'
    )),
    new TextOption_admin_theme(array(
        'name' => 'Shop related products',
        'id' => 'woo_related_products',
        'not_empty' => true,
        'width' => '100px',
        'textalign' => 'center',
        'default' => '3',
        'option_style' => 'width: 100%;',
        'desc' => '<span class="gt3_help_block">Please enter the number of related products.</span>'
    ))
)));