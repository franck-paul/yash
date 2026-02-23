<?php

/**
 * @brief yash, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\yash;

use Dotclear\App;
use Dotclear\Helper\Html\Html;

class FrontendBehaviors
{
    public static function publicHeadContent(): string
    {
        $settings = My::settings();
        if ($settings->active) {
            $css = '';

            $custom_css = is_string($custom_css = $settings->custom_css) ? $custom_css : '';
            if ($custom_css !== '') {
                if (str_starts_with($custom_css, '/')) {
                    $css = $custom_css;
                } else {
                    $theme_url = is_string($theme_url = App::blog()->settings()->system->themes_url) ? $theme_url : '';
                    $theme     = is_string($theme = App::blog()->settings()->system->theme) ? $theme : '';
                    if ($theme_url !== '' && $theme !== '') {
                        $css = $theme_url . '/' . $theme . '/' . $custom_css;
                    }
                }
            } else {
                $theme = is_string($theme = $settings->theme) ? $theme : '';
                $css   = $theme === '' ?
                    My::cssLoad('/syntaxhighlighter/css/shThemeDefault.css') :
                    My::cssLoad('/syntaxhighlighter/css/shTheme' . $theme . '.css');
            }

            echo
            My::cssLoad('/syntaxhighlighter/css/shCore.css') .
            $css;
        }

        return '';
    }

    public static function publicFooterContent(): string
    {
        $settings = My::settings();
        if ($settings->active) {
            echo
            My::jsLoad('/syntaxhighlighter/js/shCore.js') .
            My::jsLoad('/syntaxhighlighter/js/shAutoloader.js') .
            Html::jsJson('yash_config', [
                'path'   => App::blog()->getPF(My::id() . '/syntaxhighlighter/js/'),
                'gutter' => !(bool) $settings->hide_gutter,
            ]) .
            My::jsLoad('public.js');
        }

        return '';
    }
}
