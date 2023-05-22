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
$this->registerModule(
    'Stop Forum Spam',
    'Stop Forum Spam filter for antispam Dotclear plugin',
    'Franck Paul',
    '2.1',
    [
        'requires'    => [['core', '2.26']],
        'permissions' => dcCore::app()->auth->makePermissions([
            dcAuth::PERMISSION_USAGE,
            dcAuth::PERMISSION_CONTENT_ADMIN,
        ]),
        'priority' => 200,
        'type'     => 'plugin',

        'details'    => 'https://open-time.net/?q=stopForumSpam',
        'support'    => 'https://github.com/franck-paul/stopForumSpam',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/stopForumSpam/master/dcstore.xml',
    ]
);
