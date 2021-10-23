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

$this->registerModule(
    'YASH',                           // Name
    'Yet Another Syntax Highlighter', // Description
    'Pep and contributors',           // Author
    '1.11',                           // Version
    [
        'requires'    => [['core', '2.19']],   // Dependencies
        'permissions' => 'contentadmin',       // Permissions
        'priority'    => 1001,                 // Must be higher than dcLegacyEditor priority (ie 1000)
        'type'        => 'plugin',             // Type
        'settings'    => [
            'self' => ''
        ],

        'details'    => 'https://open-time.net/?q=yash',       // Details URL
        'support'    => 'https://github.com/franck-paul/yash', // Support URL
        'repository' => 'https://raw.githubusercontent.com/franck-paul/yash/main/dcstore.xml'
    ]
);
