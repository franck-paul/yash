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

use dcCore;
use dcNamespace;
use dcNsProcess;
use Exception;

class Install extends dcNsProcess
{
    protected static $init = false; /** @deprecated since 2.27 */
    public static function init(): bool
    {
        static::$init = My::checkContext(My::INSTALL);

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        try {
            // Update
            $old_version = dcCore::app()->getVersion(My::id());
            if (version_compare((string) $old_version, '3.0', '<')) {
                // Change settings names (remove yash_ prefix in them)
                $rename = function (string $name, dcNamespace $settings): void {
                    if ($settings->settingExists('yash_' . $name, true)) {
                        $settings->rename('yash_' . $name, $name);
                    }
                };
                $settings = dcCore::app()->blog->settings->get(My::id());
                foreach (['active', 'theme', 'custom_css', 'hide_gutter', 'syntaxehl'] as $name) {
                    $rename($name, $settings);
                }
            }

            // Init
            $settings = dcCore::app()->blog->settings->get(My::id());
            $settings->put('active', false, dcNamespace::NS_BOOL, '', false, true);
            $settings->put('theme', 'Default', dcNamespace::NS_STRING, '', false, true);
            $settings->put('custom_css', '', dcNamespace::NS_STRING, '', false, true);
            $settings->put('hide_gutter', false, dcNamespace::NS_BOOL, '', false, true);
            $settings->put('syntaxehl', false, dcNamespace::NS_BOOL, '', false, true);
        } catch (Exception $e) {
            dcCore::app()->error->add($e->getMessage());
        }

        return true;
    }
}
