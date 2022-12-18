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
if (!defined('DC_CONTEXT_ADMIN')) {
    return;
}

if (!dcCore::app()->newVersion(basename(__DIR__), dcCore::app()->plugins->moduleInfo(basename(__DIR__), 'version'))) {
    return;
}

try {
    dcCore::app()->blog->settings->addNamespace('yash');
    dcCore::app()->blog->settings->yash->put('yash_active', false, 'boolean', '', false, true);
    dcCore::app()->blog->settings->yash->put('yash_theme', 'Default', 'string', '', false, true);
    dcCore::app()->blog->settings->yash->put('yash_custom_css', '', 'string', '', false, true);
    dcCore::app()->blog->settings->yash->put('yash_hide_gutter', false, 'boolean', '', false, true);
    dcCore::app()->blog->settings->yash->put('yash_syntaxehl', false, 'boolean', '', false, true);

    return true;
} catch (Exception $e) {
    dcCore::app()->error->add($e->getMessage());
}

return false;
