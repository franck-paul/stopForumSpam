<?php
/**
 * @brief stopforumspam, an antispam filter plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
if (!defined('DC_RC_PATH')) {
    return;
}

$this->registerModule(
    'Stop Forum Spam',                                     // Name
    'Stop Forum Spam filter for antispam Dotclear plugin', // Description
    'Franck Paul',                                         // Author
    '0.3',                                                 // Version
    [
        'requires'    => [['core', '2.13']], // Dependencies
        'permissions' => 'usage,contentadmin',
        'priority'    => 200,
        'type'        => 'plugin',

        'details'    => 'https://open-time.net/?q=stopForumSpam',       // Details URL
        'support'    => 'https://github.com/franck-paul/stopForumSpam', // Support URL
        'repository' => 'https://raw.githubusercontent.com/franck-paul/stopForumSpam/main/dcstore.xml'
    ]
);
