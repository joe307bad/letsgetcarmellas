<?php

#main pb block settings
$GLOBALS["pbconfig"]['slider_and_bg_area'] = true;
$GLOBALS["pbconfig"]['slider_and_bg_area_enable_for'] = array('gallery', 'post', 'port', 'page');

#background / slider settings
$GLOBALS["pbconfig"]['enable_fullscreen_slider'] = true;
$GLOBALS["pbconfig"]['enable_fullwidth_slider'] = false;
$GLOBALS["pbconfig"]['enable_background_image'] = true;
$GLOBALS["pbconfig"]['enable_background_color'] = true;

#For this post types we enable page builder
$GLOBALS["pbconfig"]['page_builder_enable_for_posts'] = array('post', 'port', 'page', 'gallery', 'testimonials', 'partners', 'team', 'model');

#detail settings for page customization
$GLOBALS["pbconfig"]['pb_modules_enabled_for'] = array('page', 'port');
$GLOBALS["pbconfig"]['page_settings_enabled_for'] = array('page', 'post', 'team', 'port');
$GLOBALS["pbconfig"]['fullcreen_slider_enabled_for'] = array('gallery');
$GLOBALS["pbconfig"]['fullwidth_slider_enabled_for'] = array();
$GLOBALS["pbconfig"]['bg_image_enabled_for'] = array('post', 'port', 'page');
$GLOBALS["pbconfig"]['bg_color_enabled_for'] = array('post', 'port', 'page');

#List bg types for pages
$GLOBALS["pbconfig"]['page_bg_available_types'] = array('stretched', 'repeat');

#all_available_headers_for_module
$GLOBALS["pbconfig"]['all_available_headers_for_module'] = array("h1", "h2", "h3", "h4", "h5", "h6");

#all_available_headers_for_module
$GLOBALS["pbconfig"]['all_available_headers_alignment'] = array("center", "left", "right");

#default heading in module
$GLOBALS["pbconfig"]['default_heading_in_module'] = "h3";

#available quote types
$GLOBALS["pbconfig"]['all_available_quote_types'] = array("q_lite" => "Border Colored", "b_dark" => "Border Dark");

#available targets
$GLOBALS["pbconfig"]['all_available_targets'] = array("_self" => "Same window", "_blank" => "New window");

#available animation
$GLOBALS["pbconfig"]['all_available_animation'] = array(
    "none" => "None",
    "pulse" => "Pulse",
    "flipInX" => "flipInX",
    "fadeIn" => "fadeIn",
    "fadeInUp" => "fadeInUp",
    "fadeInDown" => "fadeInDown",
    "fadeInLeft" => "fadeInLeft",
    "fadeInRight" => "fadeInRight",
    "fadeInUpBig" => "fadeInUpBig",
    "fadeInDownBig" => "fadeInDownBig",
    "fadeInLeftBig" => "fadeInLeftBig",
    "fadeInRightBig" => "fadeInRightBig",
    "bounceIn" => "bounceIn",
    "bounceInUp" => "bounceInUp",
    "bounceInDown" => "bounceInDown",
    "bounceInLeft" => "bounceInLeft",
    "bounceInRight" => "bounceInRight",
    "rotateInUpLeft" => "rotateInUpLeft",
    "rotateInDownLeft" => "rotateInDownLeft",
    "rotateInUpRight" => "rotateInUpRight",
    "rotateInDownRight" => "rotateInDownRight",
    "lightSpeedRight" => "lightSpeedRight",
    "lightSpeedLeft" => "lightSpeedLeft",
    "rollin" => "rollin"
);

#gallery
$GLOBALS["pbconfig"]['gallery_module_default_width'] = "100px";
$GLOBALS["pbconfig"]['gallery_module_default_height'] = "150px";

#blog default posts per page
$GLOBALS["pbconfig"]['blog_default_posts_per_page'] = 7;
$GLOBALS["pbconfig"]['blog_masonry_default_posts_per_page'] = 7;
$GLOBALS["pbconfig"]['all_blogpost_types'] = array("fimage-left" => "Featured Image On The Left", "fimage-top" => "Featured Image At The Top");

#featured posts number of posts (not main blog module!)
$GLOBALS["pbconfig"]['featured_posts_default_number_of_posts'] = 12;
$GLOBALS["pbconfig"]['featured_posts_default_posts_per_line'] = 4;
$GLOBALS["pbconfig"]['featured_posts_letters_in_excerpt'] = 130;
$GLOBALS["pbconfig"]['featured_posts_available_post_types'] = array(
    "post" => "Post",
);
$GLOBALS["pbconfig"]['featured_posts_available_sorting_type'] = array("new", "random");

#default video height
$GLOBALS["pbconfig"]['default_video_height'] = "450px";

#default number of workers for team module
$GLOBALS["pbconfig"]['team_default_numbers'] = 20;

#testimonials
$GLOBALS["pbconfig"]['all_available_testimonial_display_type'] = array("type1", "type2");

#all available testimonial sorting type
$GLOBALS["pbconfig"]['all_available_testimonial_sorting_type'] = array("new", "random");

#all available iconboxes
$GLOBALS["pbconfig"]['all_available_iconboxes'] = array("a", "b", "c");

#iconboxes img preview
$GLOBALS["pbconfig"]['iconboxes_img_preview_url'] = "/core/admin/img/available_iconboxes.jpg";

#all available custom list types
$GLOBALS["pbconfig"]['all_available_custom_list_types'] = array(
    "ordered" => "Ordered",
    "list_type1" => "Arrow",
    "list_type2" => "Plus",
    "" => "Normal",
    "list_type3" => "Download",
    "list_type4" => "Print",
    "list_type5" => "Edit",
    "list_type6" => "Attach"
);

#all available custom buttons
$GLOBALS["pbconfig"]['all_available_custom_buttons'] = array(
    "btn_small btn_type1" => "Small Theme Button",
    "btn_small btn_type2" => "Small Theme Button2",
    "btn_small btn_type3" => "Small Theme Button3",
    "btn_small btn_type4" => "Small Theme Button w/arrow",
    "btn_small btn_type5" => "Small Button w/arrow",
    "btn_small btn_type6" => "Small Sea Blue",
    "btn_small btn_type7" => "Small Green",
    "btn_small btn_type8" => "Small Lime",
    "btn_small btn_type9" => "Small Yellow",
    "btn_small btn_type10" => "Small Orange",
    "btn_small btn_type11" => "Small Red",
    "btn_small btn_type12" => "Small Pink",
    "btn_small btn_type13" => "Small Magenta",
    "btn_small btn_type14" => "Small Violet",
    "btn_small btn_type15" => "Small Purple",
	"btn_small btn_type16" => "Small Blue",
	"btn_small btn_type17" => "Small Light Blue",

    "btn_normal btn_type1" => "Medium Theme Button",
    "btn_normal btn_type2" => "Medium Theme Button2",
    "btn_normal btn_type3" => "Medium Theme Button3",
    "btn_normal btn_type4" => "Medium Theme Button w/arrow",
    "btn_normal btn_type5" => "Medium Button w/arrow",
    "btn_normal btn_type6" => "Medium Sea Blue",
    "btn_normal btn_type7" => "Medium Green",
    "btn_normal btn_type8" => "Medium Lime",
    "btn_normal btn_type9" => "Medium Yellow",
    "btn_normal btn_type10" => "Medium Orange",
    "btn_normal btn_type11" => "Medium Red",
    "btn_normal btn_type12" => "Medium Pink",
    "btn_normal btn_type13" => "Medium Magenta",
    "btn_normal btn_type14" => "Medium Violet",
    "btn_normal btn_type15" => "Medium Purple",
	"btn_normal btn_type16" => "Medium Blue",
	"btn_normal btn_type17" => "Medium Light Blue",

    "btn_large btn_type1" => "Large Theme Button",
    "btn_large btn_type2" => "Large Theme Button2",
    "btn_large btn_type3" => "Large Theme Button3",
    "btn_large btn_type4" => "Large Theme Button w/arrow",
    "btn_large btn_type5" => "Large Button w/arrow",	
    "btn_large btn_type6" => "Large Sea Blue",
    "btn_large btn_type7" => "Large Green",
    "btn_large btn_type8" => "Large Lime",
    "btn_large btn_type9" => "Large Yellow",
    "btn_large btn_type10" => "Large Orange",
    "btn_large btn_type11" => "Large Red",
    "btn_large btn_type12" => "Large Pink",
    "btn_large btn_type13" => "Large Magenta",
    "btn_large btn_type14" => "Large Violet",
    "btn_large btn_type15" => "Large Purple",
	"btn_large btn_type16" => "Large Blue",
	"btn_large btn_type17" => "Large Light Blue"
);

#all available custom buttons positions
$GLOBALS["pbconfig"]['all_available_positions_for_custom_buttons'] = array(
    "" => "Default",
    "btnpos_left" => "Left",
    "btnpos_right" => "Right",
    "btnpos_center" => "Center"
);

#all available custom buttons
$GLOBALS["pbconfig"]['all_available_target_for_custom_buttons'] = array(
    "_blank" => "Blank",
    "_self" => "Self"
);

#all available dropcaps
$GLOBALS["pbconfig"]['all_available_dropcaps'] = array(
    "" => "Color",
    "type1" => "Dark"
);

#all available messageboxes
$GLOBALS["pbconfig"]['messagebox_available_types'] = array(
    "box_type1" => "Type 1",
    "box_type2" => "Type 2",
    "box_type3" => "Type 3",
    "box_type4" => "Type 4",
);

#all available highlighters
$GLOBALS["pbconfig"]['all_available_highlighters'] = array(
    "light" => "Light",
    "dark" => "Dark"
);

#all available dividers
$GLOBALS["pbconfig"]['all_available_dividers'] = array(
    "" => "Dotted",
    "type1" => "Light",
    "type2" => "Medium",
		"type3" => "Dark"
);

#all available tabs types
$GLOBALS["pbconfig"]['available_tabs_types'] = array(
    "type1" => "Horizontal",
    "type2" => "Vertical"
);

#all available social icons
$GLOBALS["pbconfig"]['all_available_social_icons'] = array(
);

#all available social icon type
$GLOBALS["pbconfig"]['all_available_social_icons_type'] = array(
    "type1" => "Square",
		"type2" => "Rounded",
		"type3" => "Circle",
		"type4" => "Empty",
		"type5" => "Gradient"
);

#partners number
$GLOBALS["pbconfig"]['partners_default_number'] = 6;

#Padding top for bg start
$GLOBALS["pbconfig"]['available_padding_top_for_bg_start'] = array(
    "top_padding_normal" => "Default (45px)",
    "top_padding_medium" => "20px",
    "top_padding_small" => "15px",
    "top_padding_none" => "0px",
);

#Padding after modules
$GLOBALS["pbconfig"]['default_padding_after_module'] = "35px";

#how many images from media library show on one page
$GLOBALS["pbconfig"]['images_from_media_library'] = 30;

#How many items in OUR TEAM per line
$GLOBALS["pbconfig"]['available_workers_per_line'] = array(
    "1" => "1",
    "2" => "2",
    "3" => "3",
    "4" => "4",
);

#How many items in FEATURED POSTS per line
$GLOBALS["pbconfig"]['available_posts_per_line'] = array(
    "1" => "1",
    "2" => "2",
    "3" => "3",
    "4" => "4",
);

#How many images in a row (in gallery)
$GLOBALS["pbconfig"]['gallery_images_in_a_row'] = array(
    "1" => "1",
    "2" => "2",
    "3" => "3",
    "4" => "4"
);

#All font icons
$GLOBALS["pbconfig"]['all_available_font_icons'] = array(
    "fa fa-glass",
	"fa fa-music",
	"fa fa-search",
	"fa fa-envelope-o",
	"fa fa-heart",
	"fa fa-star",
	"fa fa-star-o",
	"fa fa-user",
	"fa fa-film",
	"fa fa-th-large",
	"fa fa-th",
	"fa fa-th-list",
	"fa fa-check",
	"fa fa-remove",
	"fa fa-close",
	"fa fa-times",
	"fa fa-search-plus",
	"fa fa-search-minus",
	"fa fa-power-off",
	"fa fa-signal",
	"fa fa-gear",
	"fa fa-cog",
	"fa fa-trash-o",
	"fa fa-home",
	"fa fa-file-o",
	"fa fa-clock-o",
	"fa fa-road",
	"fa fa-download",
	"fa fa-arrow-circle-o-down",
	"fa fa-arrow-circle-o-up",
	"fa fa-inbox",
	"fa fa-play-circle-o",
	"fa fa-rotate-right",
	"fa fa-repeat",
	"fa fa-refresh",
	"fa fa-list-alt",
	"fa fa-lock",
	"fa fa-flag",
	"fa fa-headphones",
	"fa fa-volume-off",
	"fa fa-volume-down",
	"fa fa-volume-up",
	"fa fa-qrcode",
	"fa fa-barcode",
	"fa fa-tag",
	"fa fa-tags",
	"fa fa-book",
	"fa fa-bookmark",
	"fa fa-print",
	"fa fa-camera",
	"fa fa-font",
	"fa fa-bold",
	"fa fa-italic",
	"fa fa-text-height",
	"fa fa-text-width",
	"fa fa-align-left",
	"fa fa-align-center",
	"fa fa-align-right",
	"fa fa-align-justify",
	"fa fa-list",
	"fa fa-dedent",
	"fa fa-outdent",
	"fa fa-indent",
	"fa fa-video-camera",
	"fa fa-photo",
	"fa fa-image",
	"fa fa-picture-o",
	"fa fa-pencil",
	"fa fa-map-marker",
	"fa fa-adjust",
	"fa fa-tint",
	"fa fa-edit",
	"fa fa-pencil-square-o",
	"fa fa-share-square-o",
	"fa fa-check-square-o",
	"fa fa-arrows",
	"fa fa-step-backward",
	"fa fa-fast-backward",
	"fa fa-backward",
	"fa fa-play",
	"fa fa-pause",
	"fa fa-stop",
	"fa fa-forward",
	"fa fa-fast-forward",
	"fa fa-step-forward",
	"fa fa-eject",
	"fa fa-chevron-left",
	"fa fa-chevron-right",
	"fa fa-plus-circle",
	"fa fa-minus-circle",
	"fa fa-times-circle",
	"fa fa-check-circle",
	"fa fa-question-circle",
	"fa fa-info-circle",
	"fa fa-crosshairs",
	"fa fa-times-circle-o",
	"fa fa-check-circle-o",
	"fa fa-ban",
	"fa fa-arrow-left",
	"fa fa-arrow-right",
	"fa fa-arrow-up",
	"fa fa-arrow-down",
	"fa fa-mail-forward",
	"fa fa-share",
	"fa fa-expand",
	"fa fa-compress",
	"fa fa-plus",
	"fa fa-minus",
	"fa fa-asterisk",
	"fa fa-exclamation-circle",
	"fa fa-gift",
	"fa fa-leaf",
	"fa fa-fire",
	"fa fa-eye",
	"fa fa-eye-slash",
	"fa fa-warning",
	"fa fa-exclamation-triangle",
	"fa fa-plane",
	"fa fa-calendar",
	"fa fa-random",
	"fa fa-comment",
	"fa fa-magnet",
	"fa fa-chevron-up",
	"fa fa-chevron-down",
	"fa fa-retweet",
	"fa fa-shopping-cart",
	"fa fa-folder",
	"fa fa-folder-open",
	"fa fa-arrows-v",
	"fa fa-arrows-h",
	"fa fa-bar-chart-o",
	"fa fa-bar-chart",
	"fa fa-twitter-square",
	"fa fa-facebook-square",
	"fa fa-camera-retro",
	"fa fa-key",
	"fa fa-gears",
	"fa fa-cogs",
	"fa fa-comments",
	"fa fa-thumbs-o-up",
	"fa fa-thumbs-o-down",
	"fa fa-star-half",
	"fa fa-heart-o",
	"fa fa-sign-out",
	"fa fa-linkedin-square",
	"fa fa-thumb-tack",
	"fa fa-external-link",
	"fa fa-sign-in",
	"fa fa-trophy",
	"fa fa-github-square",
	"fa fa-upload",
	"fa fa-lemon-o",
	"fa fa-phone",
	"fa fa-square-o",
	"fa fa-bookmark-o",
	"fa fa-phone-square",
	"fa fa-twitter",
	"fa fa-facebook-f",
	"fa fa-facebook",
	"fa fa-github",
	"fa fa-unlock",
	"fa fa-credit-card",
	"fa fa-rss",
	"fa fa-hdd-o",
	"fa fa-bullhorn",
	"fa fa-bell",
	"fa fa-certificate",
	"fa fa-hand-o-right",
	"fa fa-hand-o-left",
	"fa fa-hand-o-up",
	"fa fa-hand-o-down",
	"fa fa-arrow-circle-left",
	"fa fa-arrow-circle-right",
	"fa fa-arrow-circle-up",
	"fa fa-arrow-circle-down",
	"fa fa-globe",
	"fa fa-wrench",
	"fa fa-tasks",
	"fa fa-filter",
	"fa fa-briefcase",
	"fa fa-arrows-alt",
	"fa fa-group",
	"fa fa-users",
	"fa fa-chain",
	"fa fa-link",
	"fa fa-cloud",
	"fa fa-flask",
	"fa fa-cut",
	"fa fa-scissors",
	"fa fa-copy",
	"fa fa-files-o",
	"fa fa-paperclip",
	"fa fa-save",
	"fa fa-floppy-o",
	"fa fa-square",
	"fa fa-navicon",
	"fa fa-reorder",
	"fa fa-bars",
	"fa fa-list-ul",
	"fa fa-list-ol",
	"fa fa-strikethrough",
	"fa fa-underline",
	"fa fa-table",
	"fa fa-magic",
	"fa fa-truck",
	"fa fa-pinterest",
	"fa fa-pinterest-square",
	"fa fa-google-plus-square",
	"fa fa-google-plus",
	"fa fa-money",
	"fa fa-caret-down",
	"fa fa-caret-up",
	"fa fa-caret-left",
	"fa fa-caret-right",
	"fa fa-columns",
	"fa fa-unsorted",
	"fa fa-sort",
	"fa fa-sort-down",
	"fa fa-sort-desc",
	"fa fa-sort-up",
	"fa fa-sort-asc",
	"fa fa-envelope",
	"fa fa-linkedin",
	"fa fa-rotate-left",
	"fa fa-undo",
	"fa fa-legal",
	"fa fa-gavel",
	"fa fa-dashboard",
	"fa fa-tachometer",
	"fa fa-comment-o",
	"fa fa-comments-o",
	"fa fa-flash",
	"fa fa-bolt",
	"fa fa-sitemap",
	"fa fa-umbrella",
	"fa fa-paste",
	"fa fa-clipboard",
	"fa fa-lightbulb-o",
	"fa fa-exchange",
	"fa fa-cloud-download",
	"fa fa-cloud-upload",
	"fa fa-user-md",
	"fa fa-stethoscope",
	"fa fa-suitcase",
	"fa fa-bell-o",
	"fa fa-coffee",
	"fa fa-cutlery",
	"fa fa-file-text-o",
	"fa fa-building-o",
	"fa fa-hospital-o",
	"fa fa-ambulance",
	"fa fa-medkit",
	"fa fa-fighter-jet",
	"fa fa-beer",
	"fa fa-h-square",
	"fa fa-plus-square",
	"fa fa-angle-double-left",
	"fa fa-angle-double-right",
	"fa fa-angle-double-up",
	"fa fa-angle-double-down",
	"fa fa-angle-left",
	"fa fa-angle-right",
	"fa fa-angle-up",
	"fa fa-angle-down",
	"fa fa-desktop",
	"fa fa-laptop",
	"fa fa-tablet",
	"fa fa-mobile-phone",
	"fa fa-mobile",
	"fa fa-circle-o",
	"fa fa-quote-left",
	"fa fa-quote-right",
	"fa fa-spinner",
	"fa fa-circle",
	"fa fa-mail-reply",
	"fa fa-reply",
	"fa fa-github-alt",
	"fa fa-folder-o",
	"fa fa-folder-open-o",
	"fa fa-smile-o",
	"fa fa-frown-o",
	"fa fa-meh-o",
	"fa fa-gamepad",
	"fa fa-keyboard-o",
	"fa fa-flag-o",
	"fa fa-flag-checkered",
	"fa fa-terminal",
	"fa fa-code",
	"fa fa-mail-reply-all",
	"fa fa-reply-all",
	"fa fa-star-half-empty",
	"fa fa-star-half-full",
	"fa fa-star-half-o",
	"fa fa-location-arrow",
	"fa fa-crop",
	"fa fa-code-fork",
	"fa fa-unlink",
	"fa fa-chain-broken",
	"fa fa-question",
	"fa fa-info",
	"fa fa-exclamation",
	"fa fa-superscript",
	"fa fa-subscript",
	"fa fa-eraser",
	"fa fa-puzzle-piece",
	"fa fa-microphone",
	"fa fa-microphone-slash",
	"fa fa-shield",
	"fa fa-calendar-o",
	"fa fa-fire-extinguisher",
	"fa fa-rocket",
	"fa fa-maxcdn",
	"fa fa-chevron-circle-left",
	"fa fa-chevron-circle-right",
	"fa fa-chevron-circle-up",
	"fa fa-chevron-circle-down",
	"fa fa-html5",
	"fa fa-css3",
	"fa fa-anchor",
	"fa fa-unlock-alt",
	"fa fa-bullseye",
	"fa fa-ellipsis-h",
	"fa fa-ellipsis-v",
	"fa fa-rss-square",
	"fa fa-play-circle",
	"fa fa-ticket",
	"fa fa-minus-square",
	"fa fa-minus-square-o",
	"fa fa-level-up",
	"fa fa-level-down",
	"fa fa-check-square",
	"fa fa-pencil-square",
	"fa fa-external-link-square",
	"fa fa-share-square",
	"fa fa-compass",
	"fa fa-toggle-down",
	"fa fa-caret-square-o-down",
	"fa fa-toggle-up",
	"fa fa-caret-square-o-up",
	"fa fa-toggle-right",
	"fa fa-caret-square-o-right",
	"fa fa-euro",
	"fa fa-eur",
	"fa fa-gbp",
	"fa fa-dollar",
	"fa fa-usd",
	"fa fa-rupee",
	"fa fa-inr",
	"fa fa-cny",
	"fa fa-rmb",
	"fa fa-yen",
	"fa fa-jpy",
	"fa fa-ruble",
	"fa fa-rouble",
	"fa fa-rub",
	"fa fa-won",
	"fa fa-krw",
	"fa fa-bitcoin",
	"fa fa-btc",
	"fa fa-file",
	"fa fa-file-text",
	"fa fa-sort-alpha-asc",
	"fa fa-sort-alpha-desc",
	"fa fa-sort-amount-asc",
	"fa fa-sort-amount-desc",
	"fa fa-sort-numeric-asc",
	"fa fa-sort-numeric-desc",
	"fa fa-thumbs-up",
	"fa fa-thumbs-down",
	"fa fa-youtube-square",
	"fa fa-youtube",
	"fa fa-xing",
	"fa fa-xing-square",
	"fa fa-youtube-play",
	"fa fa-dropbox",
	"fa fa-stack-overflow",
	"fa fa-instagram",
	"fa fa-flickr",
	"fa fa-adn",
	"fa fa-bitbucket",
	"fa fa-bitbucket-square",
	"fa fa-tumblr",
	"fa fa-tumblr-square",
	"fa fa-long-arrow-down",
	"fa fa-long-arrow-up",
	"fa fa-long-arrow-left",
	"fa fa-long-arrow-right",
	"fa fa-apple",
	"fa fa-windows",
	"fa fa-android",
	"fa fa-linux",
	"fa fa-dribbble",
	"fa fa-skype",
	"fa fa-foursquare",
	"fa fa-trello",
	"fa fa-female",
	"fa fa-male",
	"fa fa-gittip",
	"fa fa-gratipay",
	"fa fa-sun-o",
	"fa fa-moon-o",
	"fa fa-archive",
	"fa fa-bug",
	"fa fa-vk",
	"fa fa-weibo",
	"fa fa-renren",
	"fa fa-pagelines",
	"fa fa-stack-exchange",
	"fa fa-arrow-circle-o-right",
	"fa fa-arrow-circle-o-left",
	"fa fa-toggle-left",
	"fa fa-caret-square-o-left",
	"fa fa-dot-circle-o",
	"fa fa-wheelchair",
	"fa fa-vimeo-square",
	"fa fa-turkish-lira",
	"fa fa-try",
	"fa fa-plus-square-o",
	"fa fa-space-shuttle",
	"fa fa-slack",
	"fa fa-envelope-square",
	"fa fa-wordpress",
	"fa fa-openid",
	"fa fa-institution",
	"fa fa-bank",
	"fa fa-university",
	"fa fa-mortar-board",
	"fa fa-graduation-cap",
	"fa fa-yahoo",
	"fa fa-google",
	"fa fa-reddit",
	"fa fa-reddit-square",
	"fa fa-stumbleupon-circle",
	"fa fa-stumbleupon",
	"fa fa-delicious",
	"fa fa-digg",
	"fa fa-pied-piper",
	"fa fa-pied-piper-alt",
	"fa fa-drupal",
	"fa fa-joomla",
	"fa fa-language",
	"fa fa-fax",
	"fa fa-building",
	"fa fa-child",
	"fa fa-paw",
	"fa fa-spoon",
	"fa fa-cube",
	"fa fa-cubes",
	"fa fa-behance",
	"fa fa-behance-square",
	"fa fa-steam",
	"fa fa-steam-square",
	"fa fa-recycle",
	"fa fa-automobile",
	"fa fa-car",
	"fa fa-cab",
	"fa fa-taxi",
	"fa fa-tree",
	"fa fa-spotify",
	"fa fa-deviantart",
	"fa fa-soundcloud",
	"fa fa-database",
	"fa fa-file-pdf-o",
	"fa fa-file-word-o",
	"fa fa-file-excel-o",
	"fa fa-file-powerpoint-o",
	"fa fa-file-photo-o",
	"fa fa-file-picture-o",
	"fa fa-file-image-o",
	"fa fa-file-zip-o",
	"fa fa-file-archive-o",
	"fa fa-file-sound-o",
	"fa fa-file-audio-o",
	"fa fa-file-movie-o",
	"fa fa-file-video-o",
	"fa fa-file-code-o",
	"fa fa-vine",
	"fa fa-codepen",
	"fa fa-jsfiddle",
	"fa fa-life-bouy",
	"fa fa-life-buoy",
	"fa fa-life-saver",
	"fa fa-support",
	"fa fa-life-ring",
	"fa fa-circle-o-notch",
	"fa fa-ra",
	"fa fa-rebel",
	"fa fa-ge",
	"fa fa-empire",
	"fa fa-git-square",
	"fa fa-git",
	"fa fa-hacker-news",
	"fa fa-tencent-weibo",
	"fa fa-qq",
	"fa fa-wechat",
	"fa fa-weixin",
	"fa fa-send",
	"fa fa-paper-plane",
	"fa fa-send-o",
	"fa fa-paper-plane-o",
	"fa fa-history",
	"fa fa-genderless",
	"fa fa-circle-thin",
	"fa fa-header",
	"fa fa-paragraph",
	"fa fa-sliders",
	"fa fa-share-alt",
	"fa fa-share-alt-square",
	"fa fa-bomb",
	"fa fa-soccer-ball-o",
	"fa fa-futbol-o",
	"fa fa-tty",
	"fa fa-binoculars",
	"fa fa-plug",
	"fa fa-slideshare",
	"fa fa-twitch",
	"fa fa-yelp",
	"fa fa-newspaper-o",
	"fa fa-wifi",
	"fa fa-calculator",
	"fa fa-paypal",
	"fa fa-google-wallet",
	"fa fa-cc-visa",
	"fa fa-cc-mastercard",
	"fa fa-cc-discover",
	"fa fa-cc-amex",
	"fa fa-cc-paypal",
	"fa fa-cc-stripe",
	"fa fa-bell-slash",
	"fa fa-bell-slash-o",
	"fa fa-trash",
	"fa fa-copyright",
	"fa fa-at",
	"fa fa-eyedropper",
	"fa fa-paint-brush",
	"fa fa-birthday-cake",
	"fa fa-area-chart",
	"fa fa-pie-chart",
	"fa fa-line-chart",
	"fa fa-lastfm",
	"fa fa-lastfm-square",
	"fa fa-toggle-off",
	"fa fa-toggle-on",
	"fa fa-bicycle",
	"fa fa-bus",
	"fa fa-ioxhost",
	"fa fa-angellist",
	"fa fa-cc",
	"fa fa-shekel",
	"fa fa-sheqel",
	"fa fa-ils",
	"fa fa-meanpath",
	"fa fa-buysellads",
	"fa fa-connectdevelop",
	"fa fa-dashcube",
	"fa fa-forumbee",
	"fa fa-leanpub",
	"fa fa-sellsy",
	"fa fa-shirtsinbulk",
	"fa fa-simplybuilt",
	"fa fa-skyatlas",
	"fa fa-cart-plus",
	"fa fa-cart-arrow-down",
	"fa fa-diamond",
	"fa fa-ship",
	"fa fa-user-secret",
	"fa fa-motorcycle",
	"fa fa-street-view",
	"fa fa-heartbeat",
	"fa fa-venus",
	"fa fa-mars",
	"fa fa-mercury",
	"fa fa-transgender",
	"fa fa-transgender-alt",
	"fa fa-venus-double",
	"fa fa-mars-double",
	"fa fa-venus-mars",
	"fa fa-mars-stroke",
	"fa fa-mars-stroke-v",
	"fa fa-mars-stroke-h",
	"fa fa-neuter",
	"fa fa-facebook-official",
	"fa fa-pinterest-p",
	"fa fa-whatsapp",
	"fa fa-server",
	"fa fa-user-plus",
	"fa fa-user-times",
	"fa fa-hotel",
	"fa fa-bed",
	"fa fa-viacoin",
	"fa fa-train",
	"fa fa-subway",
	"fa fa-medium",
);

// --------extended version start --------
$GLOBALS["pbconfig"]["extended_mode"] = 'on';
// --------extended version end --------

global $compileShortcodeUI, $defaultUI;
$compileShortcodeUI = "";
$defaultUI = "";

?>