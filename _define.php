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

$this->registerModule(
    "YASH",                           // Name
    "Yet Another Syntax Highlighter", // Description
    "Pep and contributors",           // Author
    '1.7',                            // Version
    array(
        'requires'    => array(array('core', '2.9')),               // Dependencies
        'permissions' => 'contentadmin',                            // Permissions
        'priority'    => 1001,                                      // Must be higher than dcLegacyEditor priority (ie 1000) // Priority
        'type'        => 'plugin',                                  // Type
        'details'     => 'https://open-time.net/docs/plugins/yash' // Details
    )
);
