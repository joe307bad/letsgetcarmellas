<?php
if (is_active_sidebar('page-sidebar-1')) {
	global $gt3_theme_pagebuilder;

	if (isset($gt3_theme_pagebuilder['settings']['layout-sidebars']) && $gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar") {
	    echo "<div class='left-sidebar-block'>";
	    dynamic_sidebar((isset($gt3_theme_pagebuilder['settings']['selected-sidebar-name']) ? $gt3_theme_pagebuilder['settings']['selected-sidebar-name'] : "Default"));
	    echo "</div>";
	}
}

?>