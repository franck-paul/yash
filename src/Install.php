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
use Dotclear\Helper\Process\TraitProcess;
use Dotclear\Interface\Core\BlogWorkspaceInterface;
use Exception;

class Install
{
    use TraitProcess;

    public static function init(): bool
    {
        return self::status(My::checkContext(My::INSTALL));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        try {
            // Update
            $old_version = App::version()->getVersion(My::id());
            if (version_compare((string) $old_version, '3.0', '<')) {
                // Change settings names (remove yash_ prefix in them)
                $rename = static function (string $name, BlogWorkspaceInterface $settings): void {
                    if ($settings->settingExists('yash_' . $name, true)) {
                        $settings->rename('yash_' . $name, $name);
                    }
                };
                $settings = My::settings();
                foreach (['active', 'theme', 'custom_css', 'hide_gutter', 'syntaxehl'] as $name) {
                    $rename($name, $settings);
                }
            }

            // Init
            $settings = My::settings();
            $settings->put('active', false, App::blogWorkspace()::NS_BOOL, '', false, true);
            $settings->put('theme', 'Default', App::blogWorkspace()::NS_STRING, '', false, true);
            $settings->put('custom_css', '', App::blogWorkspace()::NS_STRING, '', false, true);
            $settings->put('hide_gutter', false, App::blogWorkspace()::NS_BOOL, '', false, true);
            $settings->put('syntaxehl', false, App::blogWorkspace()::NS_BOOL, '', false, true);
        } catch (Exception $exception) {
            App::error()->add($exception->getMessage());
        }

        return true;
    }
}
