<?php
/**
 * @brief YASH, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Pep
 * @author Franck Paul
 *
 * @copyright Pep
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
if (!defined('DC_RC_PATH')) {
    return;
}

dcCore::app()->addBehavior('publicHeadContent', ['dcYASH', 'publicHeadContent']);
dcCore::app()->addBehavior('publicFooterContent', ['dcYASH', 'publicFooterContent']);

class dcYASH
{
    public static function publicHeadContent()
    {
        dcCore::app()->blog->settings->addNamespace('yash');
        if (dcCore::app()->blog->settings->yash->yash_active) {
            $custom_css = dcCore::app()->blog->settings->yash->yash_custom_css;
            if (!empty($custom_css)) {
                if (strpos('/', $custom_css) === 0) {
                    $css = $custom_css;
                } else {
                    $css = dcCore::app()->blog->settings->system->themes_url . '/' .
                    dcCore::app()->blog->settings->system->theme . '/' .
                        $custom_css;
                }
            } else {
                $theme = (string) dcCore::app()->blog->settings->yash->yash_theme;
                if ($theme == '') {
                    $css = dcCore::app()->blog->getPF('yash/syntaxhighlighter/css/shThemeDefault.css');
                } else {
                    $css = dcCore::app()->blog->getPF('yash/syntaxhighlighter/css/shTheme' . $theme . '.css');
                }
            }
            echo
            dcUtils::cssModuleLoad('yash/syntaxhighlighter/css/shCore.css') .
            dcUtils::cssLoad($css);
        }
    }

    public static function publicFooterContent()
    {
        dcCore::app()->blog->settings->addNamespace('yash');
        if (dcCore::app()->blog->settings->yash->yash_active) {
            echo
            dcUtils::jsModuleLoad('yash/syntaxhighlighter/js/shCore.js') .
            dcUtils::jsModuleLoad('yash/syntaxhighlighter/js/shAutoloader.js') .
            dcUtils::jsJson('yash_config', [
                'path'   => dcCore::app()->blog->getPF('yash/syntaxhighlighter/js/'),
                'gutter' => dcCore::app()->blog->settings->yash->yash_hide_gutter ? false : true,
            ]) .
            dcUtils::jsModuleLoad('yash/js/public.js');
        }
    }
}
