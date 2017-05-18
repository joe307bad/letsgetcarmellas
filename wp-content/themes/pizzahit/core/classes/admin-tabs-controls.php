<?php

/**
 * Tab_admin_theme class
 */
class Tabs_admin_theme
{
    private $template = '
    <div class="admin_mix-container">
        <div class="admin_mix-tabs-list">
            <ul class="admin_l-mix-tabs-list">
                {$LINKS}
            </ul>
        </div>
        <div class="admin_mix-tabs">
            <div class="admin_mix-tabs-inner">
                <div class="gt3_admin_head_caption">
                    <div class="gt3_innerpadding">
                        If you want to save all the changes that you\'ve made, please click "Save Settings". Please note "Reset Settings" will reset all the settings to default.
                    </div>
                </div>
                <div class="gt3_admin_head_buttons">
                    <div class="gt3_innerpadding">
                        <div class="theme_settings_submit_cont">
                            <input type="button" name="reset_theme_settings" class="admin_reset_settings gt3_admin_button gt3_admin_danger_btn" value="Reset Settings" />
                            <input type="submit" name="submit_theme_settings" class="gt3_admin_save_all gt3_admin_button gt3_admin_ok_btn" value="Save Settings" />
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <input type="hidden" id="form-tab-action" name="action" value="save" />

                {$TABS}

                <div class="theme_settings_submit_cont albotoom">
                    <input type="button" name="reset_theme_settings" class="admin_reset_settings gt3_admin_button gt3_admin_danger_btn" value="Reset Settings" />
                    <input type="submit" name="submit_theme_settings" class="gt3_admin_save_all gt3_admin_button gt3_admin_ok_btn" value="Save Settings" />
                </div>
            </div>
        </div>
        <div class="clear"></div>
	</div>';

    private $vars = array(
        '{$LINKS}',
        '{$TABS}'
    );

    private $tabs = array();

    public function __construct()
    {

    }

    public function add(Tab_admin_theme $tab)
    {
        $this->tabs[] = $tab;
    }

    public function render()
    {
        $links = array();
        $tabs = array();
        foreach ($this->tabs as $tab) {
            $links[] = $tab->render_link();
            $tabs[] = $tab->render_tab();
        }

        return str_replace($this->vars, array(
            implode(' ', $links),
            implode(' ', $tabs)
        ), $this->template);
    }

    public function save()
    {
        foreach ($this->tabs as $tab) {
            $tab->save();
        }
    }

    public function reset($tab_id)
    {
        if (strtolower($tab_id) === 'all') {
            foreach ($this->tabs as $tab) {
                $tab->reset(TRUE);
            }
        } else {
            foreach ($this->tabs as $tab) {
                if ($tab_id == $tab->id()) {
                    $tab->reset();
                }
            }
        }
    }

    public function reset_to_default()
    {
        foreach ($this->tabs as $tab) {
            $tab->reset(TRUE);
        }
    }
}


/**
 * end of file
 */
?>