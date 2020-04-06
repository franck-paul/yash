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

if (!defined('DC_RC_PATH')) {return;}

$core->addBehavior('publicHeadContent', ['dcYASH', 'publicHeadContent']);
$core->addBehavior('publicFooterContent', ['dcYASH', 'publicFooterContent']);

class dcYASH
{
    public static function publicHeadContent()
    {
        global $core;

        $core->blog->settings->addNamespace('yash');
        if ($core->blog->settings->yash->yash_active) {
            $custom_css = $core->blog->settings->yash->yash_custom_css;
            if (!empty($custom_css)) {
                if (strpos('/', $custom_css) === 0) {
                    $css = $custom_css;
                } else {
                    $css =
                    $core->blog->settings->system->themes_url . "/" .
                    $core->blog->settings->system->theme . "/" .
                        $custom_css;
                }
            } else {
                $theme = (string) $core->blog->settings->yash->yash_theme;
                if ($theme == '') {
                    $css = $core->blog->getPF('yash/syntaxhighlighter/css/shThemeDefault.css');
                } else {
                    $css = $core->blog->getPF('yash/syntaxhighlighter/css/shTheme' . $theme . '.css');
                }
            }
            echo
            dcUtils::cssLoad($core->blog->getPF('yash/syntaxhighlighter/css/shCore.css')) .
            dcUtils::cssLoad($css);
        }
    }

    public static function publicFooterContent()
    {
        global $core;

        $core->blog->settings->addNamespace('yash');
        if ($core->blog->settings->yash->yash_active) {
            echo
            dcUtils::jsLoad($core->blog->getPF('yash/syntaxhighlighter/js/shCore.js')) .
            dcUtils::jsLoad($core->blog->getPF('yash/syntaxhighlighter/js/shAutoloader.js')) .
            dcUtils::jsJson('yash_config', [
                'path' => $core->blog->getPF('yash/syntaxhighlighter/js/'),
                'gutter' => $core->blog->settings->yash->yash_hide_gutter ? false : true
            ]) .
            dcUtils::jsLoad($core->blog->getPF('yash/js/public.js'));
        }
    }
}
