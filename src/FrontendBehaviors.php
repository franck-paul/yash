<?php

/**
 * @brief yash, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul contact@open-time.net
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
        if ($settings->getBool('active')) {
            $css = '';

            $custom_css = $settings->getStr('custom_css', false);
            if ($custom_css !== '') {
                if (str_starts_with($custom_css, '/')) {
                    $css = $custom_css;
                } else {
                    $theme_url = App::blog()->settings()->get('system')->getStr('themes_url', false);
                    $theme     = App::blog()->settings()->get('system')->getStr('theme', false);
                    if ($theme_url !== '' && $theme !== '') {
                        $css = $theme_url . '/' . $theme . '/' . $custom_css;
                    }
                }
            } else {
                $theme = $settings->getStr('theme', false);
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
        if ($settings->getBool('active')) {
            echo
            My::jsLoad('/syntaxhighlighter/js/shCore.js') .
            My::jsLoad('/syntaxhighlighter/js/shAutoloader.js') .
            Html::jsJson('yash_config', [
                'path'   => App::blog()->getPF(My::id() . '/syntaxhighlighter/js/'),
                'gutter' => !$settings->getBool('hide_gutter', false),
            ]) .
            My::jsLoad('public.js');
        }

        return '';
    }
}
